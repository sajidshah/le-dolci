<?php

/**
 * undocumented function
 *
 * @return void
 * @author 
 **/
function hb_modify_class_per_page( $per_page ){

	$class_per_page = intval( ot_get_option('class_per_page') );

	if ( 0 < $class_per_page ){

		return $class_per_page;
	}

	return $per_page;
}
add_filter('hb_class_per_page', 'hb_modify_class_per_page', 99, 1);

/**
 * Modify theme's body classes
 *
 * @return array
 **/
function hb_wc_body_class_filter( $classes ){

	$classes[] = 'has-shop';

	return $classes;
}
add_filter('body_class', 'hb_wc_body_class_filter');

/**
 * Generate cart icon content
 *
 * @return string
 **/
function hb_cart_trigger_content(){

	return sprintf(
		'<a class="cart-contents" href="%s"><span class="cart-title">%s</span><span class="cart-count">%s</span></a>',
		WC()->cart->get_cart_url(),
		__('My cart', HB_DOMAIN_TXT),
		WC()->cart->cart_contents_count
	);
}

/**
 * Display cart icon
 *
 * @return string
 **/
function hb_cart_trigger_display(){

	echo hb_cart_trigger_content();
}
add_action('hb_after_menu_toggle', 'hb_cart_trigger_display');


/**
 * Ensure cart contents update when products are added to the cart via AJAX
 *
 * @return array
 **/
function hb_header_add_to_cart_fragment( $fragments ) {
	
	$fragments['a.cart-contents'] = hb_cart_trigger_content();
	
	return $fragments;
}
add_filter( 'woocommerce_add_to_cart_fragments', 'hb_header_add_to_cart_fragment' );

/**
 * Checkout pages function
 *
 * @return string
 **/
function hb_checkout_pages_header_navigation(){

	if ( WC()->cart->get_cart_contents_count() > 0 ){

		wc_get_template_part('checkout', 'navigation');

	} else {

		the_title( '<h1 class="entry-title underline">', '</h1>' );
	}
}
add_action('woocommerce_page_header_navigation', 'hb_checkout_pages_header_navigation');

/**
 * Disallow displaying page banner on cart or checkout page function
 *
 * @return boolian
 **/
function disallow_woocommerce_acc_pages_banner(){

	return ( is_cart() || is_checkout() || is_account_page() )? false : true;
}
add_filter( 'hb_page_has_banner' , 'disallow_woocommerce_acc_pages_banner' );

/**
 * Get product color function
 *
 * @return string
 **/
function hb_get_product_color(){
	return get_post_meta( get_the_ID(), '_product_color', true );
}


/**
 * Get product time value function
 *
 * @return string
 **/
function hb_get_class_time_value(){
	return get_post_meta( get_the_ID(), '_class_time', true );
}

/**
 * Get product date value function
 *
 * @return string
 **/
function hb_get_class_date_value(){

	$date = trim( get_post_meta( get_the_ID(), '_class_date', true ) );

	if ( empty($date) ){
		return null;
	}

	$date 	= strtotime($date);
	$today 	= strtotime(date("Y-m-d"));

	if ( $date < $today ){

		$date = __('Passed!', HB_DOMAIN_TXT);

	} elseif ( $date == $today ) {

		$date = __('Today!', HB_DOMAIN_TXT);
	
	} else {

		$date = date('l M d', $date);
	}

	return $date;
}

/* --------------------------------------------------------------
 * Classes page actions
 * -------------------------------------------------------------- */
add_action('ledolci_class_item_after_title', 'hb_get_class_date', 5);
add_action('ledolci_class_item_footer', 'hb_get_class_availability', 5);

add_action('ledolci_class_item_featured_image', 'woocommerce_template_loop_product_thumbnail', 10);
add_action('ledolci_class_item_after_title', 'woocommerce_template_loop_price', 10);


/**
 * Class date function
 *
 * @return void
 **/
function hb_get_class_date(){

	$date = hb_get_class_date_value();

	if ( ! $date ) {
		$date = '&nbsp;';
	}

	echo '<p class="ledolci-class-date">', $date, '</p>';
}

/**
 * Class availbility function
 *
 * @return string
 **/
