<?php

/** 
 *
 * Register shortcodes
 *
*/
global $hb_shortcodes_init;

$hb_shortcodes_init = array(
	'hb_space',
    'hb_row',
    'hb_col',
    'hb_button',
    'hb_team_member',
    'hb_grid',
    'hb_box',
    'hb_ul',
    'hb_li',
);

foreach ( $hb_shortcodes_init as $shortcode ):

    $not_an_external_file = array(
    );

    if ( ! in_array( $shortcode, $not_an_external_file ) )

	   get_template_part ( 'shortcodes/func/' . $shortcode );

endforeach;

 
if( !function_exists('hb_shortcodes_wpautop_fix') ) {

	/*
	 * Remove auto paragraph and line breaks which wpautop added to shortcodes
	 */    
    function hb_shortcodes_wpautop_fix($content){   
	
		global $hb_shortcodes_init;

        $block = join("|", $hb_shortcodes_init);
         
        $rep = preg_replace("/(<p>)?\[($block)(\s[^\]]+)?\](<\/p>|<br \/>)?/","[$2$3]",$content);
        $rep = preg_replace("/(<p>)?\[\/($block)](<\/p>|<br \/>)?/","[/$2]",$rep);
         
        return $rep;
    }
    add_filter('the_content', 'hb_shortcodes_wpautop_fix');    
}


if ( ! function_exists( 'hb_tinymce_init' ) ) {

	/*
	 * Register TinyMCE
	 *
	 */
    function hb_tinymce_init() {
        
        if ( ! current_user_can('edit_posts') 
        	 && ! current_user_can('edit_pages') ) return;
        

        if ( 'true' == get_user_option('rich_editing') ) {
            
            get_template_part('shortcodes/admin/shortcode', 'list');
            get_template_part('shortcodes/admin/shortcode', 'admin');

            add_filter( 'mce_external_plugins', 'hb_tinymce_js_plugin' );
            add_filter( 'mce_buttons', 'register_hb_tinymce_button' );

        }
     
    }
    add_action('init', 'hb_tinymce_init');
}