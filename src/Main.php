<?php

namespace Paseo;
use Timber\Timber;

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
 * @package    Paseo_Wp_Form_Api
 * @subpackage Paseo_Wp_Form_Api/includes
 * @author     Johan Martin <johan@paseo.org.za>
 */

class Main {

    const TEMPLATES = '../site/templates';

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Lib\Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

    /**
     * @var path to assets.
     */
	protected $site_asset_path;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
		if ( defined( 'PASEO_WP_FORM_API_PLUGIN_VERSION' ) ) {
			$this->version = PASEO_WP_FORM_API_PLUGIN_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->plugin_name = 'paseo-wp-form-api';
		$this->site_asset_path = $this->get_assets_url();

        Timber::$locations = plugin_dir_path(__FILE__) . self::TEMPLATES;

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();
		$this->define_class_hooks();

	}

    /**
     * Set path to assets.
     * @return string
     */
    protected function get_assets_url() {
        return plugin_dir_url(__FILE__) . '../site/';
    }

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Paseo_Wp_Form_Api_Loader. Orchestrates the hooks of the plugin.
	 * - Paseo_Wp_Form_Api_i18n. Defines internationalization functionality.
	 * - Paseo_Wp_Form_Api_Admin. Defines all hooks for the admin area.
	 * - Paseo_Wp_Form_Api_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		$this->loader = new Lib\Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Paseo_Wp_Form_Api_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Lib\i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new Admin\Admin( $this->get_plugin_name(), $this->get_version(), $this->get_assets_url() );

		$this->loader->add_action(
		    'admin_menu',
            $plugin_admin,
            'add_settings_page'
        );

		$this->loader->add_action(
		    'admin_enqueue_scripts',
            $plugin_admin,
            'enqueue_styles' );

		$this->loader->add_action(
		    'admin_enqueue_scripts',
            $plugin_admin,
            'enqueue_scripts'
        );

	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new Pub\Pub( $this->get_plugin_name(), $this->get_version(), $this->get_assets_url() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );

	}


	/**
	 * Register hooks in classes
	 */
	private function define_class_hooks() {

		$this->loader->add_class_action(
		    'rest_api_init',
            array('Paseo\Rest\Routes', 'register_route')
        );
	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Lib\Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

}
