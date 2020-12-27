<?php /* Template Name: Download Anime */ 
include('api_sendgrid.php');
 
get_header(); 
 
$upload = wp_upload_dir();
$upload_dir = $upload['baseurl'];
$upload_dir = $upload_dir.'/archives/';
 
$archives = array(
	'air_gear' => array(
		'url' => $upload_dir.'air_gear.rar',
		'display' => 'Air Gear Gallery'
	),
	'amazing_nurse_nanako' => array(
		'url' => $upload_dir.'amazing_nurse_nanako.rar',
		'display' => 'Amazing Nurse Nanako Gallery'
	),
	'asura_cryin' => array(
		'url' => $upload_dir.'asura_cryin.rar',
		'display' => "Asura Cryin' Gallery"
	),
	'ex_driver' => array(
		'url' => $upload_dir.'ex_driver.rar',
		'display' => 'Ex Driver Gallery'
	),
	'majokko_megu_chan_1' => array(
		'url' => $upload_dir.'majokko_megu_chan_1.rar',
		'display' => 'Majokko Megu-chan Gallery #1'
	),
	'majokko_megu_chan_2' => array(
		'url' => $upload_dir.'majokko_megu_chan_2.rar',
		'display' => 'Majokko Megu-chan Gallery #2'
	),
);
?>

<div class="row">
    <div class="col-md-<?php popularis_main_content_width_columns(); ?>">
          <div class="post-item download">

			<div class="news-text-wrap col-md-12">
				<h2>Thank you for signing up to our anime newsletter!</h2>
			 
				<h1>Download 3500+ High Quality Images here!</h1> 
				
				<p>&nbsp;</p>
				
				<?php
				
				foreach($archives as $anime => $array) {
					echo '<p><a href="'.$array['url'].'" target="_BLANK">'.$array['display'].'</a></p>';
				}
				?>
			 
				<p>&nbsp;</p>
			</div>
		</div>
    </div>

    <?php get_sidebar('right'); ?>
</div>

<?php 
get_footer();