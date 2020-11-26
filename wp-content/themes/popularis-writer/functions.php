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
            return '45';
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
    $postTitle = get_the_title(); 
    $animeID = str_replace('/', '_', $anime);

	$directory = 'wp-content/uploads/anime/'.$anime;

    //valid image extensions
    $validFiles = array('jpg', 'png', 'jpeg');
    
    $counter = 1; //images counter
    if(is_dir($directory))
    if ($handle = opendir($directory)) { //read all files in directory
        //List all the files
        while (false !== ($file = readdir($handle))) {
            $ext = pathinfo($file, PATHINFO_EXTENSION);
            if(in_array($ext, $validFiles)) {   
                $small[$counter] = $file; //add image to array
                $counter++; //increase counter
            }
        }//while
        closedir($handle);
    }//if

    sort($small); //sort image names in order

    //sorting adds a 0 element and shifts all elements back 1
    //this will fix the array 
    foreach ($small as $num => $picture) {
        $small[$num+1] = $picture; 
    }
    unset($small[0]); //delete 0 element

//    print_r($small); exit;

    $galleryContent .= '<center><p style="font-size: small">Hover over image to enlarge. Click on the thumbnail to see full size image. To download this gallery, <a href="'.$site_url.'/download">click here</a>.</p></center>
	<table><tr valign="top"><td>
	<ul class="hoverbox">';
    
//	if(is_dir($directory))  
	foreach($small as $num => $picture) {
		//$num = $num + 1; //offset the 0 element
    
		list($name, $ext) = explode('.', $picture); 
		
			$readThisImg = $directory.'/'.$picture;
			$showThisImg = $site_url.'/'.$directory.'/'.$picture;
			
			if(file_exists($readThisImg)) {
				list($width, $height, $type, $attr) = getimagesize($readThisImg);

				if($thumbnails == 1) {
					$galleryContent .= '<li title="'.$anime.'" onclick="openModal(\''.$animeID.'\');currentSlide('.$num.')"><a href="#">
					<img src="'.$showThisImg.'" alt="'.$anime.'" class="episode_thumbnail" />
					<img src="'.$showThisImg.'" class="preview_large" alt="'.$anime.'" >
					</a></li>'; 
				}
				else {
                    
                    if($height > $width)
                        $class = 'preview_tall';
                    else
                        $class = 'preview_portrait';
        
					$galleryContent .= '<li title="'.$anime.'" onclick="openModal(\''.$animeID.'\');currentSlide('.$num.')"><a href="#">
					<img src="'.$showThisImg.'" alt="'.$anime.'" />
					<img src="'.$showThisImg.'" class="'.$class.'" alt="'.$anime.'" >
					</a></li>'; 
				}					
		   }      
        }//foreach
 
    $galleryContent .= '</ul></td>
    </tr></table>';

    $counter = $counter - 1; //JS arrays start at 0
 
 //display the modal elements
$galleryContent .=  '<div id="'.$animeID.'" class="modal">
<span class="close cursor" onclick="closeModal(\''.$anime.'\')">&times;</span>
<a class="prev" onclick="plusSlides(-1)">&#10094;</a>
<a class="next" onclick="plusSlides(1)">&#10095;</a>
<div class="modal-content">';

foreach($small as $num => $picture) {
    $showThisImg = $site_url.'/'.$directory.'/'.$picture;
    $galleryContent .=  '<div class="mySlides">
      <div class="numbertext">'.$num.' / '.$counter.'</div>
      <img src="'.$showThisImg.'" onclick="plusSlides(1)" class="lightbox_main_image cursor">
    </div>';
}
$galleryContent .=  '<div class="caption-container">
<p id="caption"></p>
</div>';

    //horizontal scrolling images

    foreach($small as $num => $picture) {
        $showThisImg = $site_url.'/'.$directory.'/'.$picture;
        
        $galleryContent .=  '<div class="column">
        <img class="demo cursor" src="'.$showThisImg.'" style="width:100%" onclick="currentSlide('.$num.')" alt="'.$postTitle.'">
    </div> ';
    }

    $galleryContent .=  '</div>
    </div>';

    return $galleryContent;
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