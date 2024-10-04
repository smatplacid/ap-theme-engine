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

#        add_action( 'wp_dashboard_setup', array( $this, 'check_and_add_dashboard_widget' ) );

#        if ( apro_is_it_god() ) {
#            add_action('wp_dashboard_setup', array($this, 'apro_dashboard_widget'));
#        }
    }

    // Widget registrieren
    public function apro_dashboard_widget() {
        wp_add_dashboard_widget(
            'apro_dashboard_widget',                // Widget-ID
            'WordPress Webdesign Widget',        // Widget-Titel
            array($this, 'apro_dashboard_widget_content')   // Inhalt des Widgets
        );
    }

    // Inhalt des Widgets
    public function apro_dashboard_widget_content() {
        $disabled_plugins = $this->apro_get_disabled_plugins();

        echo '<p>Mission Control Admin</p>';

        if ( empty( $disabled_plugins ) ) {
            echo '<form method="post">';
            wp_nonce_field( 'delete_disabled_plugins_nonce_action', 'delete_disabled_plugins_nonce' );
            submit_button('Keine deaktivierten Plugins vorhanden', 'primary', 'submit', true, ['disabled' => 'disabled']);
            echo '</form>';
        } else {
            echo '<form method="post">';
            wp_nonce_field( 'delete_disabled_plugins_nonce_action', 'delete_disabled_plugins_nonce' );
            submit_button('Deaktivierte Plugins löschen');
            echo '</form>';
        }

        // Wenn der Button gedrückt wurde
        if ( isset($_POST['delete_disabled_plugins_nonce']) && wp_verify_nonce( $_POST['delete_disabled_plugins_nonce'], 'delete_disabled_plugins_nonce_action' ) ) {
            $this->apro_delete_disabled_plugins();
        }
    }

    // Funktion zum Abrufen deaktivierter Plugins
    private function apro_get_disabled_plugins() {
        include_once( ABSPATH . 'wp-admin/includes/plugin.php' );

        $all_plugins = get_plugins();
        $disabled_plugins = [];

        foreach ( $all_plugins as $plugin_file => $plugin_data ) {
            if ( !is_plugin_active( $plugin_file ) ) {
                $disabled_plugins[] = $plugin_file;
            }
        }

        return $disabled_plugins;
    }

    // Funktion zum Löschen deaktivierter Plugins
    private function apro_delete_disabled_plugins() {
        if ( ! current_user_can( 'activate_plugins' ) ) {
            return;
        }

        include_once( ABSPATH . 'wp-admin/includes/plugin.php' );

        $all_plugins = get_plugins();
        $deleted_plugins = [];

        foreach ( $all_plugins as $plugin_file => $plugin_data ) {
            if ( !is_plugin_active( $plugin_file ) ) {
                // Lösche nur das Plugin, keine Sprachdateien
                if ( strpos( $plugin_file, 'languages' ) === false ) {
                    delete_plugins( [$plugin_file] );
                    $deleted_plugins[] = $plugin_data['Name'];
                }
            }
        }

        if ( empty( $deleted_plugins ) ) {
            echo '<p>Keine Plugins gelöscht.</p>';
        } else {
            echo '<p>Folgende Plugins wurden gelöscht:</p>';
            echo '<ul>';
            foreach ( $deleted_plugins as $plugin_name ) {
                echo '<li>' . esc_html( $plugin_name ) . '</li>';
            }
            echo '</ul>';
        }
    }

    /**
     * Check if current user is God.
     *
     * @since    1.0.0

    private function apro_is_it_god() {
        $current_user = wp_get_current_user();

        if ( $current_user && $current_user->user_login === 'r.hanzlik' ) {
            return true;
        }

        return false;
    }
*/



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