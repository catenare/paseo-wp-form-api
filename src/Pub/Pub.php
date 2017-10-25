<?php

namespace Paseo\Pub;

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Paseo_Wp_Form_Api
 * @subpackage Paseo_Wp_Form_Api/public
 * @author     Johan Martin <johan@paseo.org.za>
 */
class Pub {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	private $assets_url;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {
		$this->plugin_name = $plugin_name;
		$this->version = $version;
	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Paseo_Wp_Form_Api_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Paseo_Wp_Form_Api_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */



		wp_enqueue_style( $this->plugin_name, \PASEO_WP_FORM_DIR_URL.  'site/assets/paseo-wp-form-api.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Paseo_Wp_Form_Api_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Paseo_Wp_Form_Api_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, \PASEO_WP_FORM_DIR_URL . 'site/assets/paseo-wp-form-api.js', array('jquery'), $this->version, false );

	}

}
