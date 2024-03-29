<?php
/**
 * The current version of the theme.
 */
define('POPULARIS_VERSION', '1.0.11');

add_action('after_setup_theme', 'popularis_setup');

if (!function_exists('popularis_setup')) :

    /**
     * Global functions
     */
    function popularis_setup() {

        // Theme lang.
        load_theme_textdomain('popularis', get_template_directory() . '/languages');

        // Register Menus.
        register_nav_menus(
            array(
                'main_menu' => esc_html__('Main Menu', 'popularis'),
            )
        );

        // Add Custom Background Support.
        $args = array(
            'default-color' => 'ffffff',
        );
        
        add_theme_support('custom-background', $args);

        add_theme_support('custom-logo', array(
            'height' => 60,
            'width' => 170,
            'flex-height' => true,
            'flex-width' => true,
            'header-text' => array('site-title', 'site-description'),
        ));
        
        add_theme_support('post-thumbnails');
        set_post_thumbnail_size(300, 300, true);
        add_image_size('popularis-img', 1140, 600, true);
        
        // Set the default content width.
        $GLOBALS['content_width'] = 1140;

        // WooCommerce support.
        add_theme_support('woocommerce');
        add_theme_support('wc-product-gallery-zoom');
        add_theme_support('wc-product-gallery-lightbox');
        add_theme_support('wc-product-gallery-slider');
        add_theme_support('html5', array('search-form'));
        /*
         * This theme styles the visual editor to resemble the theme style,
         * specifically font, colors, icons, and column width.
         */
        add_editor_style(array('css/bootstrap.css', popularis_fonts_url(), 'css/editor-style.css'));
        
        add_theme_support('automatic-feed-links');

        // Add Title Tag Support.
        add_theme_support('title-tag');
        
        // Recommend plugins.
        add_theme_support('recommend-plugins', array(
            'popularis-extra' => array(
                'name' => 'Popularis Extra',
                'active_filename' => 'popularis-extra/popularis-extra.php',
                /* translators: %s plugin name string */
                'description' => sprintf(esc_html__('To take full advantage of all the features this theme has to offer, please install and activate the %s plugin.', 'popularis'), '<strong>Popularis Extra</strong>'),
            ),
            'elementor' => array(
                'name' => 'Elementor Page Builder',
                'active_filename' => 'elementor/elementor.php',
                /* translators: %s plugin name string */
                'description' => esc_html__('The most advanced frontend drag & drop page builder.', 'popularis'),
            ),
            'woocommerce' => array(
                'name' => 'WooCommerce',
                'active_filename' => 'woocommerce/woocommerce.php',
                /* translators: %s plugin name string */
                'description' => sprintf(esc_attr__('To enable shop features, please install and activate the %s plugin.', 'popularis'), '<strong>WooCommerce</strong>'),
            ),
        ));
    }

endif;

function popularis_body_classes( $classes ) {
    // Add class if the site title and tagline is hidden.
    if ( display_header_text() == true) {
	$classes[] = 'title-tagline-hidden';
    }
    
    return $classes;
    
}
add_filter( 'body_class', 'popularis_body_classes' );


/**
 * Register custom fonts.
 */
function popularis_fonts_url() {
    $fonts_url = '';

    /**
     * Translators: If there are characters in your language that are not
     * supported by Open Sans Condensed, translate this to 'off'. Do not translate
     * into your own language.
     */
    $font = _x('on', 'Open Sans Condensed font: on or off', 'popularis');

    if ('off' !== $font) {
        $font_families = array();

        $font_families[] = 'Open Sans Condensed:300,500,700';

        $query_args = array(
            'family' => urlencode(implode('|', $font_families)),
            'subset' => urlencode('cyrillic,cyrillic-ext,greek,greek-ext,latin-ext,vietnamese'),
        );

        $fonts_url = add_query_arg($query_args, 'https://fonts.googleapis.com/css');
    }

    return esc_url_raw($fonts_url);
}

/**
 * Add preconnect for Google Fonts.
 */
function popularis_resource_hints($urls, $relation_type) {
    if (wp_style_is('popularis-fonts', 'queue') && 'preconnect' === $relation_type) {
        $urls[] = array(
            'href' => 'https://fonts.gstatic.com',
            'crossorigin',
        );
    }

    return $urls;
}

add_filter('wp_resource_hints', 'popularis_resource_hints', 10, 2);

/**
 * Enqueue Styles 
 */
function popularis_theme_stylesheets() {
    wp_enqueue_style('bootstrap', get_template_directory_uri() . '/assets/css/bootstrap.css', array(), '3.3.7');
    wp_enqueue_style('mmenu-light', get_template_directory_uri() . '/assets/css/mmenu-light.css', array(), '1.1');
    // Theme stylesheet.
    wp_enqueue_style('popularis-stylesheet', get_stylesheet_uri(), array('bootstrap'), POPULARIS_VERSION);
    // Load Font Awesome css.
    wp_enqueue_style('font-awesome', get_template_directory_uri() . '/assets/css/font-awesome.min.css', array(), '4.7.0');
    // Add custom fonts, used in the main stylesheet.
    wp_enqueue_style('popularis-fonts', popularis_fonts_url(), array(), null);
    if (class_exists('WooCommerce')) {
        wp_enqueue_style('popularis-woocommerce', get_template_directory_uri() . '/assets/css/woocommerce.css', array('bootstrap'), POPULARIS_VERSION);
    }
}

