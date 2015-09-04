<?php
/**
 * Initialize the custom Theme Options.
 */
add_action( 'admin_init', 'custom_theme_options' );

/**
 * Build the custom settings & update OptionTree.
 *
 * @return    void
 * @since     2.0
 */
function custom_theme_options() {
  
  /**
   * Get a copy of the saved settings array. 
   */
  $saved_settings = get_option( ot_settings_id(), array() );
  
  /**
   * Custom settings array that will eventually be 
   * passes to the OptionTree Settings API Class.
   */
  $custom_settings = array( 
    'contextual_help' => array( 
      'content'       => array( 
        array(
          'id'        => 'home_page_help',
          'title'     => __( 'Option Types', HB_DOMAIN_TXT ),
          'content'   => '<p>' . __( 'Help content goes here!', HB_DOMAIN_TXT ) . '</p>'
        )
      ),
      'sidebar'       => '<p>' . __( 'Sidebar content goes here!', HB_DOMAIN_TXT ) . '</p>'
    ),
    'sections'        => array( 

      array(
        'id'          => 'logo_section',
        'title'       => '<i class="dashicons-before dashicons-awards"></i>&nbsp; &nbsp; ' . __( 'Site Logo', HB_DOMAIN_TXT )
      ),

      array(
        'id'          => 'typo_section',
        'title'       => '<i class="dashicons-before dashicons-editor-spellcheck"></i>&nbsp; &nbsp; ' . __( 'Typography', HB_DOMAIN_TXT )
      ),

      array(
        'id'          => 'shop_section',
        'title'       => '<i class="dashicons-before dashicons-store"></i>&nbsp; &nbsp; ' . __( 'Shop', HB_DOMAIN_TXT )
      ),

      array(
        'id'          => 'socials',
        'title'       => '<i class="dashicons-before dashicons-universal-access-alt"></i>&nbsp; &nbsp; ' . __( 'Socials', HB_DOMAIN_TXT )
      ),

      array(
        'id'          => 'mobile',
        'title'       => '<i class="dashicons-before dashicons-smartphone"></i>&nbsp; &nbsp; ' . __( 'Mobile & Tablet', HB_DOMAIN_TXT )
      ),

      array(
        'id'          => 'footer',
        'title'       => '<i class="dashicons-before dashicons-carrot"></i>&nbsp; &nbsp; ' . __( 'Footer', HB_DOMAIN_TXT )
      ),

    ),
    'settings'        => array(

      // Site Logo

      array(
        'id'          => 'logo',
        'label'       => __( 'Logo', HB_DOMAIN_TXT ),
        'type'        => 'upload',
        'section'     => 'logo_section',
      ),

      array(
        'id'          => 'alt_logo',
        'label'       => __( 'Alternative Logo', HB_DOMAIN_TXT ),
        'type'        => 'upload',
        'section'     => 'logo_section',
      ),

      // Typography
      array(
        'id'          => 'site_fonts_type',
        'label'       => __( 'Fonts Type', HB_DOMAIN_TXT ),
        'type'        => 'select',
        'section'     => 'typo_section',
        'choices'     => array( 
          array(
            'value'       => 'google-fonts',
            'label'       => __( 'Google Fonts', HB_DOMAIN_TXT ),
            'src'         => ''
          ),
          array(
            'value'       => 'typekit',
            'label'       => __( 'Typekit', HB_DOMAIN_TXT ),
            'src'         => ''
          ),
          array(
            'value'       => 'default',
            'label'       => __( 'Default', HB_DOMAIN_TXT ),
            'src'         => ''
          ),
        )
      ),

      array(
        'id'          => 'typekit',
        'label'       => __( 'Embed Code', HB_DOMAIN_TXT ),
        'type'        => 'textarea-simple',
        'section'     => 'typo_section',
        'condition'   => 'site_fonts_type:is(typekit)',
        'operator'    => 'and'
      ),      

      array(
        'id'          => 'body_typo',
        'label'       => __( 'Body', HB_DOMAIN_TXT ),
        'type'        => 'googlefont',
        'section'     => 'typo_section',
        'condition'   => 'site_fonts_type:is(google-fonts)',
        'operator'    => 'and'
      ),

      array(
        'id'          => 'headlines_typo',
        'label'       => __( 'Headlines', HB_DOMAIN_TXT ),
        'type'        => 'googlefont',
        'section'     => 'typo_section',
        'condition'   => 'site_fonts_type:is(google-fonts)',
        'operator'    => 'and'
      ),

      // Global
      array(
        'id'          => 'class_per_page',
        'label'       => __( 'Display class per page', HB_DOMAIN_TXT ),
        'type'        => 'numeric-slider',
        'section'     => 'shop_section',
        'std'         => '12',
        'min_max_step'=> '3,99,3',
      ),

      array(
        'id'          => 'start_displaying_stock_qty',
        'label'       => __( 'Display class QTY when stock # is', HB_DOMAIN_TXT ),
        'type'        => 'numeric-slider',
        'section'     => 'shop_section',
        'std'         => '10',
        'min_max_step'=> '1,500,1',
      ),

      array(
        'id'          => 'brand_new_copy',
        'label'       => __( 'Class&apos;s Brand New Copy', HB_DOMAIN_TXT ),
        'type'        => 'text',
        'section'     => 'shop_section',
        'std'         => __('Brand New', HB_DOMAIN_TXT),
      ),

      // Socials
      array(
        'id'          => 'site_socials',
        'label'       => __( '', HB_DOMAIN_TXT ),
        'type'        => 'social-links',
        'section'     => 'socials',
      ),

      // Mobile
      array(
        'id'          => 'mobile_menu',
        'label'       => __( 'Show Mobile Menu For', HB_DOMAIN_TXT ),
        'std'         => 'md',
        'type'        => 'select',
        'section'     => 'mobile',
        'choices'     => array( 
          array(
            'value'       => 'xs',
            'label'       => __( 'Extra small devices (≤768px)', HB_DOMAIN_TXT ),
            'src'         => ''
          ),
          array(
            'value'       => 'sm',
            'label'       => __( 'Small devices (≤992px)', HB_DOMAIN_TXT ),
            'src'         => ''
          ),
          array(
            'value'       => 'md',
            'label'       => __( 'Medium devices (≤1200px)', HB_DOMAIN_TXT ),
            'src'         => ''
          ),
        )
      ),

      // Footer
      array(
        'id'          => 'footer_content',
        'label'       => __( 'Content', HB_DOMAIN_TXT ),
        'type'        => 'textarea',
        'section'     => 'footer',
      ),

    )
  );  
  /* allow settings to be filtered before saving */
  $custom_settings = apply_filters( ot_settings_id() . '_args', $custom_settings );
  
  /* settings are not the same update the DB */
  if ( $saved_settings !== $custom_settings ) {
    update_option( ot_settings_id(), $custom_settings ); 
  }
  
}


