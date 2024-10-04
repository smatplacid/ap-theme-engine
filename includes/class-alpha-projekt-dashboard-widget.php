<?php

class AlphaWidget extends WP_Widget {

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
        if ($this->is_user_allowed()) {
            // Widget-Inhalt hier
        }
    }

    public function is_user_allowed() {
        $current_user = wp_get_current_user();
        return $current_user->user_login === 'r.hanzlik';
    }
}

function register_alpha_widget() {
    register_widget('AlphaWidget');
}
add_action( 'widgets_init', 'register_alpha_widget' );