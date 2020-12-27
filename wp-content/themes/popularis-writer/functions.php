<?php

// Exit if accessed directly
if (!defined('ABSPATH'))
    exit;

if (!function_exists('popularis_writer_setup')) :

    /**
     * Global functions.
     */
    function popularis_writer_setup() {
        
        // Child theme language
        load_child_theme_textdomain( 'popularis-writer', get_stylesheet_directory() . '/languages' );
        
    }
    
endif;

add_action('after_setup_theme', 'popularis_writer_setup');

add_action( 'init', 'popularis_customizer' );


if (!function_exists('popularis_writer_parent_css')):

    /**
     * Enqueue CSS.
     */
    function popularis_writer_parent_css() {
        $parent_style = 'popularis-stylesheet';
        
        $dep = array('bootstrap');
        if (class_exists('WooCommerce')) {
            $dep = array('bootstrap', 'popularis-woocommerce');
        }

        wp_enqueue_style($parent_style, get_template_directory_uri() . '/style.css', $dep);
        wp_enqueue_style('popularis-writer',
                get_stylesheet_directory_uri() . '/style.css',
                array($parent_style),
                wp_get_theme()->get('Version')
        );
    }

endif;
add_action('wp_enqueue_scripts', 'popularis_writer_parent_css');