function hb_override_forced_textarea_simple( $bool, $field_id ){

  return true;
}
add_filter( 'ot_override_forced_textarea_simple', 'hb_override_forced_textarea_simple', 99, 2 );

function hb_measurement_unit_types( $array, $id ){

  return array(
    'px'  => 'px',
    '%'   => '%',
    'em'  => 'em'
  );
}
add_filter( 'ot_measurement_unit_types', 'hb_measurement_unit_types', 99, 2 );


function filter_ot_recognized_background_fields( $array, $field_id ) {

  if ( 'menu_background' == $field_id )

    foreach ( $array as $i => $o )

      if ( $o == 'background-attachment' ) unset($array[$i]);

  return $array;

}
add_filter( 'ot_recognized_background_fields', 'filter_ot_recognized_background_fields', 10, 2 );

function filter_ot_radio_images( $array, $field_id ) {

  if ( 'content_skin' == $field_id ){

    $array = array(
        array(
          'value'   => 'modern-content',
          'label'   => __( 'Modern', HB_DOMAIN_TXT),
          'src'     => OT_URL . 'assets/images/layout/modern-content.png'
        ),
        array(
          'value'   => 'minimal-content',
          'label'   => __( 'Minimal', HB_DOMAIN_TXT),
          'src'     => OT_URL . 'assets/images/layout/minimal-content.png'
        ),
    );

  } else {

    $array = array(
        array(
          'value'   => 'left',
          'label'   => __( 'Left Sidebar', HB_DOMAIN_TXT),
          'src'     => OT_URL . 'assets/images/layout/left-sidebar.png'
        ),
        array(
          'value'   => 'right',
          'label'   => __( 'Right Sidebar', HB_DOMAIN_TXT),
          'src'     => OT_URL . 'assets/images/layout/right-sidebar.png'
        ),
        array(
          'value'   => 'nowhere',
          'label'   => __( 'Full Width (no sidebar)', HB_DOMAIN_TXT),
          'src'     => OT_URL . 'assets/images/layout/full-width.png'
        ),
    );

  }

  return $array;

}
add_filter( 'ot_radio_images', 'filter_ot_radio_images', 10, 2 );


