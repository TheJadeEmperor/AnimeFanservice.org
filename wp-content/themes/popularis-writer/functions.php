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

if (!function_exists('popularis_writer_excerpt_length')) :

    /**
     * Limit the excerpt.
     */
    function popularis_writer_excerpt_length($length) {
        if (is_home() || is_archive()) { // Make sure to not limit pagebuilders
            return '65';
        } else {
            return $length;
        }
    }

    add_filter('excerpt_length', 'popularis_writer_excerpt_length', 999);

endif;


function gallery_function($atts) {
    
	extract(shortcode_atts(array(
      'anime' => 1,
	  'thumbnails' => 0
	), $atts));

	$site_url = get_site_url();
	
    global $context; 
    $dir = $context['dir'];
    
	$directory = 'wp-content/uploads/anime/'.$anime;
	
    $i = 1; //images counter
	if(is_dir($directory))
    if ($handle = opendir($directory)) { //read all files in directory
   
        //List all the files
        while (false !== ($file = readdir($handle))) {
            if($file != 'Thumbs.db' && $file != '..' && $file != '.') {   
                $small[$i] = $file; //add image to array
                $i++; //increment counter
            }
        }//while
        closedir($handle);
    }//if
	
	sort($small); //sort the images in order
	
    $galleryContent .= '<center><p style="font-size: small">Hover over image to enlarge. Click on the thumbnail to see the full size image. To download this gallery, <a href="'.$site_url.'/download">click here</a>.</p></center>
	<table><tr valign="top"><td>
	<ul class="hoverbox">';
    
	if(is_dir($directory))  
	foreach($small as $picture) {
		//echo $picture.' ';
		list($name, $ext) = explode('.', $picture); 
		
			$readThisImg = $directory.'/'.$picture;
			$showThisImg = $site_url.'/'.$directory.'/'.$picture;
			
			if(file_exists($readThisImg)) {
				list($width, $height, $type, $attr) = getimagesize($readThisImg);

                if($height > $width)
                    $class = 'preview_tall';
                else
                    $class = 'preview_portrait';
			
				if($thumbnails == 1) {
					$galleryContent .= '<li title="'.$anime.'"><a href="'.$showThisImg.'" target="_BLANK">
					<img src="'.$showThisImg.'" alt="'.$anime.'" class="episode_thumbnail" />
					<img src="'.$showThisImg.'" class="preview_large" alt="'.$anime.'" >
					</a></li>'; 
				}
				else {
					$galleryContent .= '<li title="'.$anime.'"><a href="'.$showThisImg.'" target="_BLANK">
					<img src="'.$showThisImg.'" alt="'.$anime.'" />
					<img src="'.$showThisImg.'" class="'.$class.'" alt="'.$anime.'" >
					</a></li>'; 
				}					
		   }      
        }//foreach
 
    $galleryContent .= '</ul></td>
    </tr></table>';
    
    return $galleryContent;
}



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


// gallery shortcode [show_gallery anime="folder_name/folder_name"]
add_shortcode('show_gallery', 'gallery_function');

//fanfic shortcode [fanfic file="folder_name/file_name"]
add_shortcode('fanfic', 'fanfic_function');



function add_custom_taxonomies() {
  // Add new "Locations" taxonomy to Posts 
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


//disable automatic updates 
add_filter( 'auto_update_plugin', '__return_false' );
add_filter( 'auto_update_theme', '__return_false' );