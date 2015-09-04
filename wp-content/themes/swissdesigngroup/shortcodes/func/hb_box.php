<?php

if( !function_exists('hb_box_shortcode') ) { 
 
	function hb_box_shortcode($atts, $content = null) {
				
		extract(shortcode_atts(array(
			 
			 'class'		=> '',
			 'width' 		=> '10',
			 'height' 		=> '10',
			 'txt_color' 	=> '',
			 'bg_color' 	=> '',
			 'bg_img' 		=> '',
			 'bg_img_size' 	=> '',

		), $atts));

		// Box Classes
		$classes= array(
			'hb-box-wrapp',
			'hb-animate'
		);

		$classes[] = 'hb-box-w-' . $width;

		$classes[] = 'hb-box-h-' . $height; 

		if ( $class )
			$classes[] = $class;

		// Box Styles
		$styles = array();

		if ( $txt_color )
			$styles[] = 'color:' . $txt_color;

		if ( $bg_color )
			$styles[] = 'background-color:' . $bg_color;

		if ( $bg_img )
			$styles[] = 'background-image:url(' . esc_url($bg_img) . ')';

		if ( $bg_img_size )
			$styles[] = 'background-size:' . $bg_img_size;

		$styles  = ! empty($styles) ? ' style="'. esc_attr( implode(';', $styles) ) .'"' : '';

		$output  = '<div class="'. esc_attr( implode(' ', $classes) ) .'">';
			$output .= '<div class="hb-box"'. $styles .'>';
				$output .= do_shortcode($content);
			$output .= '</div>';
		$output .= '</div>';

		return $output;
	}

	add_shortcode('hb_box', 'hb_box_shortcode');
}