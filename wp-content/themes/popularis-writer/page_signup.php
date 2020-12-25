<?php /* Template Name: Signup Page */ 
include('api_sendgrid.php');
 
get_header(); 
//echo $list_id;
$site_url = get_site_url();

$collage_asura_cryin = $site_url.'/wp-content/uploads/images/signup/collage_asura_cryin.png';
$collage_megu_chan = $site_url.'/wp-content/uploads/images/signup/collage_megu_chan.png';
$collage_venus_5 = $site_url.'/wp-content/uploads/images/signup/collage_venus_5.jpg';
$collage_air_gear = $site_url.'/wp-content/uploads/images/signup/collage_air_gear.png';

$img_cc = $site_url.'/wp-content/uploads/images/signup/cc_pizza.png';

if($_POST) {
	$subscriberEmail = $_POST['email'];

	$sendGridAPI = new sendGridAPI(SENDGRID_API_KEY);
	
	//add contact to list
	$info = array(
		'list_id' => $list_id,
		'contact' => array(
			'email' => $subscriberEmail, //contact's main email
			'join_date' => date('Y-m-d'), //today's date
			'origin' => $_POST['origin'] //page tracking 
			)
	);

	$sendGridAPI->contact_add($info);

	//connect to database, returns resource 
	$conn = new mysqli($dbHost, $dbUser, $dbPW, $dbName); 

	//get newsl day 0 from db 
	$series = 'AnimeFanservice';
	$query = 'SELECT * FROM newsletters WHERE series="'.$series.'" AND day = "0"';
	$result = mysqli_query($conn, $query);
	$news = $result->fetch_assoc();
		
	//print_r($news);
	//echo $news['html_code'];

	$subscriberName = 'Anime Fan';
	$htmlContent = $news['html_code']; 

	$newsletterData = array(
		'subject' => $news['subject'],
		'senderName' => 'Anime Empire',
		'subscriberName' => $subscriberName,
		'subscriberEmail' => $subscriberEmail,
		'htmlContent' => $htmlContent,
	);
	
	sendEmail($sendgridClass, $sendgridMail, $newsletterData); 
	
}
?>
<script>
function validateEmail(email) {
		console.log(email);
	if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{3,4})+$/.test(email)) {
		return true;
	}
	else {
		alert("You have entered an invalid email address!");
		return false;
	}
}
</script>

<div class="row">

    <div class="col-md-<?php popularis_main_content_width_columns(); ?>">
          <div class="post-item signup">

			<div class="news-text-wrap col-md-12">
			<?
			
			$emailAddress = 'animefavoritechannel@gmail.com';
			if($_POST) {
				echo '
				<h3>Thank you for signing up. Expect your download link to hit your inbox soon! Make sure to add <a href="mailto:'.$emailAddress.'">'.$emailAddress.'</a> to your safelist! </h3>';
			}
			?>
				
				<h1>You Can Directly Download all our Fanservice Galleries in zip format for Free!</h1> 
				
				<h2>Get 4000+ High Quality Images of anime fanservice on your computer - It's better than downloading one image at a time</h2>

				<p><img src="<?=$collage_asura_cryin ?>" class="signup_image" /></p>
				
				<p>&nbsp;</p>
				
				<form name="sendgrid" method="POST">
					<h3>Download link will be delivered to your email personally by CC!</h3>
					<div class="form_left">
					<p><img src="<?=$img_cc ?>" class="CC Pizza" /></p>
					</div>

					<div class="form_right">
						<input type="hidden" name="origin" value="/download" />
						<input type="text" class="email" name="email" id="email" placeholder="Enter your best email" title="Enter your best email" />
						
						<input type="submit" name="submit" class="signup_button" value="Join Us Now" onclick="return validateEmail(document.sendgrid.email.value);">
					</div>
					<div class="clear"></div>
					<p class="note">
					We hate spam and will never sell your email address to others. All opt-ins are completely optional.</p>
				</form>
				
				<p>&nbsp;</p>

				<h3>These images are copyright free and you can use them for personal or commercial purposes. Did we mention they are all FREE?</h3>
			</div>

			<img src="<?=$collage_megu_chan ?>" class="signup_image" width="50%" />

			<img src="<?=$collage_venus_5 ?>" class="signup_image" width="50%" />

			<img src="<?=$collage_air_gear ?>" class="signup_image" width="50%" />

			<p>&nbsp;</p>
		</div>
    </div>

    <?php get_sidebar('right'); ?>

</div>

<?php 
get_footer();