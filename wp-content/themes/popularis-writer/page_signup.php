<?php /* Template Name: Signup Page */ 
include('api_sendgrid.php');
 
get_header(); 
//echo $list_id;
$site_url = get_site_url();

$img_zip = $site_url.'/wp-content/uploads/images/signup/zip_galleries.png';
$img_cc = $site_url.'/wp-content/uploads/images/signup/cc_pizza.png';

$_POST = true;

if($_POST) {
	$email = $_POST['email'];

	$sendGridAPI = new sendGridAPI(SENDGRID_API_KEY);
	
	//add contact to list
	$info = array(
		'list_id' => $list_id,
		'contact' => array(
			'email' => $email, //contact's main email
			'join_date' => date('Y-m-d'), //today's date
			)
	);

	$sendGridAPI->contact_add($info);
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
				
				<h1>You Can Directly Download all our Fanservice Galleries in Zip format!</h1> 
				
				<h2>Get 3500+ High Quality Images of anime fanservice on your computer - It's better than downloading one image at a time</h2>

				<p><img src="<?=$img_zip ?>" class="signup_image" /></p>
				
				<p>&nbsp;</p>
				
				<form name="sendgrid" method="POST">
					<h3>Download link will be delivered to your email by CC!</h3>
					<div class="form_left">
					<p><img src="<?=$img_cc ?>" class="CC Pizza" /></p>
					</div>

					<div class="form_right">
						
							<input type="text" class="email" name="email" id="email" placeholder="Enter your best email" title="Enter your best email" />
							
							<input type="submit" name="submit" class="signup_button" value="Join Us Now" onclick="return validateEmail(document.sendgrid.email.value);">
						
					</div>
					<div class="clear"></div>
					<p class="note">
					We hate spam and will never sell your email address to others. All opt-ins are completely optional.</p>
				</form>
				
			
				<p>&nbsp;</p>
			</div>
		</div>
    </div>

    <?php get_sidebar('right'); ?>

</div>

<?php 
get_footer();