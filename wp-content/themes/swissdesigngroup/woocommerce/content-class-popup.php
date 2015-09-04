<?php
/**
 * The template for displaying class content within loops.
 *
 * @package WordPress
 * @subpackage Swiss_Design_Group
 * @since Swiss Design Group 1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $product;

$color = hb_get_product_color();
$style = $color ? 'style="color:'.esc_attr($color).' !important"' : '';
$date  = hb_get_class_date_value();
$time  = hb_get_class_time_value();
?>
<div data-classid="<?php echo esc_attr(get_the_ID()); ?>" <?php post_class('clearfix'); ?>>
	<div class="ledolci-popup-media">
		<?php do_action('ledolci_class_item_featured_image'); ?>
	</div>

	<div class="ledolci-popup-content">
		<h3 class="ledolci-popup-title zigzag" <?php echo $style; ?>><span><?php the_title(); ?></span></h3>
		<?php echo ( $date || $time ) ? sprintf('<h5 class="ledolci-popup-time">%s %s</h5>', $date, $time) : ''; ?>
		<div class="ledolci-popup-description">
			<?php the_excerpt(); ?>
		</div>

		<div class="ledolci-popup-btns">
			<?php  
			echo apply_filters( 'woocommerce_loop_add_to_cart_link',
				sprintf( '<a href="%s" rel="nofollow" data-product_id="%s" data-product_sku="%s" data-quantity="%s" class="button %s product_type_%s">%s</a>',
					esc_url( $product->add_to_cart_url() ),
					esc_attr( $product->id ),
					esc_attr( $product->get_sku() ),
					esc_attr( isset( $quantity ) ? $quantity : 1 ),
					$product->is_purchasable() && $product->is_in_stock() ? 'add_to_cart_button' : '',
					esc_attr( $product->product_type ),
					esc_html( $product->add_to_cart_text() )
				),
			$product );
			?>
		</div>

		<a href="<?php echo esc_url(get_permalink()); ?>" class="learnmore"><?php _e('Learn more about classes', HB_DOMAIN_TXT) ?></a>
	</div>
</div>