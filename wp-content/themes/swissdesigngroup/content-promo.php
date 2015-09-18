<?php 
if ( ! $promo = ot_get_option('promo') ){

	return;
}
?>
<div id="promo">
    <input id="promo-trigger" type="checkbox">
    <div class="container">
        <label for="promo-trigger"><i class="fa fa-times"></i></label>
        <div class="site-promo-content clearfix">
        	<?php echo apply_filters('the_content', $promo); ?>
        </div>
    </div>
</div>