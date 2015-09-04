<?php
if( ! defined('WP_UNINSTALL_PLUGIN') )
	exit;

global $wpdb;

$wpdb->query( "DROP TABLE IF EXISTS " . $wpdb->prefix . "wc_crm_log" );
$wpdb->query( "DROP TABLE IF EXISTS " . $wpdb->prefix . "wc_crm_groups" );
$wpdb->query( "DROP TABLE IF EXISTS " . $wpdb->prefix . "wc_crm_groups_relationships" );
$wpdb->query( "DROP TABLE IF EXISTS " . $wpdb->prefix . "wc_crm_customers" );
$wpdb->query( "DROP TABLE IF EXISTS " . $wpdb->prefix . "wc_crm_statuses" );

$wpdb->query("DELETE FROM $wpdb->options WHERE option_name LIKE 'wc_crm_%';");
