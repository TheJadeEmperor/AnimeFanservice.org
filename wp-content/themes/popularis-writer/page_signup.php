<?php /* Template Name: Signup Page */ 
include('api_sendgrid.php');
 
get_header(); 
//echo $list_id;


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
			$_POST = true;
			$emailAddress = '';
			if($_POST) {
			?>

			<h2>Thank you for signing up. Expect your download link to hit your inbox soon! Make sure to add <a href="mailto:<?=$emailAddress?>"><?=$emailAddress?></a> to your safelist! </h2>

			 
			<?
			}

			?>
				
				<h1>Download our Fanservice Galleries in Zip format!</h1> 
				
				<h2>Get 3500+ High Quality Images of anime fanservice on your computer! </h2>
		
				<h2>Enter your email below for download link</h2>
				
				<form name="sendgrid" method="POST">
	 
					<input type="text" class="field" name="email" id="email" placeholder="Enter your best email" title="Enter your best email" />
					 
					<input type="submit" name="submit" id="submit" class="submit" value="Join Us Now" onclick="return validateEmail(document.sendgrid.email.value);">
				</form>
				<p>&nbsp;</p>
			</div>
		</div>
    </div>

    <?php get_sidebar('right'); ?>

</div>


<?php 
get_footer();