function hb_type_background_size_choices( $array, $field_id ){

  return array(
    array(
      'label' => 'background-size',
      'value' => ''
    ),
    array(
      'label' => 'Cover',
      'value' => 'cover'
    ),
    array(
      'label' => 'Contain',
      'value' => 'contain'
    )
  );
}
add_filter( 'ot_type_background_size_choices', 'hb_type_background_size_choices', 10, 2 );


function hb_font_preview_text_custom( $txt, $field_id ){

  switch ($field_id) {
 
    case 'body_typo':

      return 'Grumpy wizards make toxic brew for the evil Queen and Jack. One morning, when Gregor Samsa woke from troubled dreams, he found himself transformed in his bed into a horrible vermin. He lay on his armour-like back, and if he lifted his head a little he could see his brown belly, slightly domed and divided by arches into stiff sections. The bedding was hardly able to cover it and seemed ready to slide off any moment.';
    break;

    default:
      
      return $txt;
    break;
  }

}
add_filter( 'hb_font_preview_text', 'hb_font_preview_text_custom', 10, 2 );

function hb_recognized_typography_fields( $array, $field_id ){

  if ( $field_id == 'body_typo' )

    foreach( $array as $i => $v )

      if ( 'text-transform' == $v 
        || 'text-decoration' == $v 
        || 'letter-spacing' == $v 
        || 'font-subset' == $v 
        || 'font-style' == $v 
        || 'font-weight' == $v )

        unset($array[$i]);

  if ( $field_id == 'headlines_typo'  )

    foreach( $array as $i => $v )

      if ( 'font-subset' == $v 
        || 'font-style' == $v )

        unset($array[$i]);

  return $array;
}
add_filter( 'ot_recognized_typography_fields', 'hb_recognized_typography_fields', 10, 2 );

function hb_recognized_text_decorations( $array, $field_id ){

  return array(
      'none'          => 'None',
      'line-through'  => 'Line Through',
      'overline'      => 'Overline',
      'underline'     => 'Underline'
  );
}
add_filter( 'ot_recognized_text_decorations', 'hb_recognized_text_decorations', 10, 2 );

/**
 * Linr Height
 */
function hb_line_height_low_range( $number, $field_id ){ return 0; }
add_filter( 'ot_line_height_low_range', 'hb_line_height_low_range', 10, 2 );

function hb_line_height_high_range( $number, $field_id ){ return 2; }
add_filter( 'ot_line_height_high_range', 'hb_line_height_high_range', 10, 2 );

function hb_line_height_range_interval( $number, $field_id ){ return 0.1; }
add_filter( 'ot_line_height_range_interval', 'hb_line_height_range_interval', 10, 2 );

function hb_line_height_unit_type( $number, $field_id ){ return ''; }
add_filter( 'ot_line_height_unit_type', 'hb_line_height_unit_type', 10, 2 );


/**
 * Letter spacing 
 */
