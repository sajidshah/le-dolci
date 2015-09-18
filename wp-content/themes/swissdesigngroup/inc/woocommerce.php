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

	return ( is_cart() 
		|| is_checkout() 
		|| is_account_page() 
		|| ( is_singular() && 'product' == get_post_type() )
		|| is_shop()
		|| is_product_category()
		|| is_product_tag() )? false : true;
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

/**
 * Get product date value function
 *
 * @return null | boolien
 **/
function hb_get_class_date_status( $product = null ){

	$id = $product ? $product->id : get_the_ID();

	$date = trim( get_post_meta( $id, '_class_date', true ) );

	if ( empty($date) ){
		return null;
	}

	$date 	= strtotime($date);
	$today 	= strtotime(date("Y-m-d"));

	return ( $date < $today ) ? false : true;
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

function hb_change_breadcrumb_delimiter( $defaults ) {
	
	$defaults['delimiter'] = ' <span class="delimiter">&frasl;</span> ';
	return $defaults;
}
add_filter( 'woocommerce_breadcrumb_defaults', 'hb_change_breadcrumb_delimiter' );

remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20);
add_action('woocommerce_single_product_summary', 'hb_class_template_single_date_time', 8);
add_action('woocommerce_single_product_summary', 'hb_class_template_single_excerpt', 20);
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40);

remove_action('woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10);
remove_action('woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15);
remove_action('woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20);

function hb_class_template_single_date_time(){

	global $post;

	if ( "yes" != get_post_meta($post->ID, '_virtual', true) ){

		return;
	}

	$date  = hb_get_class_date_value();
	$time  = hb_get_class_time_value();

	if ( !$date && !$time ){
		return;
	}

	if ( hb_get_class_date_status() ){

		$date .= sprintf(' %s', $time);
	}

	echo  sprintf('<h5 class="ledolci-popup-time">%s</h5>', $date);
}

function hb_class_template_single_excerpt(){

	global $post;

	if ( "yes" != get_post_meta($post->ID, '_virtual', true) || ! trim($post->post_content) ){

		return;
	}

	echo sprintf('<h2>%s</h2>', __('Class Description', HB_DOMAIN_TXT));
	the_content();
}

function hb_single_product_image_html( $html, $post_ID ){

	if ( has_post_thumbnail($post_ID) ) {

		return get_the_post_thumbnail( $post_ID, 'full', array(
			'title'	=> '',
			'alt'	=> esc_attr( get_the_title( get_post_thumbnail_id($post_ID) ) )
			) );

	} else {

		return sprintf( '<img src="%s" alt="%s" />', wc_placeholder_img_src(), __( 'Placeholder', 'woocommerce' ) );
	}
}
add_filter('woocommerce_single_product_image_html', 'hb_single_product_image_html', 99, 2 );

add_filter( 'woocommerce_single_product_image_thumbnail_html', '__return_null' ); 

function hb_single_product_summary_before(){

	echo '<div id="hb-single-product-summary" class="container">';
}
add_action('woocommerce_before_single_product_summary', 'hb_single_product_summary_before', 1);

function hb_single_product_summary_after(){

	echo '</div><!--#hb-single-product-summary-->';
}
add_action('woocommerce_after_single_product_summary', 'hb_single_product_summary_after', 1);

function hb_single_product_description(){

	global $post;

	$blocks = array();

	if ( $post->post_content ) :
		$blocks[] = apply_filters( 'the_content', $post->post_content );
	endif;

	if ( $post->post_excerpt ) {
		$blocks[] = apply_filters( 'woocommerce_short_description', $post->post_excerpt );
	}

	if ( empty($blocks) 
		|| "yes" == get_post_meta($post->ID, '_virtual', true) ){

		return;
	}

	echo '<div id="hb-single-product-description">';
		echo '<div class="container">';
			echo '<div class="row">';
			foreach ( $blocks as $key => $block ) :
				$class = !$key || 2 % $key ? 'col-sm-5' : 'col-sm-5 col-sm-offset-2';
				echo '<div class="', $class,'">';
					echo $block;
				echo '</div>';
			endforeach;
			echo '</div>';
		echo '</div>';
	echo '</div><!--#hb-single-product-description-->';
}
add_action('woocommerce_after_single_product_summary', 'hb_single_product_description', 10);


/**
 * undocumented function
 *
 * @return void
 * @author 
 **/
function hb_is_purchasable( $purchasable, $product ){

	return ( $purchasable && $product->is_virtual() && ! hb_get_class_date_status( $product ) ) ? false : $purchasable;
}
add_filter('woocommerce_is_purchasable', 'hb_is_purchasable', 99, 2);


add_filter( 'woocommerce_show_page_title', '__return_false' );
remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );
remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30 );


///
remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5 );
remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );
remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10 );

