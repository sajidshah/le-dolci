<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

function hb_featured_slide_post_type () {
	$labels = array(
		'name' => _x( 'Slides', 'post type general name', HB_DOMAIN_TXT ),
		'singular_name' => _x( 'Slide', 'post type singular name', HB_DOMAIN_TXT ),
		'add_new' => _x( 'Add New', 'slide', HB_DOMAIN_TXT ),
		'add_new_item' => __( 'Add New Slide', HB_DOMAIN_TXT ),
		'edit_item' => __( 'Edit Slide', HB_DOMAIN_TXT ),
		'new_item' => __( 'New Slide', HB_DOMAIN_TXT ),
		'view_item' => __( 'View Slide', HB_DOMAIN_TXT ),
		'search_items' => __( 'Search Slide', HB_DOMAIN_TXT ),
		'not_found' =>  __( 'No slide found', HB_DOMAIN_TXT ),
		'not_found_in_trash' => __( 'No slide found in Trash', HB_DOMAIN_TXT ), 
		'parent_item_colon' => __( 'Parent slide:', HB_DOMAIN_TXT )
	);
	$args = array(
		'labels' => $labels,
		'public' => true,
		'publicly_queryable' => false,
		'show_in_nav_menus' => true,
		'show_ui' => true, 
		'query_var' => true,
		'rewrite' => true,
		'capability_type' => 'post',
		'hierarchical' => false,
		//'taxonomies' => array( 'slide-group' ), 
		'menu_position' => 5,
		'menu_icon' => 'dashicons-images-alt',
		'supports' => array('title','thumbnail','author','editor')
	);

	register_post_type( 'slide', $args );

	// "Slide Pages" Custom Taxonomy
	// $labels = array(
	// 	'name' => _x( 'Slide Groups', 'taxonomy general name', HB_DOMAIN_TXT ),
	// 	'singular_name' => _x( 'Slide Groups', 'taxonomy singular name', HB_DOMAIN_TXT ),
	// 	'search_items' =>  __( 'Search Slide Groups', HB_DOMAIN_TXT ),
	// 	'all_items' => __( 'All Slide Groups', HB_DOMAIN_TXT ),
	// 	'parent_item' => __( 'Parent Slide Group', HB_DOMAIN_TXT ),
	// 	'parent_item_colon' => __( 'Parent Slide Group:', HB_DOMAIN_TXT ),
	// 	'edit_item' => __( 'Edit Slide Group', HB_DOMAIN_TXT ), 
	// 	'update_item' => __( 'Update Slide Group', HB_DOMAIN_TXT ),
	// 	'add_new_item' => __( 'Add New Slide Group', HB_DOMAIN_TXT ),
	// 	'new_item_name' => __( 'New Slide Group Name', HB_DOMAIN_TXT ),
	// 	'menu_name' => __( 'Slide Groups', HB_DOMAIN_TXT )
	// ); 	

	// $args = array(
	// 	'hierarchical' => true,
	// 	'labels' => $labels,
	// 	'show_ui' => true,
	// 	'query_var' => true,
	// 	'rewrite' => array( 'slug' => 'slide-group' )
	// );

	//register_taxonomy( 'slide-group', array( 'slide' ), $args );
} // End hb_featured_slide_post_type()

add_action( 'init', 'hb_featured_slide_post_type' );

/*-----------------------------/
	EDIT LIST CUSTOM COLUMNS
/-----------------------------*/
add_filter("manage_edit-slide_columns", "slide_edit_columns");

add_action("manage_posts_custom_column",  "slide_columns_display", 10, 2);

add_theme_support( 'post-thumbnails', array( 'slide' ) );

function slide_edit_columns($slide_columns){
    $slide_columns = array(
        "cb" => "<input type=\"checkbox\" />",
        "title" => _x('Slide', 'column name', HB_DOMAIN_TXT),
        "slide_thumbnail" => __('Image', HB_DOMAIN_TXT),
        //"group" => __('Group', HB_DOMAIN_TXT),
        "date" => __('Date', HB_DOMAIN_TXT)
    );
    return $slide_columns;
}

function slide_columns_display($slide_columns, $post_id){
    switch ($slide_columns)
    {
        case "slide_thumbnail":
            $thumb_id = get_post_thumbnail_id( $post_id );
                
            if ($thumb_id != ''){
                $thumb = wp_get_attachment_image( $thumb_id, array( 100, 100 ), true );
                echo $thumb;
            } else {
                echo __('None', HB_DOMAIN_TXT);
            }
            
        break;

		case 'group':
				    
		    $terms = get_the_terms( $post_id, 'slide-group', '', ', ', '' );
		    
			if ( $terms && ! is_wp_error( $terms ) ) : 

				$groups_list = array();

				foreach ( $terms as $term ) {
					$groups_list[] = "{$term->name} (Group ID: {$term->term_id})";
				}
									
				$groups = join( ", ", $groups_list );

				echo $groups;

			else :

				_e( '&#8212;', MANA );

			endif;
		break;
    }
}
