<?php

/**
 * Fired during plugin activation
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    Vehicles
 * @subpackage Vehicles/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Vehicles
 * @subpackage Vehicles/includes
 * @author     Your Name <email@example.com>
 */
class Vehicles_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {

        /**
         * Custom Post Types
         */
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-vehicles-post_types.php';
        $plugin_post_types = new Vehicles_Post_Types();

        $plugin_post_types->create_custom_post_type();

        flush_rewrite_rules();

	}

}
