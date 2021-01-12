<?php /* Template Name: Signup Page OST */ 
//required sendGrid API 
require ($sendGridVendor); 
include ('api_sendgrid.php');
 
get_header(); 

$site_url = get_site_url();

$cd_gw_1 = $site_url.'/wp-content/uploads/images/signup/cd_gw_1.jpg';
$cd_gw_2 = $site_url.'/wp-content/uploads/images/signup/cd_gw_2.jpg';
$cd_gw_3 = $site_url.'/wp-content/uploads/images/signup/cd_gw_3.jpg';
$cd_gw_4 = $site_url.'/wp-content/uploads/images/signup/cd_gw_4.jpg';

$img_cc = $site_url.'/wp-content/uploads/images/signup/cc_pizza.png';

if($_POST) {
	$subscriberEmail = $_POST['email'];

	$sendgridMail = new \SendGrid\Mail\Mail(); 
	$sendgridClass = new \SendGrid(SENDGRID_API_KEY);
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
	
	//disable email form 
	$dis = 'disabled'; 
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
				
				<h1>You Can Directly Download all our Original Sound Tracks for Free!</h1> 
				
				<h2>Get 200+ High Quality MP3's of Gundam Wing OST, Code Geass OST, Saint Seiya OST and many more shows!</h2>

				<p>&nbsp;</p>

				<img src="<?=$cd_gw_1 ?>" class="ost_image" />

				<img src="<?=$cd_gw_2 ?>" class="ost_image" />

				<img src="<?=$cd_gw_3 ?>" class="ost_image" />

				<img src="<?=$cd_gw_4 ?>" class="ost_image" />
	
				<p>&nbsp;</p>
				
				<form name="sendgrid" method="POST">
					<h3>Download link will be delivered to your email personally by CC!</h3>
					<div class="form_left">
					<p><img src="<?=$img_cc ?>" class="CC Pizza" /></p>
					</div>

					<div class="form_right">
						<input type="hidden" name="origin" value="download-ost" />
						<input type="text" class="email" name="email" id="email" placeholder="Enter your best email" title="Enter your best email" <?=$dis?> />
						
						<input type="submit" name="submit" class="signup_button" value="Join Us Now" onclick="return validateEmail(document.sendgrid.email.value);" <?=$dis?> />
					</div>
					<div class="clear"></div>
					<p class="note">
					We hate spam and will never sell your email address to others. All opt-ins are completely optional.</p>
				</form>
				
				<p>&nbsp;</p>

				<h3>These OST's are copyright free and you can use them for personal or commercial purposes. Did we mention they are all FREE?</h3>
			</div>

			<p>&nbsp;</p>
		</div>

		<p>&nbsp;</p><p>&nbsp;</p>
		<?php echo productsModule(); ?>
    </div>

    <?php get_sidebar('right'); ?>

</div>

<?php 
get_footer();