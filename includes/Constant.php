<?php
/**
 * Ages Constant variables
 *
 * @package Ages
 */

namespace Ages\WP;

/**
 * Constant Class
 */
class Constant {
	/**
	 * The PHP minimum version requirement
	 *
	 * @since 1.0.0
	 *
	 * @var string MINIMUM_PHP_VERSION
	 */
	const MINIMUM_PHP_VERSION = '7.4';

	/**
	 * The WordPress minimum version requirement
	 *
	 * @since 1.0.0
	 *
	 * @var string MINIMUM_WP_VERSION
	 */
	const MINIMUM_WP_VERSION = '6.3';

	/**
	 * The plugin name
	 *
	 * @since 1.0.0
	 *
	 * @var string AGES_WP_NAME
	 */
	const AGES_WP_NAME = 'Ages WordPress Plugin';

	/**
	 * Ages settings option group label
	 *
	 * @since 1.0.0
	 *
	 * @var string OPTION_GROUP
	 */
	const OPTION_GROUP = 'ages_wp_settings';

	/**
	 * Test Mode settings option field
	 *
	 * @since 1.0.0
	 *
	 * @var string OPTION_NAME_TEST_MODE
	 */
	const OPTION_NAME_TEST_MODE = 'ages_wp_option_test_mode';

	/**
	 * Company Hash ID settings option field
	 *
	 * @since 1.0.0
	 *
	 * @var string OPTION_NAME_COMPANY_HASH_ID
	 */
	const OPTION_NAME_COMPANY_HASH_ID = 'ages_wp_option_company_hash_id';

	/**
	 * Enabled settings option field
	 *
	 * @since 1.0.0
	 *
	 * @var string OPTION_NAME_ENABLED
	 */
	const OPTION_NAME_ENABLED = 'ages_wp_option_enabled';

	/**
	 * Ages Widget Loader URL if OPTION_NAME_TEST_MODE is enabled
	 *
	 * @since 1.0.0
	 *
	 * @var string TEST_MODE_URL
	 */
	const TEST_MODE_URL = 'https://static-staging.ages.app/integrations/widget-loader.js';

	/**
	 * Ages Widget Loader URL if OPTION_NAME_TEST_MODE is disabled
	 *
	 * @since 1.0.0
	 *
	 * @var string LIVE_MODE_URL
	 */
	const LIVE_MODE_URL = 'https://static.ages.app/integrations/widget-loader.js';
}
