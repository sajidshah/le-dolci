<?php

if( !function_exists('hb_grid_shortcode') ) { 
 
	function hb_grid_shortcode($atts, $content = null) {
				
		extract(shortcode_atts(array(
			 
			 'class'	=> '',
			 'gutter'	=> '',

			 
		), $atts));

		// Box Classes
		$classes= array(
			'hb-grid',
			'hb-animate-group',
			'clearfix',
		);

		$activated  = hb_shortcode_active_option_values();

		if ( in_array($gutter, $activated) )
		 $classes[] = 'hb-grid-gutter';

		if ( $class )
			$classes[] = $class;

		return '<div class="'. esc_attr( implode(' ', $classes) ) .'">'. do_shortcode($content) .'</div>';
	}

	add_shortcode('hb_grid', 'hb_grid_shortcode');
}