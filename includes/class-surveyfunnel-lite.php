<?php
/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link  https://club.wpeka.com
 * @since 1.0.0
 *
 * @package    Surveyfunnel_Lite
 * @subpackage Surveyfunnel_Lite/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Surveyfunnel_Lite
 * @subpackage Surveyfunnel_Lite/includes
 * @author     WPEka Club <support@wpeka.com>
 */
class Surveyfunnel_Lite {


	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since  1.0.0
	 * @access protected
	 * @var    Surveyfunnel_Lite_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since  1.0.0
	 * @access protected
	 * @var    string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since  1.0.0
	 * @access protected
	 * @var    string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
		if ( defined( 'SURVEYFUNNEL_LITE_VERSION' ) ) {
			$this->version = SURVEYFUNNEL_LITE_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->plugin_name = 'surveyfunnel-lite';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();
	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Surveyfunnel_Lite_Loader. Orchestrates the hooks of the plugin.
	 * - Surveyfunnel_Lite_I18n. Defines internationalization functionality.
	 * - Surveyfunnel_Lite_Admin. Defines all hooks for the admin area.
	 * - Surveyfunnel_Lite_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since  1.0.0
	 * @access private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-surveyfunnel-lite-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-surveyfunnel-lite-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-surveyfunnel-lite-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-surveyfunnel-lite-public.php';

		$this->loader = new Surveyfunnel_Lite_Loader();
	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Surveyfunnel_Lite_I18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since  1.0.0
	 * @access private
	 */
	private function set_locale() {

		$plugin_i18n = new Surveyfunnel_Lite_I18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );
	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since  1.0.0
	 * @access private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new Surveyfunnel_Lite_Admin( $this->get_plugin_name(), $this->get_version() );

		// enqueue styles and scripts.
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );

		// admin functionalities.
		$this->loader->add_action( 'admin_menu', $plugin_admin, 'wpsf_admin_menu' );
		$this->loader->add_action( 'init', $plugin_admin, 'wpsf_init', 0 );

		// ajax calls.
		$this->loader->add_action( 'wp_ajax_wpsf_new_survey', $plugin_admin, 'wpsf_new_survey' );
		$this->loader->add_action( 'wp_ajax_wpsf_delete_survey', $plugin_admin, 'wpsf_delete_survey' );
		$this->loader->add_action( 'wp_ajax_wpsf_get_status', $plugin_admin, 'wpsf_get_status' );
		$this->loader->add_action( 'wp_ajax_wpsf_change_status', $plugin_admin, 'wpsf_change_status' );
		$this->loader->add_action( 'wp_ajax_wpsf_save_build_data', $plugin_admin, 'wpsf_save_build_data' );
		$this->loader->add_action( 'wp_ajax_wpsf_get_build_data', $plugin_admin, 'wpsf_get_build_data' );
		$this->loader->add_action( 'wp_ajax_wpsf_save_design_data', $plugin_admin, 'wpsf_save_design_data' );
		$this->loader->add_action( 'wp_ajax_wpsf_get_design_data', $plugin_admin, 'wpsf_get_design_data' );
		$this->loader->add_action( 'wp_ajax_wpsf_get_reports_data', $plugin_admin, 'wpsf_get_reports_data' );
		$this->loader->add_action( 'wp_ajax_wpsf_save_configuration_data', $plugin_admin, 'wpsf_save_configuration_data' );
		$this->loader->add_action( 'wp_ajax_wpsf_get_configuration_data', $plugin_admin, 'wpsf_get_configuration_data' );
		$this->loader->add_action( 'wp_ajax_wpsf_save_share_data', $plugin_admin, 'wpsf_save_share_data' );
		$this->loader->add_action( 'wp_ajax_wpsf_get_share_data', $plugin_admin, 'wpsf_get_share_data' );
		$this->loader->add_action( 'wp_ajax_wpsf_get_posts_pages', $plugin_admin, 'wpsf_get_posts_pages' );
		$this->loader->add_action( 'admin_post_export_csv', $plugin_admin, 'wpsf_export_csv' );
		$this->loader->add_action( 'admin_footer', $plugin_admin, 'wpsf_mascot_on_pages' );

		// setup wpsf-survey (builder) page.
		$this->loader->add_action( 'admin_init', $plugin_admin, 'wpsf_survey_setup_page' );
	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since  1.0.0
	 * @access private
	 */
	private function define_public_hooks() {

		$plugin_public = new Surveyfunnel_Lite_Public( $this->get_plugin_name(), $this->get_version() );

		// enqueue necessary scripts and styles.
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );

		// init functionality - add_shortcode.
		$this->loader->add_action( 'init', $plugin_public, 'wpsf_public_init' );
		$this->loader->add_filter( 'the_content', $plugin_public, 'wpsf_the_content' );

		// ajax calls
		$this->loader->add_action( 'wp_ajax_wpsf_new_survey_lead', $plugin_public, 'wpsf_new_survey_lead' );
		$this->loader->add_action( 'wp_ajax_nopriv_wpsf_new_survey_lead', $plugin_public, 'wpsf_new_survey_lead' );
		$this->loader->add_action( 'wp_ajax_wpsf_get_display_data', $plugin_public, 'wpsf_get_display_data' );
		$this->loader->add_action( 'wp_ajax_nopriv_wpsf_get_display_data', $plugin_public, 'wpsf_get_display_data' );
	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since 1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since  1.0.0
	 * @return string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @return Surveyfunnel_Lite_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since  1.0.0
	 * @return string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

	/**
	 * Check if pro version is activated.
	 */
	public static function check_pro_activated() {
		return get_option( 'surveyfunnel_pro_activated', false );
	}

	/**
	 * What type of request is this?
	 *
	 * @param string $type admin, ajax, cron or frontend.
	 *
	 * @return bool
	 */
	public static function is_request( $type ) {
		switch ( $type ) {
			case 'admin':
				return is_admin();
			case 'ajax':
				return defined( 'DOING_AJAX' );
			case 'cron':
				return defined( 'DOING_CRON' );
			case 'frontend':
				return ! is_admin() && ! defined( 'DOING_AJAX' ) && ! defined( 'DOING_CRON' ) && ! defined( 'REST_REQUEST' );
		}
	}
}
