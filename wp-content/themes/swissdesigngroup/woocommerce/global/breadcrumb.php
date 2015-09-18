<?php
/**
 * Shop breadcrumb
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.3.0
 * @see         woocommerce_breadcrumb()
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! ( is_singular() && 'product' == get_post_type() ) ){

	return;
}

if ( "yes" == get_post_meta(get_the_ID(), '_virtual', true) ){

	return;
}

if ( $breadcrumb ) {

	echo $wrap_before;

	foreach ( $breadcrumb as $key => $crumb ) {

		echo $before;

		if ( ! empty( $crumb[1] ) && sizeof( $breadcrumb ) !== $key + 1 ) {

			switch (strtolower($crumb[0])) {
				case 'shop':
					echo '<a href="' . esc_url( wc_get_page_permalink( 'shop' ) ) . '">' . esc_html( $crumb[0] ) . '</a>';
					break;
				
				default:
					echo '<a href="' . esc_url( $crumb[1] ) . '">' . esc_html( $crumb[0] ) . '</a>';
					break;
			}
		}

		echo $after;

		if ( $key < sizeof( $breadcrumb ) - 2 ) {
			echo $delimiter;
		}

	}

	echo $wrap_after;

}