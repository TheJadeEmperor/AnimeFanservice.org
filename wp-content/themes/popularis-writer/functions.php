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
    $dir = $context[dir];
    
	$directory = 'wp-content/uploads/'.$anime;
	
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
	
    $galleryContent .= '<center>Click on the thumbnail to see the full size image</center>
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




// Register shortcode
add_shortcode('show_gallery', 'gallery_function');