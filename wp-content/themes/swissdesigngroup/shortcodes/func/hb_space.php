<?php

if( !function_exists('hb_space_shortcode') ) { 
 
	function hb_space_shortcode($atts, $content = null) {
				
		extract(shortcode_atts(array(
			 
			 'height'	=> '',
			 
		), $atts));

		$output  = '<div class="clearfix">';
			$output .= ( $height )? '<div class="hb-space" style="height:'.esc_attr($height).'"/></div>' : '<div class="hb-space"></div>';
		$output .= '</div>';

		return $output;
	}

	add_shortcode('hb_space', 'hb_space_shortcode');
}