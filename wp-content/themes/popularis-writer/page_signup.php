<?php /* Template Name: Signup Page */ 
include('api_sendgrid.php');
 
get_header(); 
//echo $list_id;
$site_url = get_site_url();

$img_url = $site_url.'/wp-content/uploads/archives/zip_galleries.png';


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
          <div class="post-item download">

			<div class="news-text-wrap col-md-12">
			<?
			
			$emailAddress = 'animefavoritechannel@gmail.com';
			if($_POST) {
			?>

			<h2>Thank you for signing up. Expect your download link to hit your inbox soon! Make sure to add <a href="mailto:<?=$emailAddress?>"><?=$emailAddress?></a> to your safelist! </h2>

			<?
			}

			?>
				
				<h1>You Can Directly Download all our Fanservice Galleries in Zip format!</h1> 
				
				<h2>Get 3500+ High Quality Images of anime fanservice on your computer - It's better than downloading one image at a time</h2>

				<p><img src="<?=$img_url?>" class="signup_image" /></p>
				
		
				<h3>Enter your email below for your download link</h3>
				
				<form name="sendgrid" method="POST">
	 
					<input type="text" class="email" name="email" id="email" placeholder="Enter your best email" title="Enter your best email" />
					
					<input type="submit" name="submit" class="signup" value="Join Us Now" onclick="return validateEmail(document.sendgrid.email.value);">

					<p><span class="note">
					We hate spam and will never sell your email address to others. All opt-ins are completely optional.</span></p>
				</form>
				
				<p>&nbsp;</p>
			</div>
		</div>
    </div>

    <?php get_sidebar('right'); ?>

</div>


<?php 
get_footer();