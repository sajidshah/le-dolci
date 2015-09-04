<?php

if( !function_exists('hb_button_shortcode') ) { 
 
	function hb_button_shortcode($atts, $content = null) {
			
		extract(shortcode_atts(array(
			 
			 'class'	=> '',
			 'href'		=> '#',
			 'target'	=> '_self',
			 'size'		=> 'normal',
			 'type'		=> 'default',
			 'block'	=> '0',
			 'active'	=> '0',
			 'disabled' => '0',
			 'icon'		=> '',

		), $atts));

		$target = trim(strtolower($target));
		$size = trim(strtolower($size));
		$type = trim(strtolower($type));
		$block = trim(strtolower($block));
		$active = trim(strtolower($active));
		$disabled = trim(strtolower($disabled));
		$icon = trim(strtolower($icon));

		$icon = ( $icon ) ? '<i class="'.$icon.'"></i> ' : '';

		$classes = array();

		$activated  = hb_shortcode_active_option_values();

		$default_sizes = array(
			'large'	 		=> 'btn-lg',
			'lg'			=> 'btn-lg',
			'small'  		=> 'btn-sm',
			'sm'			=> 'btn-sm',
			'extrasmall' 	=> 'btn-xs',
			'extra_small' 	=> 'btn-xs',
			'xs'			=> 'btn-xs',
		);

		if ( isset($default_sizes[$size]) )

		$classes[] = $default_sizes[$size];

		if ( $type )

		$classes[] = 'btn-'.$type;

		if ( in_array($block, $activated) )

		$classes[] = 'btn-block';

		if ( in_array($active, $activated) )

		$classes[] = 'active';

		if ( in_array($disabled, $activated) )

		$classes[] = 'disabled';

		if ( $class )

		$classes[] = $class;

		if ( $icon )

		$classes[] = 'have-icon';

		$classes = implode(' ', $classes);

		return '<a class="btn '.esc_attr($classes).'" href="'.esc_attr($href).'" target="'.esc_attr($target).'">'. $icon . $content .'</a>';
	}

	add_shortcode('hb_button', 'hb_button_shortcode');
}