function hb_recognized_letter_spacing( $array, $field_id ){

  return array(
    '-20px' => '-20px',
    '-19px' => '-19px',
    '-18px' => '-18px',
    '-17px' => '-17px',
    '-16px' => '-16px',
    '-15px' => '-15px',
    '-14px' => '-14px',
    '-13px' => '-13px',
    '-12px' => '-12px',
    '-11px' => '-11px',
    '-10px' => '-10px',
    '-9px' => '-9px',
    '-8px' => '-8px',
    '-7px' => '-7px',
    '-6px' => '-6px',
    '-5px' => '-5px',
    '-4px' => '-4px',
    '-3px' => '-3px',
    '-2px' => '-2px',
    '-1px' => '-1px',
    '0px' => '0px',
    '1px' => '1px',
    '2px' => '2px',
    '3px' => '3px',
    '4px' => '4px',
    '5px' => '5px',
    '6px' => '6px',
    '7px' => '7px',
    '8px' => '8px',
    '9px' => '9px',
    '10px' => '10px',
    '11px' => '11px',
    '12px' => '12px',
    '13px' => '13px',
    '14px' => '14px',
    '15px' => '15px',
    '16px' => '16px',
    '17px' => '17px',
    '18px' => '18px',
    '19px' => '19px',
    '20px' => '20px',
  );
}
add_filter( 'ot_recognized_letter_spacing', 'hb_recognized_letter_spacing', 10, 2 );



/**
 * Google font typography option type.
 *
 * See @ot_display_by_type to see the full list of available arguments.
 *
 * @param     array     An array of arguments.
 * @return    string
 *
 * @access    public
 * @since     2.0
 */