/**
 * undocumented function
 *
 * @return void
 * @author 
 **/
function hb_template_loop_view_button(){

	echo sprintf('<h3 class="hb-box-title">%s</h3>', __('View', HB_DOMAIN_TXT) );
}
add_action( 'woocommerce_after_shop_loop_item_title', 'hb_template_loop_view_button', 10 );

/**
 * undocumented function
 *
 * @return void
 * @author 
 **/
function hb_template_loop_product_thumbnail(){
	global $post;

	$img_src = wc_placeholder_img_src();

	if ( has_post_thumbnail() ) {
		
		$attachment = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'full');
		$img_src = $attachment[0];
	}

	echo sprintf('<div class="product-image-wrap" style="background-image:url(%1$s)"><img src="%1$s" class="says" alt=""/></div>', esc_url($img_src) );
}
add_action( 'woocommerce_before_shop_loop_item_title', 'hb_template_loop_product_thumbnail', 10 );


/**
 * undocumented function
 *
 * @return void
 * @author 
 **/
function hb_available_variation( $available_variation, $this, $variation ){

	if ( '' != $available_variation['image_src'] ){

		if ( is_numeric( $variation ) ) {
			$variation = $this->get_child( $variation );
		}

		if ( has_post_thumbnail( $variation->get_variation_id() ) ) {
			$attachment_id = get_post_thumbnail_id( $variation->get_variation_id() );
			$attachment    = wp_get_attachment_image_src( $attachment_id, 'full'  );
			$image         = $attachment ? current( $attachment ) : '';
			$image_link    = $attachment ? current( $attachment ) : '';
			$image_title   = get_the_title( $attachment_id );
			$image_alt     = get_post_meta( $attachment_id, '_wp_attachment_image_alt', true );
		} else {
			$image = $image_link = $image_title = $image_alt = '';
		}

			$available_variation['image_src']             = $image;
			$available_variation['image_link']            = $image_link;
			$available_variation['image_title']           = $image_title;
			$available_variation['image_alt']             = $image_alt;
	}

	return $available_variation;
}
add_filter('woocommerce_available_variation', 'hb_available_variation', 99, 3 );


/**
 * undocumented function
 *
 * @return void
 * @author 
 **/
function hb_get_shop_header(){

	wc_get_template_part('shop', 'header');	
}
add_action( 'woocommerce_shop_header', 'hb_get_shop_header', 10 );

/**
 * undocumented function
 *
 * @return void
 * @author 
 **/
function hb_shop_description(){

	global $wp_query;

	$curent_cat_id = 0;
	$terms = get_terms( 'product_cat', array( 'parent' => 23 ));

	if ( ! $terms ){

		return;
	}

	if ( is_shop() ){

		echo sprintf('<div class="term-description hidden-xs"><p>%s</p></div>', __('Select a category', HB_DOMAIN_TXT));

	} elseif ( is_product_category() ){

		$current_cat 	= $wp_query->get_queried_object();
		$curent_cat_id 	= $current_cat->term_id;
	}

	echo '<div id="hb-shop-categories" class="row hidden-xs">';
		foreach ($terms as $cat) {
			$thumb = wp_get_attachment_image_src(get_woocommerce_term_meta( $cat->term_id, 'thumbnail_id', true ), 'full');
			echo sprintf('<a href="%s" %s><span%s></span>%s</a>',
				esc_url( get_term_link( $cat ) ),
				$curent_cat_id == $cat->term_id ? 'class="current-item"' : '',
				$thumb ? ' style="background-image: url('.current($thumb).')"' : '',
				$cat->name
			);
		}
	echo '</div>';
}
add_action( 'woocommerce_archive_description', 'hb_shop_description', 10 );