add_action('wp_enqueue_scripts', 'popularis_theme_stylesheets');

/**
 * Register Bootstrap JS with jquery
 */
function popularis_theme_js() {
    wp_enqueue_script('mmenu', get_template_directory_uri() . '/assets/js/mmenu-light.js', array('jquery'), '1.1', true);
    wp_enqueue_script('bootstrap', get_template_directory_uri() . '/assets/js/bootstrap.min.js', array('jquery'), '3.3.7', true);
    wp_enqueue_script('popularis-theme-js', get_template_directory_uri() . '/assets/js/customscript.js', array('jquery'), POPULARIS_VERSION, true);
}

add_action('wp_enqueue_scripts', 'popularis_theme_js');

/**
 * Set Content Width
 */
function popularis_content_width() {

    $content_width = $GLOBALS['content_width'];

    if (is_active_sidebar('sidebar-1')) {
        $content_width = 750;
    } else {
        $content_width = 1040;
    }

    /**
     * Filter content width of the theme.
     */
    $GLOBALS['content_width'] = apply_filters('popularis_content_width', $content_width);
}

add_action('template_redirect', 'popularis_content_width', 0);

/**
 * Register Custom Navigation Walker include custom menu widget to use walkerclass
 */
require_once( trailingslashit(get_template_directory()) . 'inc/wp_bootstrap_navwalker.php' );

/**
 * Register Theme Extra Functions
 */
require_once( trailingslashit(get_template_directory()) . 'inc/extra.php' );

/**
 *  Theme Page
 */
require_once( trailingslashit(get_template_directory()) . 'inc/admin/dashboard.php' );

/**
 * Register WooCommerce functions
 */
if (class_exists('WooCommerce')) {
    require_once( trailingslashit(get_template_directory()) . 'inc/woocommerce.php' );
}

/**
 * Lightbox Hoverbox Gallery
 */
require_once( trailingslashit(get_template_directory()) . 'inc/lightbox_gallery.php' );



add_action('widgets_init', 'popularis_widgets_init');

/**
 * Register the Sidebar(s)
 */
function popularis_widgets_init() {
    register_sidebar(
        array(
            'name' => esc_html__('Sidebar', 'popularis'),
            'id' => 'sidebar-1',
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget' => '</div>',
            'before_title' => '<div class="widget-title"><h3>',
            'after_title' => '</h3></div>',
        )
    );
    register_sidebar(
        array(
            'name' => esc_html__('Top Bar Section', 'popularis'),
            'id' => 'popularis-top-bar-area',
            'before_widget' => '<div id="%1$s" class="widget %2$s col-sm-4">',
            'after_widget' => '</div>',
            'before_title' => '<div class="widget-title"><h3>',
            'after_title' => '</h3></div>',
        )
    );
    register_sidebar(
        array(
            'name' => esc_html__('Footer Section', 'popularis'),
            'id' => 'popularis-footer-area',
            'before_widget' => '<div id="%1$s" class="widget %2$s col-md-3">',
            'after_widget' => '</div>',
            'before_title' => '<div class="widget-title"><h3>',
            'after_title' => '</h3></div>',
        )
    );
}

if ( ! function_exists( 'wp_body_open' ) ) :
    /**
     * Fire the wp_body_open action.
     *
     * Added for backwards compatibility to support pre 5.2.0 WordPress versions.
     *
     */
    function wp_body_open() {
        /**
         * Triggered after the opening <body> tag.
         *
         */
        do_action( 'wp_body_open' );
    }
endif;

/**
 * Include a skip to content link at the top of the page so that users can bypass the header.
 */
function popularis_skip_link() {
	echo '<a class="skip-link screen-reader-text" href="#site-content">' . esc_html__( 'Skip to the content', 'popularis' ) . '</a>';
}

add_action( 'wp_body_open', 'popularis_skip_link', 5 );


if (!function_exists('popularis_writer_excerpt_length')) :
    /* Limit the excerpt.*/
    function popularis_writer_excerpt_length($length) {
        if (is_home() || is_archive()) { // Make sure to not limit pagebuilders
            return '45';
        } else {
            return $length;
        }
    }
    add_filter('excerpt_length', 'popularis_writer_excerpt_length', 999);
endif;




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

