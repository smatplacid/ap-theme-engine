<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://wordpress-webdesign.berlin/
 * @since             1.0.0
 * @package           Alpha_Projekt
 *
 * @wordpress-plugin
 * Plugin Name:       1 | WordPress Webdesign Berlin (formals alpha-projekt)
 * Plugin URI:        https://wordpress-webdesign.berlin/
 * Description:       Ein Hilfsplugin für Ihre Webseite und den Administrator. 
 * Version:           1.0.0
 * Author:            Roman Hanzlik
 * Author URI:        https://wordpress-webdesign.berlin//
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       alpha-projekt
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'ALPHA_PROJEKT_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-alpha-projekt-activator.php
 */
function activate_alpha_projekt() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-alpha-projekt-activator.php';
	Alpha_Projekt_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-alpha-projekt-deactivator.php
 */
function deactivate_alpha_projekt() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-alpha-projekt-deactivator.php';
	Alpha_Projekt_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_alpha_projekt' );
register_deactivation_hook( __FILE__, 'deactivate_alpha_projekt' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-alpha-projekt.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_alpha_projekt() {

	$plugin = new Alpha_Projekt();
	$plugin->run();

}
run_alpha_projekt();
