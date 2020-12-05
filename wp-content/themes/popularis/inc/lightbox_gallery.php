<?php

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
    <p id="caption">'.$postTitle.' 
    <span class="lightbox_download"><a href="'.$site_url.'/download">Download entire gallery</a></span></p>
    </div>';

    //horizontal scrolling images
    foreach($small as $num => $picture) {
        $showThisImg = $site_url.'/'.$directory.'/'.$picture;
        
        $galleryContent .= '<div class="column">
        <img class="demo cursor" src="'.$showThisImg.'" style="width:100%" onclick="currentSlide('.$num.')" alt="'.$postTitle.'">
    </div> ';
    }

    $galleryContent .= '</div>
    </div>';

    return $galleryContent;
}

function donate () {
    echo '
    <p style="margin-bottom: 15px">You can donate Bitcoin to help us keep the site running! Use the QR code to send us BTC or send it directly to the BTC address below.</p>
    
    <p style="margin-bottom: 15px"><img src="https://animefanservice.org/wp-content/uploads/archives/btc_addr.png" /></p>

    <p><span style="font-size: 12px">36M2Ltz38y1zyhJBCpYUmAywReqU6JyGWX</span></p>
    ';
}

?>