/* SS custom code.... */
//SS WooCommerce product extensions
/**
 * Adds a box to the main column on the Post and Page edit screens.
 */
function ss_add_meta_box() {

	add_meta_box(
		'ss_sectionid',
		__( 'Email Recipe', 'ss_textdomain' ),
		'ss_meta_box_callback',
		'product'
	);
	
	add_meta_box(
		'ss_attendee_id',
		__( 'Attendee', 'ss_textdomain' ),
		'ss_meta_box_attendee_callback',
		'product'
	);
	
}


add_action( 'add_meta_boxes', 'ss_add_meta_box' );

/**
 * Prints the box content.
 * 
 * @param WP_Post $post The object for the current post/page.
 */
 function ss_getCurrentOrders($post_id=null){
 	
	$args = array();
	$users = get_users( $args );
	$data=array();
	
	global $wpdb;
	global $post;
    
	
	$meta_value = ($post_id) ? $post_id :  $post->ID; 
	//get orders with current product
	$query = "SELECT oim.order_item_id, oi.order_id, oi.order_item_name FROM `wp_woocommerce_order_itemmeta` as `oim`
				join wp_woocommerce_order_items as `oi` on `oim`.`order_item_id` = oi.`order_item_id`
				where oim.meta_value = %d AND oim.meta_key = '_product_id'" ;
	
		$orders = $wpdb->get_results(
			$wpdb->prepare( $query, $meta_value)
		);
	$data = array();

	foreach($orders as $key=>$order){

		//check if order status is acceptable.. if not continue...
		$order_status = get_post_status($order->order_id);
		$rejected_status = array('wc-cancelled','wc-refunded','wc-failed');
		if(in_array($order_status, $rejected_status)) continue; 
		
		$data[] = array(
			  'order_id' 	=> $order->order_id
			, 'item_name' 	=> $order->order_item_name
			, 'email' => get_post_meta( $order->order_id, $key = '_billing_email', true)
			, 'fname' => get_post_meta( $order->order_id, $key = '_billing_first_name', true)
			, 'lname' => get_post_meta( $order->order_id, $key = '_billing_last_name', true) 
		
		);
		
		
		
	}
	
	return $data;
	
 }
 function ss_meta_box_attendee_callback( $post ) {
	
	$orders = ss_getCurrentOrders();
	
	//get reminder details here....
	$prodLog = get_post_meta($post->ID, '_ss_reminderLog', true);
	if(!$prodLog) $prodLog = array(); //if no record found or if NULL/False make it empty array to make life easy...
	else $prodLog = maybe_unserialize($prodLog);


	if(is_array($orders) && !empty($orders)){
	
		echo "<table class='wp-list-table widefat fixed striped pages'>
				<thead>
					<tr>
						<td><strong>#</strong></td>
						<td><strong>Order</strong></td>
						<td><strong>First name</strong></td>
						<td><strong>Last Name</strong></td>
						<td><strong>Email</strong></td>
						<td><strong>Reminder Status</strong></td>
					</tr>
				</thead>
				<tbody>
				";
		
		$i=1;
		foreach($orders as $order){
		
			$email = $order['email']; 
			$reminderStatus = (key_exists($order['order_id'], $prodLog)) ? '<i class="dashicons-before dashicons-yes"></i> Sent' : '<i class="dashicons-before dashicons-no"></i> Not Sent'; 

			echo "<tr>
					<td>$i. </td>
					<td><a target='_blank' href='post.php?post=".$order['order_id']."&action=edit'>Order: ".$order['order_id']."</a> </td>
					<td>".$order['fname']."</td>
					<td> ".$order['lname'] . "</td>
					<td> ".$email."</td>
					<td> ".$reminderStatus." </td>
				</tr>
				";
			$i++;	
		}
		
		echo "</tbody></table>";
		
	}
	else{
		echo "<p>No orders found</p>";
	}
	
	
	
}
function ss_meta_box_callback( $post ) {

	// Add a nonce field so we can check for it later.
	wp_nonce_field( 'ss_save_meta_box_data', 'ss_meta_box_nonce' );

	/*
	 * Use get_post_meta() to retrieve an existing value
	 * from the database and use the value for the form.
	 */
	
	$value = get_post_meta( $post->ID, '_ss_send_recipe', true );
	echo '<p class="form-field"><label for="ss_send_recipe">';
	
	$checked = ($value=="1") ? 'checked="checked"' : '';
	echo '<input type="checkbox" '.$checked. ' id="ss_send_recipe" name="_ss_send_recipe" value = "1" />';
	echo ' Send Recipe Now?</label></p>';
	
	$subj = get_post_meta($_GET['post'], '_ss_recipe_subject' , true );
	$subj = (trim($subj) != "") ? $subj :'{NAME}, Your Recipe';
	
	echo '<p class="form-field"><label>Email Subject <input type="text" name="ss_recipe_subject" value="'.$subj.'"></label></p>';
		
	$valueeee2=  get_post_meta($_GET['post'], '_ss_email_body' , true ) ;
    wp_editor( htmlspecialchars_decode($valueeee2), 'mettaabox_ID_stylee', $settings = array('textarea_name'=>'MyInputNAME') );
	
	$orders = ss_getCurrentOrders();
	if(is_array($orders) && !empty($orders)){
		
		echo "<input type='hidden' name='ss_item_name' value='".$orders[0]['item_name']."'>";
		echo "<h3>Recepients list</h3>";
		echo "<ul>";
		
			$i=1; 
			foreach($orders as $order){
				
				$email = $order['email']; 
				echo "<li>$i. <label><input type='checkbox' checked='checked' value='$email -<>- ".$order['fname'].' '. $order['lname']."' name='recepient[]'><strong>".$order['fname']." ".$order['lname'] . "</strong> (".$email.")</label></li>";
				$i++;
			}
			
		echo "</ul>";
		
	}
	
	$recipe_log = get_post_meta($_GET['post'], '_ss_recipe_log' , true);
	if($recipe_log != ''){
		
		$recipe_log= maybe_unserialize(base64_decode($recipe_log));
		
		if(!empty($recipe_log)){
			
			echo "<h3>Following Recipes are already sent</h3>";
			echo "<table class='wp-list-table widefat fixed striped pages'>
				<thead>
					<tr>
						<td><strong>Date Time</strong></td>
						
						<td><strong>Recepients</strong></td>
					</tr>
				</thead>
				<tbody>
				";
				$i = 1;
				foreach($recipe_log as $row){ 
					
					echo "
							<tr>
								<td>". date('m/d/Y h:i A', $row['timestamp']) ."</td>
								
								
								<td>";
								echo "<table class='wp-list-table '>";
									if($i==1){
										echo "
												<thead>
													<tr>
														<td><strong>Name</strong></td>
														<td><strong>Email</strong></td>
														<td><strong>Date/Time</strong></td>
													</tr>
												</thead>";
									}
									
											foreach($row['recepients'] as $val){
														
												echo "<tbody>
														<tr>
															<td>".$val['name']."</td>
															<td>".$val['email']."</td>
															<td>".date('m/d/y h:i A', $val['timestamp'])."</td>
														</tr>
													</tbody>";		
												
											}
									echo "</table>";
								echo "</td>
							</tr>
						";
					
				$i++; }
			echo "</tbody></table>";
		}
	}
	
	
}

