<?php
/**
 * Initialize the custom Meta Boxes. 
 */
add_action( 'admin_init', 'onyx_meta_boxes' );

function hb_get_metabox_animation( $dir = 'in' ){

  $animations = array(
    'in'  => array( "slideInDown","slideInLeft","slideInRight","slideInUp","bounceIn","bounceInDown","bounceInLeft","bounceInRight","bounceInUp","fadeIn","fadeInDown","fadeInDownBig","fadeInLeft","fadeInLeftBig","fadeInRight","fadeInRightBig","fadeInUp","fadeInUpBig","flipInX","flipInY","lightSpeedIn","rotateIn","rotateInDownLeft","rotateInDownRight","rotateInUpLeft","rotateInUpRight","rollIn","zoomIn","zoomInDown","zoomInLeft","zoomInRight","zoomInUp" ),
    'out' => array( "slideOutDown","slideOutLeft","slideOutRight","slideOutUp","bounceOut","bounceOutDown","bounceOutLeft","bounceOutRight","bounceOutUp","fadeOut","fadeOutDown","fadeOutDownBig","fadeOutLeft","fadeOutLeftBig","fadeOutRight","fadeOutRightBig","fadeOutUp","fadeOutUpBig","flipOutX","flipOutY","lightSpeedOut","rotateOut","rotateOutDownLeft","rotateOutDownRight","rotateOutUpLeft","rotateOutUpRight","rollOut","zoomOut","zoomOutDown","zoomOutLeft","zoomOutRight","zoomOutUp" )
  );

  $x = array();

  foreach ($animations[$dir] as $value)

    $x[] = array(
      'value'       => $value,
      'label'       => $value,
      'src'         => ''
    );

  return $x;
}

/**
 * Theme's Meta Boxes
 *
 * @return    void
 * @since     2.0
 */
function onyx_meta_boxes() {
  
  /**
   * Create a custom meta boxes array that we pass to 
   * the OptionTree Meta Box API Class.
   */
  $metaboxes  = array();


  // Posts & Pages Settings
  $metaboxes[] = array(
    'id'          => 'hb_pp_metabox',
    'title'       => __( 'Settings', HB_DOMAIN_TXT ),
    'desc'        => '',
    'pages'       => array( 'post', 'page' ),
    'context'     => 'normal',
    'priority'    => 'high',
    'fields'      => array(
      array(
        'id'          => 'subtitle',
        'label'       => __( 'Subtitle', HB_DOMAIN_TXT ),
        'type'        => 'text',
      ),
    )
  );


  // Pages Settings
  $metaboxes[] = array(
    'id'          => 'hb_pages_metabox',
    'title'       => __( 'Settings', HB_DOMAIN_TXT ),
    'desc'        => '',
    'pages'       => array( 'page' ),
    'context'     => 'normal',
    'priority'    => 'high',
    'fields'      => array(
      array(
        'id'          => 'page_custom_navigation',
        'label'       => __( 'Custom page navigation (optional)', HB_DOMAIN_TXT ),
        'type'        => 'taxonomy-select',
        'section'     => 'option_types',
        'taxonomy'    => 'nav_menu',
      ),
    )
  );


  // Landing Pages Settings
  $metaboxes[] = array(
    'id'          => 'hb_landing_metabox',
    'title'       => __( 'Landing Page Settings', HB_DOMAIN_TXT ),
    'desc'        => '',
    'pages'       => array( 'page' ),
    'context'     => 'normal',
    'priority'    => 'high',
    'fields'      => array(
      array(
        'id'          => 'promo_boxes',
        'label'       => __( 'Promo Boxes', HB_DOMAIN_TXT ),
        'type'        => 'list-item',
        'settings'    => array(
          array(
            'id'          => 'color',
            'label'       => __( 'Alt Color', HB_DOMAIN_TXT ),
            'type'        => 'colorpicker',
          ),
          array(
            'id'          => 'desc',
            'label'       => __( 'Description', HB_DOMAIN_TXT ),
            'type'        => 'textarea-simple',
          ),
          array(
            'id'          => 'link',
            'label'       => __( 'Button Link', HB_DOMAIN_TXT ),
            'type'        => 'text',
          ),
          array(
            'id'          => 'label',
            'label'       => __( 'Butoon Label', HB_DOMAIN_TXT ),
            'type'        => 'text',
          ),
          array(
            'id'          => 'img',
            'label'       => __( 'Image', HB_DOMAIN_TXT ),
            'type'        => 'upload',
          ),
        )
      ),
      array(
        'id'          => 'grid',
        'label'       => __( 'Grid Boxes', HB_DOMAIN_TXT ),
        'type'        => 'grid-builder',
      )
    )
  );

  /**
   * Register our meta boxes using the 
   * ot_register_meta_box() function.
   */
  if ( function_exists( 'ot_register_meta_box' ) )

    foreach ( $metaboxes as $metaboxe )

      ot_register_meta_box( $metaboxe );

}

/**
 * Initialize the custom Meta Boxes Scripts. 
 */
add_action( 'admin_print_scripts', 'onyx_meta_boxes_scripts', 99 );

function onyx_meta_boxes_scripts() {

  ?>
  <script type="text/javascript">

      jQuery(document).ready(function ($) {

          function toggle_page_metaboxes() {

              var template = $("#page_template").val();

              if ( ! template ) { return }

              if (template == 'page-landing.php') {
                $('#hb_pp_metabox').fadeOut('fast');
                $('#postdivrich').fadeOut('fast');
                $('#hb_landing_metabox').fadeIn('fast');
              } else {
                $('#hb_landing_metabox').fadeOut('fast');
                $('#postdivrich').fadeIn('fast');
                $('#hb_pp_metabox').fadeIn('fast');
              }
          }

          toggle_page_metaboxes();

          $('#page_template').change(toggle_page_metaboxes);
      });
  </script><?php
}