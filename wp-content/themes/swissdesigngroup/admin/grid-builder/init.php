<?php
/**
 *
 *
 *
 *
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

@define( 'HB_GRID_BUILDER_VERSION', '0.1' );

/**
 * undocumented function
 *
 * @return void
 * @author 
 **/
function grid_builder_admin_scripts_init(){

    wp_enqueue_style (  'wp-jquery-ui-dialog' );
	wp_enqueue_style( 'admin-grid-builder', get_template_directory_uri() . '/admin/grid-builder/css/grid-builder.css', array(), '0.1' );
	wp_enqueue_script( 'admin-grid-builder', get_template_directory_uri() . '/admin/grid-builder/js/grid-builder.js', array( 'jquery', 'jquery-ui-dialog' ), '0.1', true );
}
add_action( 'admin_enqueue_scripts', 'grid_builder_admin_scripts_init' );

/**
 * Grid builder option type.
 *
 * See @ot_display_by_type to see the full list of available arguments.
 *
 * @param     array     An array of arguments.
 * @return    string
 *
 * @access    public
 * @since     2.0
 */
if ( ! function_exists( 'ot_type_grid_builder' ) ) {
  
    function ot_type_grid_builder( $args = array() ) {

    	/* turns arguments array into variables */
    	extract( $args );

	    /* verify a description */
	    $has_desc = $field_desc ? true : false;
	    
	    /* format setting outer wrapper */
	    echo '<div class="format-setting type-grid-builder ' . ( $has_desc ? 'has-desc' : 'no-desc' ) . '">';
	      
	      /* description */
	      echo $has_desc ? '<div class="description">' . htmlspecialchars_decode( $field_desc ) . '</div>' : '';
	      
	      /* format setting inner wrapper */
	      echo '<div class="format-setting-inner">';
	        
	        echo '<div class="grid-handles">';
	        	echo '<a href="javascript:void(0);" class="option-tree-ui-button button gb-add-new">', __('Add New Box', HB_DOMAIN_TXT),'</a>';
	        echo '</div>';
	      	echo '<div class="grid-builder">';
	      		if ( !empty($field_value) ){

	      			$draggable_boxes = json_decode($field_value, true);

	      			if ( is_array($draggable_boxes) && !empty($draggable_boxes) ){

	      				foreach ($draggable_boxes as $box) {
	      					
	      					echo '
	      					<div class="grid-item" data-width="', esc_attr($box['width']),'" data-height="', esc_attr($box['height']),'">
								<div class="grid-btns">
									<a class="grid-edit" href="javascript:void(0);"><i class="dashicons dashicons-edit"></i></a>
									<a class="grid-duplicate" href="javascript:void(0);"><i class="dashicons dashicons-admin-page"></i></a>
									<a class="grid-remove" href="javascript:void(0);"><i class="dashicons dashicons-trash"></i></a>
								</div>
								<strong class="grid-title">', $box['title'],'</strong>
								<input type="hidden" class="grid-data" value="', esc_attr(json_encode($box)),'">
							</div>';
	      				}
	      			}
	      		}
	      	echo '</div>';

	      	echo '<input type="hidden" name="' . esc_attr( $field_name ) . '" id="' . esc_attr( $field_id ) . '" value="' . esc_attr( $field_value ) . '" class="grid-items-data"/>';
	      
	      echo '</div>';
	    
	    echo '</div>';
    }
}



if ( ! function_exists( 'grid_builder_add_modals_content' ) ){

	function grid_builder_add_modals_content(){

		get_template_part('admin/grid-builder/modals/modal', 'settings');
		get_template_part('admin/grid-builder/modals/modal', 'remove');
	}
}
add_action( 'admin_footer', 'grid_builder_add_modals_content', 99 );