if ( ! function_exists( 'ot_type_googlefont' ) ) {
  
    function ot_type_googlefont( $args = array() ) {
    
    /* turns arguments array into variables */
    extract( $args );
    
    /* format setting outer wrapper */
      echo '<div class="format-setting type-typography">';
    
      /* description */
      echo $field_desc ? '<div class="description"><p>' . htmlspecialchars_decode( $field_desc ) . '</p></div>' : '';

      /* format setting inner wrapper */
      echo '<div class="format-setting-inner">';
    
        /* allow fields to be filtered */
        $ot_recognized_typography_fields = apply_filters( 'ot_recognized_typography_fields', array( 
          'font-color',
          'font-family',
          'font-id', 
          // 'font-size', 
          'font-style', 
          'font-variant', 
          'font-weight', 
          'font-subset',
          'letter-spacing', 
          // 'line-height', 
          'text-decoration', 
          'text-transform'
        ), $field_id );
        
        /* build font family */
        if ( in_array( 'font-family', $ot_recognized_typography_fields ) ) {
          $font_family = isset( $field_value['font-family'] ) ? $field_value['font-family'] : '';
          echo '<select name="' . esc_attr( $field_name ) . '[font-family]" data-group="' . esc_attr( $field_id ) . '" id="' . esc_attr( $field_id ) . '-font-family" class="option-tree-ui-select hb-google-font-select' . esc_attr( $field_class ) . '">';
          echo '<option value="">font-family</option>';
          
          $current_font    = NULL;
          foreach ( hb_recognized_google_fonts( $field_id ) as $id => $font ) {
              
            $key = preg_replace( '/\s+/', '', strtolower($font['family']) );
            $variants = implode(",", $font['variants']);
            $subsets = implode(",", $font['subsets']);
            
            if( $font_family == esc_attr( $key ) ) {
                $current_font = $font['family'];
              }
                        
            echo '<option data-fontid="'.$id.'" data-subsets="'.$subsets.'" data-variants="'.$variants.'" data-font="' . esc_attr( $font['family'] ) . '" data-family="' . esc_attr( $font['family'] ) . '" value="' . esc_attr( $key ) . '" ' . selected( $font_family , $key , false ) . '>' . esc_attr( $font['family'] ) . '</option>';
            
          }
          
          echo '</select>';
        }
        
        /* hidden font id */
        if ( in_array( 'font-id', $ot_recognized_typography_fields ) ) {
          $font_id = isset( $field_value['font-id'] ) ? esc_attr( $field_value['font-id'] ) : '';
          echo '<input type="hidden" name="' . esc_attr( $field_name ) . '[font-id]" id="' . esc_attr( $field_id ) . '-fontid" value="' . esc_attr( $font_id ) . '" autocomplete="off" />';
        }
        
        /* build font subsets */
        if ( in_array( 'font-subset', $ot_recognized_typography_fields ) ) {
          $font_subset = isset( $field_value['font-subset'] ) ? esc_attr( $field_value['font-subset'] ) : '';
          echo '<select name="' . esc_attr( $field_name ) . '[font-subset]" data-group="' . esc_attr( $field_id ) . '" id="' . esc_attr( $field_id ) . '-font-subset" class="option-tree-ui-select hb-google-font-subset ' . esc_attr( $field_class ) . '">';
          echo '<option value="">font-subset</option>';
          foreach ( ot_recognized_google_subsets( $field_id ) as $key => $value ) {
            echo '<option value="' . esc_attr( $key ) . '" ' . selected( $font_subset, $key, false ) . '>' . esc_attr( $value ) . '</option>';
          }
          echo '</select>';
        }
        
        /* build font size */
        if ( in_array( 'font-size', $ot_recognized_typography_fields ) ) {
          $font_size = isset( $field_value['font-size'] ) ? esc_attr( $field_value['font-size'] ) : '';
          echo '<select name="' . esc_attr( $field_name ) . '[font-size]" data-group="' . esc_attr( $field_id ) . '" id="' . esc_attr( $field_id ) . '-font-size" class="option-tree-ui-select hb-google-font-size ' . esc_attr( $field_class ) . '">';
          echo '<option value="">font-size</option>';
          
          $current_font_size = '16px';
          foreach( ot_recognized_font_sizes( $field_id ) as $option ) { 
            
            if( $font_size == $option ) {
              $current_font_size = esc_attr( $option );
            }
            
            echo '<option value="' . esc_attr( $option ) . '" ' . selected( $font_size, $option, false ) . '>' . esc_attr( $option ) . '</option>';
          }
          echo '</select>';
        }
        
        /* build font weight */
        $current_weight = NULL;
        if ( in_array( 'font-weight', $ot_recognized_typography_fields ) ) {
          $font_weight = isset( $field_value['font-weight'] ) ? esc_attr( $field_value['font-weight'] ) : '';
          echo '<select name="' . esc_attr( $field_name ) . '[font-weight]" data-group="' . esc_attr( $field_id ) . '" id="' . esc_attr( $field_id ) . '-font-weight" class="option-tree-ui-select hb-google-font-weight ' . esc_attr( $field_class ) . '">';
          echo '<option value="">font-weight</option>';
          
          foreach ( ot_recognized_google_font_weights( $field_id ) as $key => $value ) {
            if( $font_weight == $key ) {
              $current_weight = esc_attr( $key );
            }
            echo '<option value="' . esc_attr( $key ) . '" ' . selected( $font_weight, $key, false ) . '>' . esc_attr( $value ) . '</option>';
          }
          echo '</select>';
        }
        
        /* build line height */
        if ( in_array( 'line-height', $ot_recognized_typography_fields ) ) {
          $line_height = isset( $field_value['line-height'] ) ? esc_attr( $field_value['line-height'] ) : '';
          echo '<select name="' . esc_attr( $field_name ) . '[line-height]" data-group="' . esc_attr( $field_id ) . '" id="' . esc_attr( $field_id ) . '-line-height" class="option-tree-ui-select hb-google-line-height ' . esc_attr( $field_class ) . '">';
          echo '<option value="">line-height</option>';
          foreach( ot_recognized_line_heights( $field_id ) as $option ) { 
            echo '<option value="' . esc_attr( $option ) . '" ' . selected( $line_height, $option, false ) . '>' . esc_attr( $option ) . '</option>';
          }
          echo '</select>';
        }
        
        /* build font style */
        $current_style = NULL;
        if ( in_array( 'font-style', $ot_recognized_typography_fields ) ) {
          $font_style = isset( $field_value['font-style'] ) ? esc_attr( $field_value['font-style'] ) : '';
          echo '<select name="' . esc_attr( $field_name ) . '[font-style]" data-group="' . esc_attr( $field_id ) . '" id="' . esc_attr( $field_id ) . '-font-style" class="option-tree-ui-select hb-google-font-style ' . esc_attr( $field_class ) . '">';
            echo '<option value="">font-style</option>';
            foreach ( ot_recognized_google_font_styles( $field_id ) as $key => $value ) {
              if( $font_style == $key ) {
                $current_style = esc_attr( $key );
              }
              echo '<option value="' . esc_attr( $key ) . '" ' . selected( $font_style, $key, false ) . '>' . esc_attr( $value ) . '</option>';
            }
          echo '</select>';
        }
        
        /* build text transform */
        if ( in_array( 'text-transform', $ot_recognized_typography_fields ) ) {
          $text_transform = isset( $field_value['text-transform'] ) ? esc_attr( $field_value['text-transform'] ) : '';
          echo '<select name="' . esc_attr( $field_name ) . '[text-transform]" data-group="' . esc_attr( $field_id ) . '" id="' . esc_attr( $field_id ) . '-text-transform" class="option-tree-ui-select hb-google-text-transform ' . esc_attr( $field_class ) . '">';
          echo '<option value="">text-transform</option>';
          foreach ( ot_recognized_text_transformations( $field_id ) as $key => $value ) {
            echo '<option value="' . esc_attr( $key ) . '" ' . selected( $text_transform, $key, false ) . '>' . esc_attr( $value ) . '</option>';
          }
          echo '</select>';
        }
        
        /* build text decoration */
        if ( in_array( 'text-decoration', $ot_recognized_typography_fields ) ) {
          $text_decoration = isset( $field_value['text-decoration'] ) ? esc_attr( $field_value['text-decoration'] ) : '';
          echo '<select name="' . esc_attr( $field_name ) . '[text-decoration]" data-group="' . esc_attr( $field_id ) . '" id="' . esc_attr( $field_id ) . '-text-decoration" class="option-tree-ui-select hb-google-text-decoration ' . esc_attr( $field_class ) . '">';
          echo '<option value="">text-decoration</option>';
          foreach ( ot_recognized_text_decorations( $field_id ) as $key => $value ) {
            echo '<option value="' . esc_attr( $key ) . '" ' . selected( $text_decoration, $key, false ) . '>' . esc_attr( $value ) . '</option>';
          }
          echo '</select>';
        }
        
        /* build letter spacing */
        if ( in_array( 'letter-spacing', $ot_recognized_typography_fields ) ) {
          $letter_spacing = isset( $field_value['letter-spacing'] ) ? esc_attr( $field_value['letter-spacing'] ) : '';
          echo '<select name="' . esc_attr( $field_name ) . '[letter-spacing]" data-group="' . esc_attr( $field_id ) . '" id="' . esc_attr( $field_id ) . '-letter-spacing" class="option-tree-ui-select hb-google-letter-spacing ' . esc_attr( $field_class ) . '">';
          echo '<option value="">letter-spacing</option>';
          foreach ( ot_recognized_letter_spacing( $field_id ) as $key => $value ) {
            echo '<option value="' . esc_attr( $key ) . '" ' . selected( $letter_spacing, $key, false ) . '>' . esc_attr( $value ) . '</option>';
          }
          echo '</select>';
        }

        /* build preview window */
        if( !empty($current_font) ) {
          echo '<link id="hb-google-style-link-' . esc_attr( $field_id ) . '" rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family='.$current_font.':'.$current_weight.$current_style.'">';
        } else {
          echo '<link id="hb-google-style-link-' . esc_attr( $field_id ) . '" rel="stylesheet" type="text/css" href="">';
        }
        
        $font_preview_style = NULL;
        
        if( !empty($field_value['font-family']) ) {
          // $font_preview_style = '#hb-google-preview-' . esc_attr( $field_id ) . ' { font-size: '.$current_font_size.'; font-family: "'.$field_value['font-family'].'" !important; }';
          $font_preview_style = '#hb-google-preview-' . esc_attr( $field_id ) . ' {  font-family: "'.$field_value['font-family'].'" !important; }';
        }
        
        echo '<style id="hb-google-style-' . esc_attr( $field_id ) . '" type="text/css">'.$font_preview_style.'</style>';
        
        echo '<div id="hb-google-preview-' . esc_attr( $field_id ) . '" class="hb-google-font-preview clearfix">';
          
          $lorem = 'Grumpy wizards make toxic brew for the evil Queen and Jack.';

          _e(apply_filters( 'hb_font_preview_text' , $lorem , $field_id ) , HB_DOMAIN_TXT);  
        
        echo '</div>';
        
      echo '</div>';
      
    echo '</div>';
    
  }
  
}




