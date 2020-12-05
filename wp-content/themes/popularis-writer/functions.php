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



/**
 * Move sidebar to left and make it larger.
 */
function popularis_main_content_width_columns() {

    $columns = '12';

    if (is_active_sidebar('sidebar-1')) {
        $columns = '8 col-md-push-4';
    }

    echo esc_attr($columns);
}



function add_custom_taxonomies() {
  // Add new taxonomy to Posts 
  register_taxonomy('colors', 'post', array(
    // Hierarchical taxonomy (like categories)
    'hierarchical' => false,
    // This array of options controls the labels displayed in the WordPress Admin UI
    'labels' => array(
      'name' => _x( 'Colors', 'taxonomy general name' ),
      'singular_name' => _x( 'color', 'taxonomy singular name' ),
      'search_items' =>  __( 'Search Colors' ),
      'all_items' => __( 'All Colors' ),
      'edit_item' => __( 'Edit Color' ),
      'update_item' => __( 'Update Color' ),
      'add_new_item' => __( 'Add New Color' ),
      'new_item_name' => __( 'New Color Name' ),
      'menu_name' => __( 'Colors' ),
    ),
    // Control the slugs used for this taxonomy
    'rewrite' => array(
      'slug' => 'colors', // This controls the base slug that will display before each term
      'with_front' => false, // Don't display the category base before "/colors/"
      'hierarchical' => true // This will allow URL's like "/locations/boston/cambridge/"
    ),
  ));
}

add_action( 'init', 'add_custom_taxonomies', 0 );