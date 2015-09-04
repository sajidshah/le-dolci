<?php

if( !function_exists('hb_col_shortcode') ) { 
 
	function hb_col_shortcode($atts, $content = null) {
				
		extract(shortcode_atts(array(
			 
			 'class'		=> '',
			 'column'		=> '6',
			 'offset'		=> '',
			 'hidemobile'	=> '',
			 'hidetablet' 	=> '',
			 'animation'	=> '',
			 
		), $atts));

		$classes = array();

		$activated  = hb_shortcode_active_option_values();

		$classes[] = 'col-sm-'.$column;

		if ( in_array($hidemobile, $activated) )

			$classes[] = 'hidden-xs';

		if ( in_array($hidetablet, $activated) )

			$classes[] = 'hidden-sm';

		if ( $offset )

			$classes[] = 'col-sm-offset-'.$offset;

		if ( $animation && $animation != 'none' ){

			$classes[] = 'hb-animate';

			$animation = ' data-animation="'. esc_attr($animation) .'"';
		}

		if ( $class )

			$classes[] = $class;

		$classes = implode(' ', $classes);

		return '<div class="'.esc_attr($classes).'"'.$animation.'>'.do_shortcode($content).'</div>';
	}

	add_shortcode('hb_col', 'hb_col_shortcode');
}