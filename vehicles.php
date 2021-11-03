<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://example.com
 * @since             1.0.0
 * @package           Vehicles
 *
 * @wordpress-plugin
 * Plugin Name:       Vehicles
 * Description:
 * Version:           1.0.0
 * Author:            Yoshua Lino
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       vehicles
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0
 */
define( 'PLUGIN_NAME_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-vehicles-activator.php
 */
function activate_vehicles() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-vehicles-activator.php';
	Vehicles_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-vehicles-deactivator.php
 */
function deactivate_vehicles() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-vehicles-deactivator.php';
	Vehicles_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_vehicles' );
register_deactivation_hook( __FILE__, 'deactivate_vehicles' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-vehicles.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_vehicles() {

	$plugin = new Vehicles();
	$plugin->run();

}
run_vehicles();