function hb_get_class_availability(){

	global $product;

	$brand_new_copy 			= apply_filters( 'brand_new_copy', ot_get_option('brand_new_copy') );
	$start_displaying_stock_qty = apply_filters( 'start_displaying_stock_qty', ot_get_option('start_displaying_stock_qty') );
	$availability      			= $product->get_availability();

	if ( $product->is_featured() ){

		$availability_html = '<p class="ledolci-class-stock featured">' . __( 'Featured class', 'woocommerce' ) . '</p>';

	} else {

		$availability_html = '<p class="ledolci-class-stock brand-new">' . $brand_new_copy . '</p>';

		if ( ! empty( $availability['availability'] ) && $product->managing_stock() ) {

			if ( ! $product->is_in_stock() || ($product->is_in_stock() && $product->get_stock_quantity() <= $start_displaying_stock_qty) ){

				$availability_html = '<p class="ledolci-class-stock stock ' . esc_attr( $availability['class'] ) . '">' . esc_html( $availability['availability'] ) . '</p>';
			}
		}

	}

	echo apply_filters( 'woocommerce_stock_html', $availability_html, $availability['availability'], $product );
}

/**
 * undocumented function
 *
 * @return int
 **/
function hb_start_displaying_stock_qty( $qty ){

	$qty = intval($qty);

	return $qty ? $qty : 5;
}
add_filter('start_displaying_stock_qty', 'hb_start_displaying_stock_qty', 99, 1);

/**
 * undocumented function
 *
 * @return string
 * @author 
 **/
function hb_brand_new_copy( $txt ){

	$txt = trim(wp_strip_all_tags($txt));

	return $txt ? $txt : __( 'Brand new!!!', 'woocommerce' );
}
add_filter('brand_new_copy', 'hb_brand_new_copy', 99, 1);

/**
 * Product edit page scripts
 *
 * @return string
 **/
function hb_edit_product_page_scripts(){

	wp_enqueue_script( 'edit-product-page-scripts', get_template_directory_uri() . '/js/edit-product.js' );
}
add_action( 'admin_enqueue_scripts', 'hb_edit_product_page_scripts' );


/**
 *  define the field on the edit product page,
 *
 * @return array
 */
function hb_virtual_product_date_field() {

	woocommerce_wp_text_input( 
		array( 
			'id' => '_class_date',
			'class' => 'short',
			'label' => __( 'Class Date', 'woocommerce' )
		)
	);

}
add_action( 'woocommerce_product_options_pricing', 'hb_virtual_product_date_field' );

/**
 *  Save the data when the product gets updated
 *
 * @return array
 */
function hb_date_field_save_product( $product_id ) {

    // If this is a auto save do nothing, we only save when update button is clicked
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ){
		return;
	}
	if ( isset($_POST['_class_date']) && !empty($_POST['_class_date']) ) {

		if ( preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/",$_POST['_class_date']) ){
			update_post_meta( $product_id, '_class_date', $_POST['_class_date'] );
		}

	} else {

		delete_post_meta( $product_id, '_class_date' );
	}
}
add_action( 'save_post', 'hb_date_field_save_product' );


/**
 *  define the field on the edit product page,
 *
 * @return array
 */
function hb_virtual_product_time_field() {

	woocommerce_wp_text_input( 
		array( 
			'id' => '_class_time',
			'class' => 'short',
			'label' => __( 'Class Time', 'woocommerce' )
		)
	);

}
add_action( 'woocommerce_product_options_pricing', 'hb_virtual_product_time_field' );

/**
 *  Save the time when the product gets updated
 *
 * @return array
 */
function hb_time_field_save_product( $product_id ) {

    // If this is a auto save do nothing, we only save when update button is clicked
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ){
		return;
	}
	if ( isset($_POST['_class_time']) && !empty($_POST['_class_time']) ) {

		update_post_meta( $product_id, '_class_time', $_POST['_class_time'] );

	} else {

		delete_post_meta( $product_id, '_class_time' );
	}
}
add_action( 'save_post', 'hb_time_field_save_product' );


/**
 *  define the field on the edit product page,
 *
 * @return array
 */
function hb_product_colorpicker() {

	woocommerce_wp_text_input( 
		array( 
			'id' => '_product_color',
			'class' => 'short',
			'label' => __( 'Product Color', 'woocommerce' )
		)
	);
}
add_action( 'woocommerce_product_options_pricing', 'hb_product_colorpicker' );

/**
 *  Save the data when the product gets updated
 *
 * @return array
 */
