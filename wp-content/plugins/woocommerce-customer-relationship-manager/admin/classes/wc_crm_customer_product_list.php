<?php
/**
 * Table with list of customers.
 *
 * @author   Actuality Extensions
 * @package  WooCommerce_Customer_Relationship_Manager
 * @since    1.0
 */

if ( !defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( !class_exists( 'WP_List_Table' ) ) {
  require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
}

class WC_Crm_Customer_Product_List extends WP_List_Table {

  protected $data;
  protected $user_data;
  protected $found_data;

  function __construct($user_data) {
    global $status, $page;

    parent::__construct( array(
      'singular' => __( 'product', 'wc_customer_relationship_manager' ), //singular name of the listed records
      'plural' => __( 'products', 'wc_customer_relationship_manager' ), //plural name of the listed records
      'ajax' => false //does this table support ajax?
    ) );
    $this->user_data = $user_data;
  }


  function no_items() {
    _e( 'No products data found.', 'wc_customer_relationship_manager' );
  }

  function column_default( $item, $column_name ) {
    switch ( $column_name ) {
      case 'thumb':
      case 'name':
      case 'sku':
      case 'number_purchased':
      case 'value_purchases':
        return $item[$column_name];
      default:
        return print_r( $item, true ); //Show the whole array for troubleshooting purposes
    }
  }

  function get_sortable_columns() {
    return array();
  }

  function get_columns() {
    $columns = array(
      'thumb' => '<span class="wc-image tips">'.__( 'Image', 'wc_customer_relationship_manager' ).'</span>',
      'name' => __( 'Name', 'wc_customer_relationship_manager' ),
      'sku' => __( 'SKU', 'wc_customer_relationship_manager' ),
      'number_purchased' => __( 'Number Purchased', 'wc_customer_relationship_manager' ),
      'value_purchases' =>  __( 'Value of Purchases', 'wc_customer_relationship_manager' ),
    );
    return $columns;
  }

  function usort_reorder( $a, $b ) {
    // If no sort, default to last purchase
    $orderby = ( !empty( $_GET['orderby'] ) ) ? $_GET['orderby'] : 'name';
    // If no order, default to desc
    $order = ( !empty( $_GET['order'] ) ) ? $_GET['order'] : 'desc';
    
    $result = strcmp( $a[$orderby], $b[$orderby] );

    // Send final sort direction to usort
    return ( $order === 'asc' ) ? $result : -$result;
  }

  public function prepare_items() {

    $this->data = $this->get_wooc_product_data();

    $columns = $this->get_columns();
    $hidden = array();
    $sortable = $this->get_sortable_columns();
    $this->_column_headers = array($columns, $hidden, $sortable);
    usort( $this->data, array(&$this, 'usort_reorder') );

    $this->items = $this->data;
  }
  public function get_wooc_product_data(){
    global $post, $the_product;
    $user_data = $this->user_data;
    $user_email = $user_data->email;
    $user_ID    = $user_data->user_id;
    $orders_data = array();
    $order_products = array();
    
    include_once( dirname(WC_PLUGIN_FILE).'/includes/admin/class-wc-admin-post-types.php' );
      $CPT_Product = new WC_Admin_Post_Types();

       $args = array(
        'numberposts' => -1,
        'post_type' => 'product',
        'post_status' => 'publish'
      );
      #$products = get_posts( $args );
      $products = wcrm_customer_bought_products($user_email, $user_ID);
      
      
      foreach ( $products as $prod ) {
        $post = get_post($prod->ID);
        $the_product = wc_get_product( $prod->ID );
        if( !wc_customer_bought_product( $user_email, $user_ID, $prod->ID ) ){
         # continue;
        }

          $o['ID'] = $prod->ID;
          ob_start();
            $CPT_Product->render_product_columns( 'thumb' );
          $o['thumb']  = ob_get_contents();
          ob_end_clean();
          ob_start();
            $edit_link = get_edit_post_link( $prod->ID );
            $title = _draft_or_post_title();
            echo '<strong><a class="row-title" href="'.$edit_link.'">' . $title.'</a>';
          $o['name']  = ob_get_contents();
          ob_end_clean();
          ob_start();
            $CPT_Product->render_product_columns( 'sku' );
          $o['sku']  = ob_get_contents();
          ob_end_clean();
          
          
          $o['number_purchased'] = $prod->items_count;
          $o['value_purchases']  = wc_price($prod->line_total);
        $orders_data[] = $o;

      }

  return $orders_data;
  }
  
   function product_filters_query($args) {

      if ( isset( $_REQUEST['product_cat'] ) && !empty($_REQUEST['product_cat'])) {
        $args['tax_query'][] = array(
          'taxonomy' => 'product_cat',
          'terms' => $_REQUEST['product_cat'],
          'field' => 'slug',
        );
      }
      if ( isset( $_REQUEST['product_type'] ) && !empty($_REQUEST['product_type'])) {
        if ( $_REQUEST['product_type'] == 'downloadable' ) {
              $args['meta_key']    = '_downloadable';
              $args['meta_value']  = 'yes';
          } elseif ( $_REQUEST['product_type'] == 'virtual' ) {
              $args['meta_key']    = '_virtual';
              $args['meta_value']  = 'yes';
            }
      }
      return $args;
    }

}