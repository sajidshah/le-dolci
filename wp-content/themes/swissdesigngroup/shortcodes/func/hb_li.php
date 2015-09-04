<?php

if( !function_exists('hb_li_shortcode') ) { 
 
	function hb_li_shortcode($atts, $content = null) {
				
		extract(shortcode_atts(array(
			 
			 'class' => '',
			 'icon'	 => '',
			 'color' => '',

		), $atts));

		$classes = array();

		$color = hb_sanitize_hex_color( $color );

		$color = $color ? sprintf(' style="color:%s;"', esc_attr($color)) : '';

		if ( '' !== $icon ){

			$classes[] 	= 'have-icon';
			$content 	= sprintf('<i class="icon-li %s"></i>%s', esc_attr($icon), $content);
		}

		if ( '' !== $class ){

			$classes[] 	= $class;
		}

		$classes = !empty($classes) ? sprintf(' class="'.esc_attr(implode(' ', $classes)).'"') : '';

		return '<li'.$classes.$color.'>'.do_shortcode($content).'</li>';
	}

	add_shortcode('hb_li', 'hb_li_shortcode');
}