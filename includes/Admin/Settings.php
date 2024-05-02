<?php
/**
 * Ages Admin Settings Page
 *
 * @package Ages\Admin
 * @version 1.0.0
 */

namespace Ages\WP\Admin;

use Ages\WP\Constant;

defined( 'ABSPATH' ) || exit;

/**
 * Admin Settings Class
 */
class Settings {
	/**
	 * The plugin slug name
	 *
	 * @since 1.0.0
	 *
	 * @var string PAGE_SLUG_NAME
	 */
	const PAGE_SLUG_NAME = 'ages-wp';

	/**
	 * Registers callbacks for loading the admin settings option and menu item
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public static function run(): void {
		add_action( 'admin_init', array( self::class, 'settings_init' ) );
		add_action( 'admin_menu', array( self::class, 'add_admin_menu' ) );
	}

	/**
	 * Registers the settings options and their data
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public static function settings_init(): void {
		$settings_section_id = 'ages_wp_settings_section';

		register_setting( Constant::OPTION_GROUP, Constant::OPTION_NAME_COMPANY_HASH_ID );
		register_setting( Constant::OPTION_GROUP, Constant::OPTION_NAME_TEST_MODE );
		register_setting( Constant::OPTION_GROUP, Constant::OPTION_NAME_ENABLED );

		add_settings_section(
			$settings_section_id,
			__( 'Chat Widget Settings', 'ages' ),
			'',
			self::PAGE_SLUG_NAME
		);

		add_settings_field(
			Constant::OPTION_NAME_TEST_MODE,
			__( 'Test Mode', 'ages' ),
			array( self::class, 'settings_field_test_mode' ),
			self::PAGE_SLUG_NAME,
			$settings_section_id,
			array( 'label_for' => Constant::OPTION_NAME_TEST_MODE )
		);

		add_settings_field(
			Constant::OPTION_NAME_COMPANY_HASH_ID,
			__( 'Company Hash ID', 'ages' ),
			array( self::class, 'settings_field_company_hash_id' ),
			self::PAGE_SLUG_NAME,
			$settings_section_id,
			array( 'label_for' => Constant::OPTION_NAME_COMPANY_HASH_ID )
		);

		if ( strlen( get_option( Constant::OPTION_NAME_COMPANY_HASH_ID ) ) ) {
			add_settings_field(
				Constant::OPTION_NAME_ENABLED,
				__( 'Enabled', 'ages' ),
				array( self::class, 'settings_field_enabled' ),
				self::PAGE_SLUG_NAME,
				$settings_section_id,
				array( 'label_for' => Constant::OPTION_NAME_ENABLED )
			);
		}
	}

	/**
	 * Test Mode field setting option
	 *
	 * @since 1.0.0
	 *
	 * @param array $args Extra label_for arguments.
	 *
	 * @return void
	 */
	public static function settings_field_test_mode( array $args ): void {
		$option = get_option( Constant::OPTION_NAME_TEST_MODE );
		?>
		<select
				id="<?php echo esc_attr( $args['label_for'] ); ?>"
				name="<?php echo esc_attr( $args['label_for'] ); ?>">
			<option value="0" <?php echo isset( $option ) ? ( selected( $option, '0', false ) ) : ( '' ); ?>>
				<?php esc_html_e( 'No', 'ages' ); ?>
			</option>
			<option value="1" <?php echo isset( $option ) ? ( selected( $option, '1', false ) ) : ( '' ); ?>>
				<?php esc_html_e( 'Yes', 'ages' ); ?>
			</option>
		</select>
		<p class="description"><?php _e( 'If <strong>enabled</strong>, loads the "staging version" of the widget loader. If <strong>disabled</strong>, loads the "production version" of the widget loader.', 'ages' ); ?></p>
		<?php
	}

	/**
	 * Company Hash ID field setting option
	 *
	 * @since 1.0.0
	 *
	 * @param array $args Extra label_for arguments.
	 *
	 * @return void
	 */
	public static function settings_field_company_hash_id( array $args ): void {
		$option = get_option( Constant::OPTION_NAME_COMPANY_HASH_ID );
		?>
		<input
				id="<?php echo esc_attr( $args['label_for'] ); ?>"
				name="<?php echo esc_attr( $args['label_for'] ); ?>"
				type="text"
				value="<?php echo esc_attr( $option ); ?>">
		<p class="description"><?php _e( 'Your company hash ID. <a href="https://www.ages.app/" target="_blank">Click here</a> to generate one.', 'ages' ); ?></p>
		<?php
	}

	/**
	 * Enabled field setting option
	 *
	 * @since 1.0.0
	 *
	 * @param array $args Extra label_for arguments.
	 *
	 * @return void
	 */
	public static function settings_field_enabled( array $args ): void {
		$option = get_option( Constant::OPTION_NAME_ENABLED );
		?>
		<select
				id="<?php echo esc_attr( $args['label_for'] ); ?>"
				name="<?php echo esc_attr( $args['label_for'] ); ?>">
			<option value="0" <?php echo isset( $option ) ? ( selected( $option, '0', false ) ) : ( '' ); ?>>
				<?php esc_html_e( 'No', 'ages' ); ?>
			</option>
			<option value="1" <?php echo isset( $option ) ? ( selected( $option, '1', false ) ) : ( '' ); ?>>
				<?php esc_html_e( 'Yes', 'ages' ); ?>
			</option>
		</select>
		<p class="description"><?php _e( 'If <strong>enabled</strong>, the chat widget will show on the front website.', 'ages' ); ?></p>
		<?php
	}

	/**
	 * Adds the Ages admin menu item
	 * Shows the menu item if current user has "manage_options" capability
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public static function add_admin_menu(): void {
		add_menu_page(
			__( 'Ages', 'ages' ),
			__( 'Ages', 'ages' ),
			'manage_options',
			self::PAGE_SLUG_NAME,
			array( self::class, 'render_form' ),
			'dashicons-format-chat'
		);
	}

	/**
	 * Renders the settings options form elements
	 * Checks if current user has "manage_options" capability
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public static function render_form(): void {
		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}

		if ( isset( $_GET['settings-updated'] ) ) { //phpcs:disable WordPress.Security.NonceVerification.Recommended
			add_settings_error(
				'ages-settings-message',
				'ages-settings-message',
				__( 'Settings Saved', 'ages' ),
				'updated'
			);
		}
		settings_errors( 'ages-settings-message' );
		?>
		<div class="wrap ages-wp-plugin">
			<h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
			<form action="options.php" method="post">
				<?php
				settings_fields( Constant::OPTION_GROUP );
				do_settings_sections( self::PAGE_SLUG_NAME );
				submit_button( __( 'Save Settings', 'ages' ) );
				?>
			</form>
		</div>
		<?php
	}
}