function custom_post_type() {
 
    // Set UI labels for Custom Post Type
    $labels = array(
        'name'                => _x( 'Fanfic', 'Post Type General Name', 'twentytwenty' ),
        'menu_name'           => __( 'Fanfiction' ),
        'all_items'           => __( 'All Fanfics' ),
        'view_item'           => __( 'View Fanfic' ),
        'add_new_item'        => __( 'Add New Fanfic' ),
        'add_new'             => __( 'Add New Fanfic' ),
        'edit_item'           => __( 'Edit Fanfic' ),
        'update_item'         => __( 'Update Fanfic' ),
        'search_items'        => __( 'Search Fanfic' ),
        'not_found'           => __( 'Not Found' ),
        'not_found_in_trash'  => __( 'Not found in Trash'),
    );
        
    // Set other options for Custom Post Type 
    $args = array(
        'label'               => __( 'fanfic' ),
        'labels'              => $labels,
        // Features this CPT supports in Post Editor
        'supports'            => array( 'title', 'editor', 'excerpt', 'author', 'thumbnail', 'comments', 'revisions', 'custom-fields' ),
        // You can associate this CPT with a taxonomy or custom taxonomy. 
        'taxonomies'          => array( 'categories' ),
        /* A hierarchical CPT is like Pages and can have
        * Parent and child items. A non-hierarchical CPT
        * is like Posts.
        */ 
        'hierarchical'        => false,
        'public'              => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'show_in_nav_menus'   => true,
        'show_in_admin_bar'   => true,
        'menu_position'       => 5,
        'can_export'          => true,
        'has_archive'         => true,
        'exclude_from_search' => false,
        'publicly_queryable'  => true,
        'capability_type'     => 'post',
        'show_in_rest' => true,
    );
        
    // Registering your Custom Post Type
    register_post_type( 'fanfic', $args );
}
     
add_action( 'init', 'custom_post_type', 0 );


function fanfic_function($atts) {
    
	extract(shortcode_atts(array(
      'file' => 1,
	), $atts));

	$fileName = 'wp-content/uploads/fiction/'.$file;
	
	//echo $fileName;
	if(is_file($fileName))  //check if file exists
		$readfile = readfile($fileName); //read all contents into a var 
	else 
		$readfile = 'File not found';

	if (preg_match("/\t/", $readfile)) {
		echo '1';
	}
	preg_replace("/\t/", '<p>', $readfile);

	return $readfile.' characters';
}


function newsletterModule() {
    $siteURL = get_site_url();
    
    $imgCC = $siteURL.'/wp-content/uploads/images/signup/cc_pizza.png';
    $optinURL = $siteURL.'/download';
    
    $output = '<div class="newsletterModule">
    <div class="headline">Download 200+ Anime OSTs for Free</div>

    <form name="sendgrid" method="POST" action="'.$optinURL.'">
        <p>Tired of searching for Original Sound Tracks? We have it all in one place. Sign up below to directly download OST from our servers.</p>

        <div class="form_left">
        <p><img src="'. $imgCC .'" class="CC Pizza"></p>
        </div>

        <div class="form_right">
            <input type="hidden" name="origin" value="newsletterModule" />
            <input type="text" class="email" name="email" id="email" placeholder="Enter your best email" title="Enter your best email">
            
            <input type="submit" name="submit" class="signupButton" value="Join Us Now" onclick="return validateEmail(document.sendgrid.email.value);">
        
        </div>
        <div class="clear"></div>
        <p class="note">
        We hate spam and will never sell your email address to others. All opt-ins are completely optional.</p>
    </form>
    </div>';

    return $output;
}


function productsModule () {
    global $productsList;

    $output = '<div class="productsModule"><div class="headline">Products of the Day</div>
    '.randomProduct ($productsList).randomProduct ($productsList).randomProduct ($productsList).'</div>'; 

    //return $output;
}

//shows 1 random product for the product module
function randomProduct ($productsList) {
    $random = rand() % 8;
    $site_url = get_site_url();
    
    $prodMain = $productsList[$random];

    $prod_img = $site_url.'/wp-content/uploads/'.$prodMain['image'];

    $output = '<div class="randomProduct">
    <a href="'.$prodMain['url'].'" target="_BLANK"><img src="'.$prod_img.'" />
    <p>'.$prodMain['name'].'</p></a> 
    </div>';

    return $output;
}


global $wpdb;
global $productsList;

$productsResults = $wpdb->get_results("SELECT * FROM products ORDER BY name LIMIT 10");

$counter = 0;
foreach($productsResults as $prod) {
    
    $productsList[$counter] = array (
        'name' => $prod->name,
        'url' => $prod->url_2,
        'image' => $prod->image 
    );
    $counter++;
}


// gallery shortcode [show_gallery anime="folder_name/folder_name"]
add_shortcode('show_gallery', 'gallery_function');

//fanfic shortcode [fanfic file="folder_name/file_name"]
add_shortcode('fanfic', 'fanfic_function');

//disable automatic updates 
add_filter( 'auto_update_plugin', '__return_false' );
add_filter( 'auto_update_theme', '__return_false' );