/**
 * When the post is saved, saves our custom data.
 *
 * @param int $post_id The ID of the post being saved.
 */
function ss_save_meta_box_data( $post_id ) {

	/*
	 * We need to verify this came from our screen and with proper authorization,
	 * because the save_post action can be triggered at other times.
	 */

	// Check if our nonce is set.
	if ( ! isset( $_POST['ss_meta_box_nonce'] ) ) {
		return;
	}

	// Verify that the nonce is valid.
	if ( ! wp_verify_nonce( $_POST['ss_meta_box_nonce'], 'ss_save_meta_box_data' ) ) {
		return;
	}

	// If this is an autosave, our form has not been submitted, so we don't want to do anything.
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}

	// Check the user's permissions.
	if ( isset( $_POST['post_type'] ) && 'page' == $_POST['post_type'] ) {

		if ( ! current_user_can( 'edit_page', $post_id ) ) {
			return;
		}

	} else {

		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return;
		}
	}

	/* OK, it's safe for us to process/save the data now. */
	
	if (!empty($_POST['MyInputNAME'])){
	    $datta= stripslashes($_POST['MyInputNAME']); //htmlspecialchars 


		
		//if checkbox true
		if(isset($_POST['_ss_send_recipe']) && ($_POST['_ss_send_recipe'])){
			
			$data=array();
			$data['emailBody'] = $datta;//($_POST['MyInputNAME']); die;
			$data['recepients'] = isset($_POST['recepient']) ? $_POST['recepient'] : array() ;
			$data['event'] = isset($_POST['ss_item_name']) ? $_POST['ss_item_name'] : '';
			$data['subject'] = $_POST['ss_recipe_subject'];
			
			
			//process emails and get log...
			$email_log = ss_send_recipe($data);
			
			if($email_log){
				
				 
				$log =array();
				$current_log = get_post_meta($post_id, '_ss_recipe_log' , true); //current data of log...
				
				if($current_log == ""){
					$log[] = $email_log; //first time sending recipe...
				}
				else{
					
					$current_log = maybe_unserialize(base64_decode($current_log));
					$log=$current_log;
					$log[] = $email_log; 
				}
				
				$serialize = base64_encode(maybe_serialize($log));
				update_post_meta($post_id, '_ss_recipe_log' , $serialize);
				
			}
			
		}
		
		update_post_meta($post_id, '_ss_email_body', $datta );
		update_post_meta($post_id, '_ss_recipe_subject', esc_attr($_POST['ss_recipe_subject']));
		
		
    }
	
}
add_action( 'save_post', 'ss_save_meta_box_data' );