function hb_colorpicker_save_product( $product_id ) {

    // If this is a auto save do nothing, we only save when update button is clicked
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ){
		return;
	}
	if ( isset($_POST['_product_color']) && !empty($_POST['_product_color']) ) {

		$color = hb_sanitize_hex_color( $_POST['_product_color'] );

		if ( $color ){
			update_post_meta( $product_id, '_product_color', $color );
		}

	} else {

		delete_post_meta( $product_id, '_product_color' );
	}
}
add_action( 'save_post', 'hb_colorpicker_save_product' );

/**
 * Execute virtual products from shop archive pages
 *
 * @return object
 */
function hb_shop_filter_product_type($query) {

    if ( !is_admin() && $query->is_main_query() ) {

    	if ( is_post_type_archive( 'product' ) || is_product_category() || is_product_tag() ) {
			$query->set('meta_query', array(
				array (
					'key' 		=> '_virtual',
					'value' 	=> 'no',
					'compare' 	=> 'IN'
					)
				)
			);
		}
    }
}
add_action( 'pre_get_posts' , 'hb_shop_filter_product_type' );


/**
 * Change virtual product availability copy
 *
 * @return array
 */
function hb_get_virtual_product_availability($availability, $product){

	if ( ! $product->is_virtual() ){

		return $availability;
	}

	$availability = $class = '';

	if ( $product->managing_stock() ) {
		if ( $product->is_in_stock() && $product->get_stock_quantity() > get_option( 'woocommerce_notify_no_stock_amount' ) ) {
			switch ( get_option( 'woocommerce_stock_format' ) ) {
				case 'no_amount' :
					$availability = __( 'In stock', 'woocommerce' );
				break;
				case 'low_amount' :
					if ( $product->get_stock_quantity() <= get_option( 'woocommerce_notify_low_stock_amount' ) ) {
						$availability = sprintf( __( 'Only %s left in stock', 'woocommerce' ), $product->get_stock_quantity() );

						if ( $product->backorders_allowed() && $product->backorders_require_notification() ) {
							$availability .= ' ' . __( '(can be backordered)', 'woocommerce' );
						}
					} else {
						$availability = __( 'In stock', 'woocommerce' );
					}
				break;
				default :
					$availability = sprintf( _n( 'Only %s spot left', '%s spots left', $product->get_stock_quantity(), 'woocommerce' ), $product->get_stock_quantity() );

					if ( $product->backorders_allowed() && $product->backorders_require_notification() ) {
						$availability .= ' ' . __( '(can be backordered)', 'woocommerce' );
					}
				break;
			}
			$class        = 'in-stock';
		} elseif ( $product->backorders_allowed() && $product->backorders_require_notification() ) {
			$availability = __( 'Available on backorder', 'woocommerce' );
			$class        = 'available-on-backorder';
		} elseif ( $product->backorders_allowed() ) {
			$availability = __( 'In stock', 'woocommerce' );
			$class        = 'in-stock';
		} else {
			$availability = __( 'Out of stock', 'woocommerce' );
			$class        = 'out-of-stock';
		}
	} elseif ( ! $product->is_in_stock() ) {
		$availability = __( 'Out of stock', 'woocommerce' );
		$class        = 'out-of-stock';
	}

	return apply_filters( 'hb_get_virtual_product_availability', array( 'availability' => $availability, 'class' => $class ), $product );
}
add_filter( 'woocommerce_get_availability', 'hb_get_virtual_product_availability', 99 , 2 );

/**
 * Generate class popup content function
 *
 * @return string | html | int
 **/
function hb_class_popup_function(){

	if ( ! wp_verify_nonce( $_POST['nonce'], 'hb-ajax' ) ) die ( 'Nahhh!');

	$classid = url_to_postid($_POST['classurl']);

	if ( ! $classid ) die(503);

	$args = array(
		'post_type' 		=> 'product',
		'post__in' 			=> array( $classid ),
		);

	$loop = new WP_Query( $args );

	if ( $loop->have_posts() ) {

		// Start the loop.
		while ( $loop->have_posts() ) : $loop->the_post();

			echo '<div class="popup-inner">';
				echo '<div class="popup-entry">';
					echo '<a class="close-popup"><i class="fa fa-times"></i></a>';
					wc_get_template_part( 'content', 'class-popup' );
				echo '</div>';
			echo '</div>';

		endwhile;

	} else {

		echo 404;
	}

	wp_reset_postdata();

	exit();
}
add_action( 'wp_ajax_hb_class_popup', 'hb_class_popup_function' ); 
add_action( 'wp_ajax_nopriv_hb_class_popup', 'hb_class_popup_function' );
