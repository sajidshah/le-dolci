<?php
/**
 * Team Member
 *
 */
if (!function_exists('fm_member_shortcode')) {
    function fm_member_shortcode($atts) {
        
        extract ( shortcode_atts( array(
              'img'     => '',
              'name'    => '',
              'title'   => '',             
              'color'   => '',
              'class'   => '',
        ), $atts ) );

        $output = '<div class="team-item hb-animate ' . esc_attr($class) . '" data-animation="fadeIn">';
          $output .= '<div class="team-member clearfix">';
            if ( $img ) {
              $output .= '<div class="memeber-avatar"><img src="' . esc_url($img) . '" alt="' . esc_attr($name) . '" /></div>';
            }
            $output .= '<div class="memeber-name">';
            if ( $name ) {
              $output .= '<h3>' . $name . '</h3>';
            }
            if ( $title ) {
              $color = hb_sanitize_hex_color($color);
              $color = $color ? 'style="color:'.$color.';"' : '';
              $output .= '<span '.$color.'>' . $title . '</span>';
            }
            $output .= '</div>';
          $output .= '</div>';
        $output .= '</div>';
        return $output;
    }
    add_shortcode('hb_team_member', 'fm_member_shortcode');
}