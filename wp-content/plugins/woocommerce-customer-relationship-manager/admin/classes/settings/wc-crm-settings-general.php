<?php
/**
 * WooCommerce General Settings
 *
 * @author 		WooThemes
 * @category 	Admin
 * @package 	WooCommerce/Admin
 * @version     2.1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( ! class_exists( 'WC_Crm_Settings_General' ) ) :

/**
 * WC_Crm_Settings_General
 */
class WC_Crm_Settings_General extends WC_Settings_Page {

	/**
	 * Constructor.
	 */
	public function __construct() {
		$this->id    = 'general_crm';
		$this->label = __( 'General', 'woocommerce' );

		add_filter( 'wc_crm_settings_tabs_array', array( $this, 'add_settings_page' ), 20 );
		add_action( 'wc_crm_settings_' . $this->id, array( $this, 'output' ) );
		add_action( 'wc_crm_settings_save_' . $this->id, array( $this, 'save' ) );

	}

	/**
	 * Get settings array
	 *
	 * @return array
	 */
	public function get_settings() {
		global $woocommerce, $wp_roles;
		$statuses = wc_crm_get_statuses_slug();
		$settings = array();
		$filters = array(
					'name' => __( 'Filters', 'wc_customer_relationship_manager' ),
					'desc' => 'Choose which filters you would like to display on the Customers page.',
					'id' => 'woocommerce_crm_filters',
					'class'   => 'chosen_select',
					'type' => 'multiselect',
					'options' => array(
							'user_roles' => __( 'User Roles', 'wc_customer_relationship_manager' ),
							'last_order' => __( 'Last Order', 'wc_customer_relationship_manager' ),
							'state' => __( 'State', 'wc_customer_relationship_manager' ),
							'city' => __( 'City', 'wc_customer_relationship_manager' ),
							'country' => __( 'Country', 'wc_customer_relationship_manager' ),
							'customer_name' => __( 'Customer Name', 'wc_customer_relationship_manager' ),
							'products' => __( 'Products', 'wc_customer_relationship_manager' ),
							'products_variations' => __( 'Products Variations', 'wc_customer_relationship_manager' ),
              'order_status' => __( 'Order Status', 'wc_customer_relationship_manager' ),
							'customer_status' => __( 'Customer Status', 'wc_customer_relationship_manager' ),
							'products_categories' => __( 'Product Categories', 'wc_customer_relationship_manager' ),
						),
					'defa'
				);

		if( class_exists( 'WC_Brands_Admin' ) ) {
			$filters['options']['products_brands'] = __( 'Product Brands', 'wc_customer_relationship_manager' );
		}
		
		$settings[] = array( 'title' => __( 'General Options', 'woocommerce' ), 'type' => 'title', 'desc' => '', 'id' => 'general_crm_options' );
		$settings[] = array(
					'name'    => __( 'Username', 'wc_customer_relationship_manager' ),
					'desc'    => __( 'Choose what the username is when customers are added.', 'wc_customer_relationship_manager' ),
					'id'      => 'woocommerce_crm_username_add_customer',
					'type'    => 'select',
					'options' => array(
						1 => __('First & last name e.g. johnsmith', 'wc_customer_relationship_manager'),
						2 => __('Hyphen separated e.g. john-smith', 'wc_customer_relationship_manager'),
						3 => __('Email address', 'wc_customer_relationship_manager')
						),
					'autoload' => true
				);
		$settings[] = $filters;
		$settings[] = array(
					'name'    => __( 'Value', 'wc_customer_relationship_manager' ),
					'desc'    => __( 'Choose which statuses the customer orders must be before appearing in the Value column.', 'wc_customer_relationship_manager' ),
					'id'      => 'woocommerce_crm_total_value',
					'class'   => 'chosen_select',
					'type'    => 'multiselect',
					'options' => wc_get_order_statuses(),
				);
		$settings[] = array(
				'title'         => __( 'Automatic Emails', 'wc_customer_relationship_manager' ),
				'desc'          => __( 'Check this box to send an email with username and password when creating a new customer.', 'wc_customer_relationship_manager' ),
				'id'            => 'woocommerce_crm_automatic_emails_new_customer',
				'default'       => 'yes',
				'type'          => 'checkbox',
				'checkboxgroup' => 'start'
			);

		if( class_exists( 'WC_Subscriptions' ) ) {
			$settings[] = array(
				'title'         => __( 'Subscribers', 'wc_customer_relationship_manager' ),
				'desc'          => __( 'Check this box to show column indicating whether customer is an active subscriber.', 'wc_customer_relationship_manager' ),
				'id'            => 'wc_crm_show_subscribers_column',
				'default'       => 'no',
				'type'          => 'checkbox',
				'checkboxgroup' => 'start'
			);
		}
		if( class_exists( 'Groups_WordPress' ) && class_exists( 'Groups_WS' ) ) {
			$settings[] = array(
				'title'         => __( 'Members\' Group', 'wc_customer_relationship_manager' ),
				'desc'          => __( 'Check this box to show column indicating which group is the customer a member of.', 'wc_customer_relationship_manager' ),
				'id'            => 'wc_crm_show_groups_wc_column',
				'default'       => 'no',
				'type'          => 'checkbox',
				'checkboxgroup' => 'start'
			);
		}

		$settings[] = array( 'type' => 'sectionend', 'id' => 'general_crm_options');
		$settings[] = array( 'title' => __( 'Fetch Customers', 'wc_customer_relationship_manager' ), 'type' => 'title', 'desc' => __( 'The following options affects how the customers in the customers table should be fetched.', 'wc_customer_relationship_manager' ), 'id' => 'crm_fetch_customers' );
		$settings[] = array(
					'name'    => __( 'User Roles', 'wc_customer_relationship_manager' ),
					'desc'    => 'Choose which User Roles of the customers/users that will be shown in the customers table.',
					'id'      => 'woocommerce_crm_user_roles',
					'type'    => 'multiselect',
					'class'   => 'chosen_select',
					'options' => $wp_roles->role_names,
				);
		$settings[] = array(
				'title'         => __( 'Guest Customers', 'woocommerce' ),
				'desc'          => 'Select whether Guest customers appear on the customers table.',
				'id'            => 'woocommerce_crm_guest_customers',
				'default'       => 'yes',
				'type'          => 'checkbox',
				'checkboxgroup' => 'start'
			);
		$settings[] = array(
					'name'    => __( 'Unique Identifier', 'wc_customer_relationship_manager' ),
					'desc'    => 'Choose which information carries the unique key identifier for each customer.',
					'id'      => 'woocommerce_crm_unique_identifier',
					'type'    => 'select',
					'class'   => '',
					'default' => 'username_email',
					'options' => array(
						'username_email' => __('Username', 'wc_customer_relationship_manager'),
						'billing_email'  => __('Billing Email Address', 'wc_customer_relationship_manager'),
						),
				);
		$settings[] = array(
					'name'    => __( 'Customer Name Format', 'wc_customer_relationship_manager' ),
					'desc'    => __( 'Choose the format of the names displayed on the Customers page.', 'wc_customer_relationship_manager' ),
					'id'      => 'woocommerce_crm_customer_name',
					'type'    => 'select',
					'class'   => '',
					'default' => 'fl',
					'options' => array(
						'fl' => __('First Last', 'wc_customer_relationship_manager'),
						'lf' => __('Last, First', 'wc_customer_relationship_manager'),
						),
				);
		$settings[] = array( 'type' => 'sectionend', 'id' => 'crm_fetch_customers');
		$settings[] = array( 'title' => __( 'Default Status', 'wc_customer_relationship_manager' ), 'type' => 'title', 'desc' => __( 'The following options determine the default status for the customers when added to this site.', 'wc_customer_relationship_manager' ), 'id' => 'crm_default_customer_status' );
		$settings[] = array(
					'name'    => __( 'Manually Added', 'wc_customer_relationship_manager' ),
					'desc'    => __( 'Added manually via this plugin.', 'wc_customer_relationship_manager' ),
					'id'      => 'wc_crm_default_status_crm',
					'type'    => 'select',
					'class'   => '',
					'default' => 'Customer',
					'options' => $statuses,
				);
		$settings[] = array(
					'name'    => __( 'Purchased Customers', 'wc_customer_relationship_manager' ),
					'desc'    => __( 'Added automatically via purchases made.', 'wc_customer_relationship_manager' ),
					'id'      => 'wc_crm_default_status_store',
					'type'    => 'select',
					'class'   => '',
					'default' => 'Customer',
					'options' => $statuses,
				);

		$settings[] = array(
					'name'    => __( 'Registration Page', 'wc_customer_relationship_manager' ),
					'desc'    => __( 'Added via the account registration page.', 'wc_customer_relationship_manager' ),
					'id'      => 'wc_crm_default_status_account',
					'type'    => 'select',
					'class'   => '',
					'default' => 'Customer',
					'options' => $statuses,
				);
		$settings[] = array( 'type' => 'sectionend', 'id' => 'crm_default_customer_status');

		return apply_filters( 'woocommerce_customer_relationship_general_settings_fields', $settings);

	}

	/**
	 * Save settings
	 */
	public function save() {
		$settings = $this->get_settings();

		WC_Crm_Settings::save_fields( $settings );
	}

}

endif;

return new WC_Crm_Settings_General();
