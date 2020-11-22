<!DOCTYPE html>
<html <?php language_attributes(); ?>>
    <head>
        <meta charset="windows-1252">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="profile" href="http://gmpg.org/xfn/11">
        <?php wp_head(); ?>
        <?php
        $template_dir = get_template_directory_uri();
        ?>
        <link rel="stylesheet" href="<?php echo $template_dir ?>/assets/css/lightbox.css">
        <script src="<?php echo $template_dir ?>/assets/js/lightbox.js"></script>

        <!-- G Search Console -->
		<meta name="google-site-verification" content="K4GZC5J-LMQCLaRN9bLptbX2f89SaS2HrFXtAGWCTts" />		
		
		</head>
    <body id="blog" <?php body_class(); ?>>
        <?php wp_body_open(); ?>
        <div class="page-wrap">
            <?php get_template_part('template-parts/header/template-part', 'toparea'); ?>
            <?php do_action('popularis_generate_header'); ?> 