/**
 * Recognized google font subsets
 */
if ( ! function_exists( 'ot_recognized_google_subsets' ) ) {

  function ot_recognized_google_subsets( $field_id = '' ) {
  
    return apply_filters( 'ot_recognized_google_subsets', array(
      'latin'         => 'Latin',
      'latin-ext'     => 'Latin Extended',
      'greek'         => 'Greek',
      'greek-ext'     => 'Greek Extended',
      'cyrillic'      => 'Cyrillic',
      'cyrillic-ext'  => 'Cyrillic Extended',
      'khmer'         => 'Khmer',
      'vietnamese'    => 'Vietnamese',
    ), $field_id );
    
  }

}

/**
 * Recognized google font styles
 */
if ( ! function_exists( 'ot_recognized_google_font_styles' ) ) {

  function ot_recognized_google_font_styles( $field_id = '' ) {
  
    return apply_filters( 'ot_recognized_google_font_styles', array(
      'regular'  => 'Normal',
      'italic'   => 'Italic'
    ), $field_id );
    
  }

}

/**
 * Recognized google font weight
 */
if ( ! function_exists( 'ot_recognized_google_font_weights' ) ) {

  function ot_recognized_google_font_weights( $field_id = '' ) {
    
    return apply_filters( 'ot_recognized_google_font_weights', array(
        '100'         =>  'Thin 100',
        '100italic'   =>  'Thin 100 Italic',
        '200'         =>  'Extra Light 200',
        '200italic'   =>  'Extra Light 200 Italic',
        '300'         =>  'Light 300',
        '300italic'   =>  'Light 300 Italic',
        'regular'     =>  'Normal 400',
        'italic'      =>  'Normal 400 Italic',
        '500'         =>  'Medium 500',
        '500italic'   =>  'Medium 500 Italic',
        '600'         =>  'Semi Bold 600',
        '600italic'   =>  'Semi Bold 600 Italic',
        '700'         =>  'Bold 700',
        '700italic'   =>  'Bold 700 Italic',
        '800'         =>  'Extra Bold 800',
        '800italic'   =>  'Extra Bold 800 Italic',
        '900'         =>  'Ultra Bold 900',
        '900italic'   =>  'Ultra Bold 900 Italic',
    ), $field_id );
  
  }
  
}


