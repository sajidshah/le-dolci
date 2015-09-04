<?php

if( !function_exists('hb_ul_shortcode') ) { 
 
	function hb_ul_shortcode($atts, $content = null) {
				
		extract(shortcode_atts(array(
			 
			 'class'	=> ''	
			 
		), $atts));

		return '<ul class="icon-ul '.esc_attr($class).'">'.do_shortcode($content).'</ul>';
	}

	add_shortcode('hb_ul', 'hb_ul_shortcode');
}