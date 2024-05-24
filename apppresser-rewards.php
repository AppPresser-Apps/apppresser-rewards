<?php
/**
 * Plugin Name:       Apppresser Rewards
 * Description:       Customer Rewards system for AppPresser Apps.
 * Requires at least: 6.5
 * Requires PHP:      7.4
 * Version:           1.0.0
 * Author:          AppPresser
 * Author URI:      https://apppresser.com
 * Plugin URI:      https://apppresser.com
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       apppresser-rewards
 *
 * @package CreateBlock
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Registers the block using the metadata loaded from the `block.json` file.
 * Behind the scenes, it registers also all assets so they can be enqueued
 * through the block editor in the corresponding context.
 *
 * @see https://developer.wordpress.org/reference/functions/register_block_type/
 */
function apppresser_rewards_block_init() {
	$blocks = array(
		'rewards'        => '',
		'qrcode'      => '',
	);

	foreach ( $blocks as $dir => $render_callback ) {
		$args = array();
		if ( ! empty( $render_callback ) ) {
			$args['render_callback'] = $render_callback;
		}
		register_block_type( APPPRESSER_REWARDS_DIR . '/build/' . $dir, $args );
	}
}
add_action( 'init', 'apppresser_rewards_block_init' );


if ( ! class_exists( 'AppPresser_Rewards' ) ) {


	/**
	 * Main AppPresser_Rewards class
	 *
	 * @access      public
	 * @since       1.0.0
	 */
	class AppPresser_Rewards {


		/**
		 * The one true AppPresser_Rewards
		 *
		 * @access      private
		 * @since       1.0.0
		 * @var         AppPresser_Rewards $instance The one true AppPresser_Rewards
		 */
		private static $instance;


		/**
		 * The settings object
		 *
		 * @access      public
		 * @since       1.0.0
		 * @var         object $settings The settings object
		 */
		public $settings;


		/**
		 * Get active instance
		 *
		 * @access      public
		 * @since       1.0.0
		 * @return      object self::$instance The one true AppPresser_Rewards
		 */
		public static function instance() {
			if ( ! isset( self::$instance ) && ! ( self::$instance instanceof AppPresser_Rewards ) ) {
				self::$instance = new AppPresser_Rewards();
				self::$instance->setup_constants();
				self::$instance->hooks();
				self::$instance->includes();

			}

			return self::$instance;
		}


		/**
		 * Throw error on object clone
		 *
		 * The whole idea of the singleton design pattern is that there is
		 * a single object. Therefore, we don't want the object to be cloned.
		 *
		 * @access      protected
		 * @since       1.0.0
		 * @return      void
		 */
		public function __cclone() {
			_doing_it_wrong( __FUNCTION__, esc_attr__( 'Cheatin&#8217; huh?', 'apppresser-rewards' ), '1.0.0' );
		}


		/**
		 * Disable unserializing of the class
		 *
		 * @access      protected
		 * @since       1.0.0
		 * @return      void
		 */
		public function __wakeup() {
			_doing_it_wrong( __FUNCTION__, esc_attr__( 'Cheatin&#8217; huh?', 'apppresser-rewards' ), '1.0.0' );
		}


		/**
		 * Setup plugin constants
		 *
		 * @access      private
		 * @since       1.0.0
		 * @return      void
		 */
		private function setup_constants() {
			// Plugin version.
			if ( ! defined( 'APPPRESSER_REWARDS_VER' ) ) {
				define( 'APPPRESSER_REWARDS_VER', '1.0.0' );
			}

			// Plugin path.
			if ( ! defined( 'APPPRESSER_REWARDS_DIR' ) ) {
				define( 'APPPRESSER_REWARDS_DIR', plugin_dir_path( __FILE__ ) );
			}

			// Plugin URL.
			if ( ! defined( 'APPPRESSER_REWARDS_URL' ) ) {
				define( 'APPPRESSER_REWARDS_URL', plugin_dir_url( __FILE__ ) );
			}
		}


		/**
		 * Run plugin base hooks
		 *
		 * @access      private
		 * @since       1.0.0
		 * @return      void
		 */
		private function hooks() {
			add_action( 'plugins_loaded', array( self::$instance, 'load_textdomain' ) );
		}


		/**
		 * Include necessary files
		 *
		 * @access      private
		 * @since       1.0.0
		 * @return      void
		 */
		private function includes() {
			global $AppPresser_Rewards_options;

			require_once APPPRESSER_REWARDS_DIR . 'includes/post-type.php';

			//require_once APPPRESSER_REWARDS_DIR . 'includes/actions.php';
			//require_once APPPRESSER_REWARDS_DIR . 'includes/filters.php';
			//require_once APPPRESSER_REWARDS_DIR . 'includes/helper-functions.php';
			//require_once APPPRESSER_REWARDS_DIR . 'includes/scripts.php';
			//require_once APPPRESSER_REWARDS_DIR . 'includes/api.php';

			//if ( is_admin() ) {
				//require_once APPPRESSER_REWARDS_DIR . 'includes/admin/dashboard-widgets.php';
			//}
        }


		/**
		 * Internationalization
		 *
		 * @access      public
		 * @since       1.0.0
		 * @return      void
		 */
		public function load_textdomain() {
			// Set filter for language directory.
			$lang_dir = dirname( plugin_basename( __FILE__ ) ) . '/languages/';
			$lang_dir = apply_filters( 'apppresser_rewards_lang_dir', $lang_dir );

			// Traditional WordPress plugin locale filter.
			$locale = apply_filters( 'plugin_locale', get_locale(), '' );
			$mofile = sprintf( '%1$s-%2$s.mo', 'apppresser-rewards', $locale );

			// Setup paths to current locale file.
			$mofile_local  = $lang_dir . $mofile;
			$mofile_global = WP_LANG_DIR . '/apppresser-rewards/' . $mofile;
			$mofile_core   = WP_LANG_DIR . '/plugins/apppresser-rewards/' . $mofile;

			if ( file_exists( $mofile_global ) ) {
				// Look in global /wp-content/languages/apppresser-rewards/ folder.
				load_textdomain( 'apppresser-rewards', $mofile_global );
			} elseif ( file_exists( $mofile_local ) ) {
				// Look in local /wp-content/plugins/apppresser-rewards/languages/ folder.
				load_textdomain( 'apppresser-rewards', $mofile_local );
			} elseif ( file_exists( $mofile_core ) ) {
				// Look in core /wp-content/languages/plugins/apppresser-rewards/ folder.
				load_textdomain( 'apppresser-rewards', $mofile_core );
			} else {
				// Load the default language files.
				load_plugin_textdomain( 'apppresser-rewards', false, $lang_dir );
			}
		}
	}
}


/**
 * The main function responsible for returning the one true AppPresser_Rewards
 * instance to functions everywhere.
 *
 * Use this function like you would a global variable, except without
 * needing to declare the global.
 *
 * Example: <?php $AppPresser_Rewards = AppPresser_Rewards(); ?>
 *
 * @since       2.0.0
 * @return      AppPresser_Rewards The one true AppPresser_Rewards
 */
function AppPresser_Rewards() {
	return AppPresser_Rewards::instance();
}

// Get things started.
AppPresser_Rewards();

/**
 * Plugin updater. Gets new version from Github.
 */
if ( is_admin() ) {

	function bprest_updater() {

		require 'plugin-update/plugin-update-checker.php';
		$myUpdateChecker = Puc_v4_Factory::buildUpdateChecker(
			'https://github.com/AppPresser-Apps/apppresser-rewards',
			__FILE__,
			'apppresser-rewards'
		);

		// Set the branch that contains the stable release.
		$myUpdateChecker->setBranch( 'main' );
		$myUpdateChecker->getVcsApi()->enableReleaseAssets();
	}
	bprest_updater();
}