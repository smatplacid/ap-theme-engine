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
            // Widget-Inhalt hier
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