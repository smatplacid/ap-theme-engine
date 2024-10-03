<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://wordpress-webdesign.berlin/
 * @since      1.0.0
 *
 * @package    Alpha_Projekt
 * @subpackage Alpha_Projekt/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Alpha_Projekt
 * @subpackage Alpha_Projekt/includes
 * @author     Roman Hanzlik <info@wordpress-webdesign.berlin>
 */
class Alpha_Projekt_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'alpha-projekt',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
