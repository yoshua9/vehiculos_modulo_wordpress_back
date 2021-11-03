<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    Vehicles
 * @subpackage Vehicles/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the vehicles, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Vehicles
 * @subpackage Vehicles/public
 * @author     Your Name <email@example.com>
 */
class Vehicles_Public {

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

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/vehicles-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/vehicles-public.js', array( 'jquery' ), $this->version, false );

	}


    /**
     *
     */
    function locate_template( $template, $settings, $page_type ) {

        $theme_files = array(
            $page_type . '-' . $settings['custom_post_type'] . '.php',
            $this->plugin_name . DIRECTORY_SEPARATOR . $page_type . '-' . $settings['custom_post_type'] . '.php',
        );

        $exists_in_theme = locate_template( $theme_files, false );

        if ( $exists_in_theme != '' ) {

            // Try to locate in theme first
            return $template;

        } else {

            // Try to locate in plugin base folder,
            // try to locate in plugin $settings['templates'] folder,
            // return $template if non of above exist
            $locations = array(
                join( DIRECTORY_SEPARATOR, array( WP_PLUGIN_DIR, $this->plugin_name, '' ) ),
                join( DIRECTORY_SEPARATOR, array( WP_PLUGIN_DIR, $this->plugin_name, $settings['templates_dir'], '' ) ), //plugin $settings['templates'] folder
            );

            foreach ( $locations as $location ) {
                if ( file_exists( $location . $theme_files[0] ) ) {
                    return $location . $theme_files[0];
                }
            }

            return $template;

        }

    }

    /**
     * Single Templates
     *
     * @since    1.0.0
     */
    function get_custom_post_type_templates( $template ) {
        global $post;

        $settings = array(
            'custom_post_type' => 'vehiculo',
            'templates_dir' => 'templates',
        );

        //if ( $settings['custom_post_type'] == get_post_type() && ! is_archive() && ! is_search() ) {
        if ( $settings['custom_post_type'] == get_post_type() && is_single() ) {

            return $this->locate_template( $template, $settings, 'single' );

        }

        return $template;
    }
}
