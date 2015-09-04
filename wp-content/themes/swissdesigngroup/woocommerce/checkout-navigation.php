<?php

global $woocommerce;

$is_cart 		= is_cart();
$is_checkout 	= is_checkout();

$steps = array(

	array(
		'title' 	=> __('Shopping Cart', 'woocommerce'),
		'active' 	=> $is_cart,
		'complete'  => $is_checkout ? true : false,
		'link'		=> $is_checkout ? sprintf('<a href="%s"><span class="says">%s</span></a>', $woocommerce->cart->get_cart_url(), __('Cart', 'woocommerce')) : '',
	),
	array(
		'title' 	=> __('Address &amp; Payment', 'woocommerce'),
		'active' 	=> $is_checkout,
		'complete'  => false,
		'link'		=> '',
	),
	array(
		'title' 	=> __('Review', 'woocommerce'),
		'active' 	=> false,
		'complete'  => false,
		'link'		=> '',
	),
);

?>
<div class="checkout-navigation">
	<?php foreach ($steps as $index => $step) { 

		$classes = array('col-xs-4 step-item');

		if ( $step['active'] ){
			$classes[] = 'active';
		}

		if ( $step['complete'] ){
			$classes[] = 'complete';
		}
		
		?> 
		<div class="<?php echo implode(' ', $classes); ?>">
			<div class="row">
				<span class="step-line col-xs-5 col-sm-5"></span>
				<span class="step-index col-xs-2 col-sm-2"><?php echo $index + 1; ?></span>
				<span class="step-line col-xs-5 col-sm-5"></span>
			</div>
			<div class="row">
				<span class="step-title col-xs-12"><?php echo $step['title'] ?></span>
			</div>
			<?php echo $step['link']; ?>
		</div>
	<?php } ?>
</div>