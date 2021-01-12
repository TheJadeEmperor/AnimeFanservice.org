<?php /* Template Name: Download Anime */ 
include('api_sendgrid.php');
 
get_header(); 
 
$upload = wp_upload_dir();
$upload_dir = $upload['baseurl'];
$upload_dir = $upload_dir.'/archives/';
$geass_dir = $upload_dir.'ost_geass/';
$gw_dir = $upload_dir.'ost_gw/';
 
$archives = array(
	'air_gear' => array(
		'url' => $upload_dir.'air_gear.zip',
		'display' => 'Air Gear Gallery'
	),
	'amazing_nurse_nanako' => array(
		'url' => $upload_dir.'amazing_nurse_nanako.zip',
		'display' => 'Amazing Nurse Nanako Gallery'
	),
	'asura_cryin' => array(
		'url' => $upload_dir.'asura_cryin.zip',
		'display' => "Asura Cryin' Gallery"
	),
	'ex_driver' => array(
		'url' => $upload_dir.'ex_driver.zip',
		'display' => 'Ex Driver Gallery'
	),
	'majokko_megu_chan_1' => array(
		'url' => $upload_dir.'majokko_megu_chan_1.zip',
		'display' => 'Majokko Megu-chan Gallery #1'
	),
	'majokko_megu_chan_2' => array(
		'url' => $upload_dir.'majokko_megu_chan_2.zip',
		'display' => 'Majokko Megu-chan Gallery #2'
	),
	'venus_5' => array(
		'url' => $upload_dir.'venus_5.zip',
		'display' => 'Venus 5 Gallery'
	),
);

$ostGW = array(
	'op_1' => array(
		'url' => $gw_dir.'Gundam Wing Operation 1.zip',
		'display' => 'Gundam Wing Operation 1'
	),
	'op_2' => array(
		'url' => $gw_dir.'Gundam Wing Operation 2.zip',
		'display' => 'Gundam Wing Operation 2'
	),
	'op_3' => array(
		'url' => $gw_dir.'Gundam Wing Operation 3.zip',
		'display' => 'Gundam Wing Operation 3'
	),
	'op_4' => array(
		'url' => $gw_dir.'Gundam Wing Operation 4.zip',
		'display' => 'Gundam Wing Operation 4'
	)
);

$ostGeass = array(
	'op_end' => array(
		'url' => $geass_dir.'OP & END.zip',
		'display' => 'Openings & Endings'
	),
	'ost_1_1' => array(
		'url' => $geass_dir.'OST-1.zip',
		'display' => 'OST 1-1'
	),
	'ost_1_2' => array(
		'url' => $geass_dir.'OST-1.zip',
		'display' => 'OST 1-2'
	),
	'ost_2_1' => array(
		'url' => $geass_dir.'R2 OST-1.zip',
		'display' => 'OST 2-1'
	),
	'ost_2_2' => array(
		'url' => $geass_dir.'R2 OST-2.zip',
		'display' => 'OST 2-2'
	),

	'sound_s_1' => array(
		'url' => $geass_dir.'Code Geass S-1 Sound Episodes.zip',
		'display' => 'Code Geass S-1 Sound Episodes'
	),
	'sound_r2_1' => array(
		'url' => $geass_dir.'Code Geass R2 Sound Episode 1.zip',
		'display' => 'Code Geass R2 Sound Episode 1'
	),
	'sound_r2_2' => array(
		'url' => $geass_dir.'Code Geass R2 Sound Episode 2.zip',
		'display' => 'Code Geass R2 Sound Episode 2'
	),
	'sound_r2_3' => array(
		'url' => $geass_dir.'Code Geass R2 Sound Episode 3.zip',
		'display' => 'Code Geass R2 Sound Episode 3'
	),
	'sound_r2_4' => array(
		'url' => $geass_dir.'Code Geass R2 Sound Episode 4.zip',
		'display' => 'Code Geass R2 Sound Episode 4'
	),
	'sound_r2_5' => array(
		'url' => $geass_dir.'Code Geass R2 Sound Episode 5.zip',
		'display' => 'Code Geass R2 Sound Episode 5'
	),
	'sound_r2_6' => array(
		'url' => $geass_dir.'Code Geass R2 Sound Episode 6.zip',
		'display' => 'Code Geass R2 Sound Episode 6'
	),

);
?>

<div class="row">
    <div class="col-md-<?php popularis_main_content_width_columns(); ?>">
          <div class="post-item download">

			<div class="news-text-wrap col-md-12">
				<h2>Thank you for signing up to our anime newsletter!</h2>
			 
				<h1>Download 4000+ High Quality Images here!</h1> 
				
				<p>&nbsp;</p>
				
				<h2>Anime Galleries</h2>
				<?php				
				foreach($archives as $anime => $array) {
					echo '<p><a href="'.$array['url'].'" target="_BLANK">'.$array['display'].'</a></p>';
				}
				?>

				<h2>Gundam Wing OST</h2>
				<?php				
				foreach($ostGW as $ost => $array) {
					echo '<p><a href="'.$array['url'].'" target="_BLANK">'.$array['display'].'</a></p>';
				}
				?>

				<h2>Code Geass OST</h2>
				<?php				
				foreach($ostGeass as $ost => $array) {
					echo '<p><a href="'.$array['url'].'" target="_BLANK">'.$array['display'].'</a></p>';
				}
				?>

			 
				<p>&nbsp;</p>
			</div>
		</div>

		<p>&nbsp;</p><p>&nbsp;</p>
		<?php echo productsModule(); ?>
	</div>

	<?php get_sidebar('right'); ?>
	
</div>

<?php 
get_footer();