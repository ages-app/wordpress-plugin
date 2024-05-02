<?php
/**
 * Ages Script Loader
 *
 * @package Ages
 * @since 1.0.0
 */

namespace Ages\WP;

defined( 'ABSPATH' ) || exit;

/**
 * Script Class
 */
class Script {
	/**
	 * Registers callback for loading the JavaScript
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public static function run(): void {
		add_action( 'wp_enqueue_scripts', array( self::class, 'load_widget_scripts' ) );
	}

	/**
	 * Registers the Ages widget script
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public static function load_widget_scripts(): void {
		$company_hash_id = get_option( Constant::OPTION_NAME_COMPANY_HASH_ID );
		$enabled         = get_option( Constant::OPTION_NAME_ENABLED );

		if ( ( 1 === (int) $enabled ) && strlen( $company_hash_id ) ) {
			wp_enqueue_script( 'ages-wp-widget-loader', esc_js( self::get_widget_loader_url() ), array(), '1.0.0', array( 'strategy' => 'async' ) );
			$data = 'window.agconfig = {companyId: "' . esc_js( $company_hash_id ) . '"};';
			wp_add_inline_script( 'ages-wp-widget-loader', $data );
		}
	}

	/**
	 * Returns the Ages Chat Widget loader URI based on the "Test Mode" value
	 *
	 * @since 1.0.0
	 *
	 * @return string
	 */
	private static function get_widget_loader_url(): string {
		$test_mode = get_option( Constant::OPTION_NAME_TEST_MODE );
		if ( 1 === (int) $test_mode ) {
			return Constant::TEST_MODE_URL;
		}
		return Constant::LIVE_MODE_URL;
	}
}
