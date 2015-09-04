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

$color = hb_get_product_color();
$style = $color ? 'style="color:'.esc_attr($color).' !important"' : '';

?>
<a href="<?php echo esc_url(get_permalink()); ?>" data-classid="<?php echo esc_attr(get_the_ID()); ?>" class="ledolci-class no-ajax hb-animate" data-animation="fadeIn" <?php echo $style; ?>>

	<div class="ledolci-class-content clearfix">
		<div class="ledolci-class-thumb">
			<?php do_action('ledolci_class_item_featured_image'); ?>	
		</div>
		<div class="ledolci-class-entry">
			<h3><?php the_title(); ?></h3>
			<?php do_action('ledolci_class_item_after_title'); ?>
		</div>
	</div>
	<div class="ledolci-class-footer">
		<?php do_action('ledolci_class_item_footer'); ?>
	</div>
</a>