/**
 * Initialize the custom Meta Boxes Scripts. 
 */
add_action( 'admin_print_scripts', 'hb_theme_option_scripts', 99 );

function hb_theme_option_scripts() {

  ?>
  <script type="text/javascript">

  jQuery(document).ready(function($){

    /* google font integration
    ================================================== */
    var update_google_font_link = function( group ) {
      
      if(!group) {
        return;
      }
      
      var $this     = $("#"+group+"-font-family"),
        url         = 'http://fonts.googleapis.com/css?family=',
        family      = $this.find(':selected').data('family'),
        font_weight = $("#"+group+"-font-weight").val();
      
      if ( !font_weight || font_weight == 'regular' ) {font_weight = '400'}
      if ( font_weight == 'italic' ) {font_weight = '400italic'}

      $("#hb-google-style-link-"+group).attr("href" , url+family+':'+font_weight);
    
    }
    
    var update_google_font_preview = function( group , font_size , font , transform , decoration , font_weight , letter_spacing , line_height ) {

      font_style = 'normal';

      if ( undefined == font_weight ) { font_weight = '400' }
      if ( 'regular' == font_weight ){ font_weight = '400' }
      if ( 'italic' == font_weight ){ font_weight = '400'; font_style = 'italic'; }

      if ( -1 < font_weight.indexOf('italic') ) { font_weight = font_weight.replace('italic', ''); font_style = 'italic'; }
      
      $("#hb-google-style-"+group).text('#hb-google-preview-'+group+' { font-size: '+font_size+'; font-family: "'+ font +'" !important; text-transform: '+ transform +'; text-decoration: '+ decoration +'; font-weight: '+ font_weight +'; letter-spacing: '+ letter_spacing +'; line-height: '+ line_height +'; font-style: '+ font_style +' }');
    
    }
    
    var update_google_font_subsets = function( group , subsets ) {
      
      var subsets = subsets.split(","); 
      
      /* reset select field if selected state is not available anymore */   
      if( $.inArray( $("#"+group+"-font-subset").val() , subsets ) === -1 ) {
        $("#"+group+"-font-subset").prop('selectedIndex', 0).prev('span').replaceWith('<span>' + $("#"+group+"-font-subset").find('option:selected').text() + '</span>');
      }
      
      /* update available subsets */
      $("#"+group+"-font-subset option").each(function() {
        
        if( $.inArray( $(this).val() , subsets ) >= 0 || !$(this).val() ) {
          
          $(this).attr("disabled" , false);
          
        } else {
        
          $(this).attr("disabled" , true);
          
        }
        
      });
    
    } 
    
    var update_google_font_weights = function( group , variants ) {
      
      var variants = variants.split(",");
            
      /* reset select field if selected state is not available anymore */ 
      if( $.inArray( $("#"+group+"-font-weight").val() , variants ) === -1 ) {
        $("#"+group+"-font-weight").prop('selectedIndex', 0).prev('span').replaceWith('<span>' + $("#"+group+"-font-weight").find('option:selected').text() + '</span>');
      }
      
      $("#"+group+"-font-weight option").each(function() {
        
        if( $.inArray( $(this).val() , variants ) >= 0 || !$(this).val() ) {
        
          $(this).attr("disabled" , false);
        
        } else {
        
          $(this).attr("disabled" , true);
                
        }
          
      });
    }   
    
    var update_google_font_styles = function( group , variants ) {
    
      var variants = variants.split(",");
      
      /* reset select field if selected state is not available anymore */ 
      if( $.inArray( $("#"+group+"-font-style").val() , variants ) === -1 ) {
        $("#"+group+"-font-style").prop('selectedIndex', 0).prev('span').replaceWith('<span>' + $("#"+group+"-font-style").find('option:selected').text() + '</span>').show("highlight");
      }
      
      $("#"+group+"-font-style option").each(function() {
        
        if( $.inArray( $(this).val() , variants ) >= 0 || !$(this).val() ) {
        
          $(this).attr("disabled" , false);
        
        } else {
        
          $(this).attr("disabled" , true);
                
        }     
      
      });
    
    }
    
    var update_google_font_fields = function( group ) {
      
      if(!group) {
        return;
      }
      
      var $this         = $("#"+group+"-font-family"),
        font            = $this.find(':selected').data('font'),
        subsets         = $this.find(':selected').data('subsets'),
        family          = $this.find(':selected').data('family'),
        variants        = $this.find(':selected').data('variants'),
        font_id         = $this.find(':selected').data('fontid'),
        font_size       = $("#"+group+"-font-size").val(),
        font_weight     = $("#"+group+"-font-weight").val(),
        transform       = $("#"+group+"-text-transform").val(),
        decoration      = $("#"+group+"-text-decoration").val(),
        letter_spacing  = $("#"+group+"-letter-spacing").val(),
        line_height     = $("#"+group+"-line-height").val(),
        font_style      = $("#"+group+"-font-style").val();     
      
      if( font ) {
      
        /* update subsets */      
        update_google_font_subsets( group , subsets );
        
        /* update weights*/
        update_google_font_weights( group , variants );
        
        /* update styles*/
        update_google_font_styles( group , variants );
        
        /* change link attr */
        update_google_font_link( group );
              
        /* update font preview */
        update_google_font_preview( group , font_size , font, transform, decoration, font_weight, letter_spacing, line_height );   
        
        /* update hidden ID */
        $("#"+group+"-fontid").val(font_id);
        
      }
      
    }
    
    /* update all fields first */
    $(".hb-google-font-select").each(function() {
            
      var group = $(this).data("group");
                
      /* update fields */
      update_google_font_fields( group );
      
    });
    
    
    $(".hb-google-font-select, .hb-google-font-size, .hb-google-font-weight, .hb-google-font-style, .hb-google-text-transform, .hb-google-text-decoration, .hb-google-letter-spacing, .hb-google-line-height").change(function(){
      
      var group = $(this).data("group");
                
      /* update fields */
      update_google_font_fields( group );
      
    });

  })
  </script>

<?php 
} ?>