function ss_send_recipe($data){
	$recep_array = array();

	if($data['recepients'] && $data['recepients']!='' && !empty($data['recepients'])){
		
		$email_log = array();
		$email_log['subject']=$data['subject'];
		$email_log['body']= ($data['emailBody']);
		$email_log['recepients'] = array();
		$email_log['timestamp'] = current_time('timestamp');

		//email header....
		$fromEmail = get_field('sender_email', 'option');
		$fromName =  get_field('sender_name', 'option');

		$headers = array();
		$headers[] = 'Content-Type: text/html; charset=UTF-8';

		if(($fromEmail != "") && ($fromName != "")) {
			$headers[] ='From: '.$fromName.' <'.$fromEmail.'>';
		}

		foreach($data['recepients'] as $recepient){
				
			$recep = explode('-<>-', $recepient);

			$mailData=array();
			$mailData['subject']= $data['subject'];
			$mailData['body'] 	= $data['emailBody'];
			$mailData['to']		= trim($recep[0]);
			$mailData['name']	= trim($recep[1]);
			$mailData['event']	= $data['event'];
			$mailData['headers']	= $headers;
			

			$success = _ss_send_mail($mailData);
			if($success){
				
				$email_log['recepients'][] = array(
				
					  'name' => trim($recep[1])
					, 'email'=>trim($recep[0])
					, 'timestamp'=> current_time('timestamp')
				
				);
				
			}
			
		}

		return $email_log; 
	}
	return false;
}

/* **** Plan of action ****
 * 1. Create a function
 * 		fetch all orders which are active...
 * 		calculate timestamp, if it's less than 7 days, 
 * 2. trigger email function for all recepients...
 * 3. create log, record of reminder sent to each recepient, show it on product edit page...
 * 4. Ability to resend reminder to one or more recepients...
 * 5. Send reminder manually too...
 * 
 */
