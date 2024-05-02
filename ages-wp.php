<?php
/**
 * Plugin Name: Ages WordPress Plugin
 * Description: A plugin for integrating the Ages Chat Widget app with WooCommerce plugin.
 * Author: Ages Developers
 * Author URI: https://www.ages.app/
 * Version: 1.0.0
 * Text Domain: ages
 * Domain Path: /languages/
 * Requires at least: 6.3
 * Requires PHP: 7.4
 *
 * @package Ages
 */

namespace Ages\WP;

defined( 'ABSPATH' ) || exit;

if ( ! file_exists( __DIR__ . '/vendor/autoload.php' ) ) {
	die( 'Ages core library not found' );
}

require_once __DIR__ . '/vendor/autoload.php';

if ( ! defined( 'AGES_WP_FILE' ) ) {
	define( 'AGES_WP_FILE', __FILE__ );
}

/**
 * Ages_Loader class
 *
 * - Instantiates the plugin
 * - Checks the PHP and WordPress environment requirements when the plugin gets activated
 * - Initializes the setting options values when the plugin is activated
 * - Removes the setting options values when the plugin is deactivated
 */
class Ages_Loader {
	/**
	 * Sets the activation and deactivation hooks for the plugin
	 * Loads other classes
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public static function run(): void {
		register_activation_hook( AGES_WP_FILE, array( self::class, 'on_activation' ) );
		register_deactivation_hook( AGES_WP_FILE, array( self::class, 'on_deactivation' ) );

		add_action( 'plugins_loaded', array( self::class, 'plugins_loaded' ) );
	}

	/**
	 * Loads the classes for the admin settings and loading the widget on the front pages
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public static function plugins_loaded(): void {
		load_plugin_textdomain(
			'ages',
			false,
			basename( dirname( AGES_WP_FILE ) ) . '/languages'
		);

		Admin\Settings::run();
		Script::run();
	}

	/**
	 * Runs checks upon activation of the plugin
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public static function on_activation(): void {
		if ( ! self::is_php_environment_compatible() ) {
			wp_die( esc_html( Constant::AGES_WP_NAME . __( ' could not be activated. ', 'ages' ) . self::get_php_version_incompatible_message() ) );
		}

		if ( ! self::is_wordpress_environment_compatible() ) {
			wp_die( esc_html( Constant::AGES_WP_NAME . __( ' could not be activated. ', 'ages' ) . self::get_wordpress_version_incompatible_message() ) );
		}

		// Initialize setting options.
		add_option( Constant::OPTION_NAME_TEST_MODE, 0 );
		add_option( Constant::OPTION_NAME_COMPANY_HASH_ID, '' );
		add_option( Constant::OPTION_NAME_ENABLED, 0 );
	}

	/**
	 * Runs housekeeping upon deactivation of the plugin
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public static function on_deactivation(): void {
		// Delete setting options.
		delete_option( Constant::OPTION_NAME_TEST_MODE );
		delete_option( Constant::OPTION_NAME_COMPANY_HASH_ID );
		delete_option( Constant::OPTION_NAME_ENABLED );
	}

	/**
	 * Checks if the installed PHP version is compatible with the plugin's minimum requirement
	 *
	 * @since 1.0.0
	 *
	 * @return bool
	 */
	private static function is_php_environment_compatible(): bool {

		return version_compare( PHP_VERSION, Constant::MINIMUM_PHP_VERSION ) >= 0;
	}

	/**
	 * Checks if the installed WordPress version is compatible with the plugin's minimum requirement
	 *
	 * @since 1.0.0
	 *
	 * @return bool
	 */
	private static function is_wordpress_environment_compatible(): bool {

		return version_compare( get_bloginfo( 'version' ), Constant::MINIMUM_WP_VERSION ) >= 0;
	}

	/**
	 * Returns the PHP version incompatibility error message
	 *
	 * @since 1.0.0
	 *
	 * @return string
	 */
	private static function get_php_version_incompatible_message(): string {

		return sprintf( 'The minimum PHP version required for this plugin is %1$s. You are running %2$s.', Constant::MINIMUM_PHP_VERSION, PHP_VERSION );
	}

	/**
	 * Returns the WordPress version incompatibility error message
	 *
	 * @since 1.0.0
	 *
	 * @return string
	 */
	private static function get_wordpress_version_incompatible_message(): string {

		return sprintf( 'The minimum WordPress version required for this plugin is %1$s. You are running %2$s.', Constant::MINIMUM_WP_VERSION, get_bloginfo( 'version' ) );
	}
}

// Run the plugin.
Ages_Loader::run();
