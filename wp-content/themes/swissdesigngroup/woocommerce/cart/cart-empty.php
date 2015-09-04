<?php
/**
 * Empty cart page
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

wc_print_notices();

?>

<h1 class="cart-empty"><?php _e( 'Bummer, your cart is empty.', 'woocommerce' ) ?></h1>
<h5 class="get-started"><?php _e( 'Get started with the options below.', 'woocommerce' ) ?></h5>

<?php do_action( 'woocommerce_cart_is_empty' ); ?>

<p class="return-to-shop">
	<?php 
	$classes = get_page_by_path('/class-schedule/');
	if ( $classes ): ?>
	<a class="button wc-backward" href="<?php echo esc_url(get_permalink($classes->ID)); ?>"><?php _e( 'Register a Class', 'woocommerce' ) ?></a>
	<?php endif; ?>
	<a class="button wc-backward" href="<?php echo apply_filters( 'woocommerce_return_to_shop_redirect', wc_get_page_permalink( 'shop' ) ); ?>"><?php _e( 'Order Online', 'woocommerce' ) ?></a>
</p>