//ss_orders_reminders();
 function ss_orders_reminders(){

	$today	= date('Y-m-d');
	$target = date('Y-m-d', strtotime("+7 day"));
	
	global $wpdb;
	$query = "	SELECT * FROM `wp_postmeta` where meta_key = '_class_date' 
				and meta_value >= %s
				and meta_value <= %s
				" ;
	
		$products = $wpdb->get_results(
			$wpdb->prepare( $query, $today, $target)
		);


	//$products, they qualify for reminders...
	if(!empty($products)){
		
		//set few variables for email so we don't call it under the loop
		$body = get_field('email_message', 'option');
		$subject = get_field('email_subject', 'option');

		$fromEmail = get_field('sender_email', 'option');
		$fromName =  get_field('sender_name', 'option');

		$headers = array();
		$headers[] = 'Content-Type: text/html; charset=UTF-8';

		if(($fromEmail != "") && ($fromName != "")) {
			$headers[] ='From: '.$fromName.' <'.$fromEmail.'>';
		}


		foreach($products as $prod){
			
			//if product == virtual...
			$product_type = get_post_meta($prod->post_id, '_virtual', true);
			if($product_type !== 'yes') {
				continue;
			}

			//$orderRecepients order recepients...
			$orderRecepients = ss_getCurrentOrders($prod->post_id);
			
			//get product previous log....
			$prodLog = get_post_meta($prod->post_id, '_ss_reminderLog', true);
			$productId = $prod->post_id; 

			if(!$prodLog) $prodLog = array(); //if no record found or if NULL/False make it empty array to make life easy...
			else $prodLog = maybe_unserialize($prodLog);

				$log = array();
				foreach($orderRecepients as $recepient){
					
					if(!empty($prodLog) && array_key_exists($recepient['order_id'], $prodLog) ){
						
						//reminder already sent to this order.. ignore it...
						$log[$recepient['order_id']] = $recepient;
						continue; 

					}
					else{

						//name, event, body, subject, to
						$mailData = array();
						$mailData['name'] 	= $recepient['fname'].' '.$recepient['lname'];
						$mailData['event']	=$recepient['item_name'];
						$mailData['subject']= $subject;
						$mailData['body'] 	= $body;
						$mailData['to'] 	= $recepient['email'];
						$mailData['headers']= $headers;

						if(_ss_send_mail($mailData)){
							$log[$recepient['order_id']] = $recepient;
						}
					} 
			}

			//update product reminderLog...
			update_post_meta( $productId, '_ss_reminderLog', maybe_serialize($log));
	
		}
	}
	die;
	
 }

if(isset($_GET['trigger_cronjob']) && $_GET['trigger_cronjob']=='triggermyawsomecronjob'){

	ss_orders_reminders();
	
}

function _ss_send_mail($data){

	/* data should have follwoing variables
		name, event, body, subject, to */

	$subj = str_replace("{NAME}", $data['name'], $data['subject']);
	$subj = str_replace("{EVENT}", $data['event'], $subj);

	
	$body = htmlspecialchars_decode($data['body']);
	$body = str_replace("{NAME}", $data['name'], $body);
	$body = str_replace("{EVENT}", $data['event'], $body);
	
	$headers = $data['headers'];

	$success = false; 

	//$data['to'].'<br>'. $subj.'<br>'.$body.'<br>';
	//print_r($headers);
	
	//if we have 'to' defined... send out the email...
	if(trim($data['to']) != "")	$success = wp_mail( trim($data['to']), $subj, $body, $headers );
	return $success;
}

//acf plugin add options page...
require_once('acf.php');

//change price range to lowest price
function wc_wc20_variation_price_format( $price, $product ) {
    // Main Price
    $prices = array( $product->get_variation_price( 'min', true ), $product->get_variation_price( 'max', true ) );
    $price = $prices[0] !== $prices[1] ? sprintf( __( 'From: %1$s', 'woocommerce' ), wc_price( $prices[0] ) ) : wc_price( $prices[0] );

    // Sale Price
    $prices = array( $product->get_variation_regular_price( 'min', true ), $product->get_variation_regular_price( 'max', true ) );
    sort( $prices );
    $saleprice = $prices[0] !== $prices[1] ? sprintf( __( 'From: %1$s', 'woocommerce' ), wc_price( $prices[0] ) ) : wc_price( $prices[0] );

    if ( $price !== $saleprice ) {
        $price = '<del>' . $saleprice . '</del> <ins>' . $price . '</ins>';
    }
    
    return $price;
}
add_filter( 'woocommerce_variable_sale_price_html', 'wc_wc20_variation_price_format', 10, 2 );
add_filter( 'woocommerce_variable_price_html', 'wc_wc20_variation_price_format', 10, 2 );