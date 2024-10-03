<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://wordpress-webdesign.berlin/
 * @since      1.0.0
 *
 * @package    Alpha_Projekt
 * @subpackage Alpha_Projekt/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Alpha_Projekt
 * @subpackage Alpha_Projekt/admin
 * @author     Roman Hanzlik <info@wordpress-webdesign.berlin>
 */
class Alpha_Projekt_Admin {

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
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

        add_action('wp_dashboard_setup', array($this, 'apro_dashboard_widget'));

    }

    // Widget registrieren
    public function apro_dashboard_widget() {
        wp_add_dashboard_widget(
            'apro_dashboard_widget',       // Widget-ID
            'Custom Dashboard Widget',     // Widget-Titel
            array($this, 'apro_dashboard_widget_content')  // Inhalt des Widgets
        );
    }

    // Inhalt des Widgets
    public function apro_dashboard_widget_content() {
        echo '<p>This is a custom dashboard widget content</p>';
        echo '<form method="post">';
        submit_button('Deaktivierte Plugins löschen');
        echo '</form>';

        // Wenn der Button gedrückt wurde
        if (isset($_POST['submit'])) {
            $this->delete_disabled_plugins();
        }
    }

    // Funktion zum Löschen deaktivierter Plugins
    private function delete_disabled_plugins() {
        // Plugin-Löschlogik hier einfügen
        echo '<p>Deaktivierte Plugins wurden gelöscht!</p>';
    }

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Alpha_Projekt_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Alpha_Projekt_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/alpha-projekt-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Alpha_Projekt_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Alpha_Projekt_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/alpha-projekt-admin.js', array( 'jquery' ), $this->version, false );

	}

}