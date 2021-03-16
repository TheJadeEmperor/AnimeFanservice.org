<?php 
$site_url = get_site_url();
$hxh_mug = $site_url.'/wp-content/uploads/images/featured_products/mug_hunter_1.jpg';
$hxh_url = 'https://www.etsy.com/shop/AnimeEmpireShop';
?>
<aside id="sidebar" class="col-md-4 col-md-pull-8">

   <!--   <div id="custom_html-2" class="widget_text widget widget_custom_html" title="Featured Product of the Day">
    <div class="widget-title"><h3>Featured Product of the Day</h3></div>
    <div class="textwidget custom-html-widget">

 <a href="<?=$hxh_url?>" target="_BLANK"><img src="<?=$hxh_mug?>" width="90%" /></a>
<p class="featured_product"> <a href="<?=$hxh_url?>" target="_BLANK">Click here to get the mug now while supplies last</a></p> 
    </div>

    </div>-->

    <?php dynamic_sidebar('sidebar-1'); ?>
</aside>