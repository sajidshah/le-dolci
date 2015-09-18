<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
?>
<div id="hb-shop-header">
	<div class="container">
		<?php if ( apply_filters( 'woocommerce_shop_header_title', true ) ) : ?>
			<h1 class="page-title"><?php woocommerce_page_title(); ?></h1>
		<?php endif; ?>
		<?php
			/**
			 * woocommerce_archive_description hook
			 * 
			 * @hooked woocommerce_taxonomy_archive_description - 10
			 * @hooked woocommerce_product_archive_description - 10
			 * @hooked hb_shop_description - 10
			 */
			do_action( 'woocommerce_archive_description' );
		?>
	</div>
</div>