<?php

if( !function_exists('hb_row_shortcode') ) { 
 
	function hb_row_shortcode($atts, $content = null) {
				
		extract(shortcode_atts(array(
			 
			 'class'	=> ''	
			 
		), $atts));

		return '<div class="row hb-animate-group '.esc_attr($class).'">'.do_shortcode($content).'</div>';
	}

	add_shortcode('hb_row', 'hb_row_shortcode');
}