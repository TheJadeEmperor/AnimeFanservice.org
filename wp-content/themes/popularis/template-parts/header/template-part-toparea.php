<?php 
$site_url = get_site_url();
?>
<?php if (is_active_sidebar('popularis-top-bar-area')) { ?>
    <div class="top-bar-section container-fluid">
        <div class="container">
            <div class="row">
                <?php dynamic_sidebar('popularis-top-bar-area'); ?>

                <div class="social_media_header">
                    <ul>
                        <li><a href="https://www.youtube.com/channel/UCoUMU1nKObhrVmnN7RKdtmg" target="_BLANK"><i class="fa fa-youtube"></i></a></li>
                        
                        <li><a href="https://www.instagram.com/anime.motivation.quotes/" target="_BLANK"><i class="fa fa-instagram"></i></a></li>

                        <li><a href="<?php echo $site_url?>/download"><i class="fa fa-envelope-open"></i></a></li>
                    </ul>
                </div>

            </div>
        </div>
    </div>
<?php }