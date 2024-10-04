<?php

class Alpha_Projekt_Widget extends WP_Widget {

    public function __construct() {
        parent::__construct(
            'alpha_widget',
            __('Alpha Widget', 'text-domain'),
            array(
                'description' => __('A widget for alpha users.', 'text-domain'),
            )
        );
    }

    public function widget( $args, $instance ) {
        if ($this->apro_is_it_god()) {
            wp_add_dashboard_widget(
                'apro_dashboard_widget',                // Widget-ID
                'WordPress Webdesign Widget',        // Widget-Titel
                array($this, 'apro_dashboard_widget_content')   // Inhalt des Widgets
            );
        }
    }

    public function apro_dashboard_widget_content() {
        $disabled_plugins = $this->apro_get_disabled_plugins();

        echo '<p>Mission Control</p>';

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

    public function apro_is_it_god() {
        $current_user = wp_get_current_user();
        return $current_user->user_login === 'r.hanzlik';
    }
}

function register_alpha_widget() {
    register_widget('Alpha_Projekt_Widget');
}
add_action( 'widgets_init', 'register_alpha_widget' );