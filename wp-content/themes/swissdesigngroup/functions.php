<?php
/**
 * Swiss Design Group functions and definitions
 *
 * Set up the theme and provides some helper functions, which are used in the
 * theme as custom template tags. Others are attached to action and filter
 * hooks in WordPress to change core functionality.
 *
 * When using a child theme you can override certain functions (those wrapped
 * in a function_exists() call) by defining them first in your child theme's
 * functions.php file. The child theme's functions.php file is included before
 * the parent theme's file, so the child theme functions would be used.
 *
 * @link https://codex.wordpress.org/Theme_Development
 * @link https://codex.wordpress.org/Child_Themes
 *
 * Functions that are not pluggable (not wrapped in function_exists()) are
 * instead attached to a filter or action hook.
 *
 * For more information on hooks, actions, and filters,
 * {@link https://codex.wordpress.org/Plugin_API}
 *
 * @package WordPress
 * @subpackage Swiss_Design_Group
 * @since Swiss Design Group 1.0
 */

@define( 'HB_THEME_NAME', 'Swiss Design Group' );
@define( 'HB_THEME_VERSION', '2.0' );
@define( 'HB_DOMAIN_TXT', 'SDG' );
@define( 'HB_DEV_MODE', false );
@define( 'HB_THEME_PATH', get_template_directory() );
@define( 'HB_THEME_URL',  get_template_directory_uri() );
@define( 'HB_CHILD_PATH', get_stylesheet_directory() );
@define( 'HB_CHILD_URL',  get_stylesheet_directory_uri() );


/* Mobile Detect */
if ( ! class_exists('Mobile_Detect') ) { 
	
	include_once( HB_THEME_PATH . '/inc/hb-mobile-detect-class.php' );
	$detect = new Mobile_Detect();

} elseif( class_exists('Mobile_Detect') ) {
   
    $detect = new Mobile_Detect();

}

if ( ! function_exists( 'hb_is_plugin_active' ) ):

	/*
	 * Helper function to detect if already plugin is installed
	 *
	 */	
	function hb_is_plugin_active( $plugin ) {
		
	    if ( is_multisite() && array_key_exists( $plugin , get_site_option('active_sitewide_plugins', array() ) ) )
	                    
	        return array_key_exists( $plugin , get_site_option('active_sitewide_plugins', array() ) );
	        
	    elseif ( is_multisite() && in_array( $plugin, (array) get_option( 'active_plugins', array() ) ) )
	                    
	        return in_array( $plugin, (array) get_option( 'active_plugins', array() ) );
	        
	    else
	        
	        return in_array( $plugin, (array) get_option( 'active_plugins', array() ) );
	    
	}

endif;

/**
 * Get current page ID function
 *
 * @return int
 **/
function hb_get_page_ID(){

	if ( is_front_page() && ! is_home() ) { // static front page

		$id = get_option('page_on_front');

	} elseif ( is_home() && ! is_front_page() ){ // static blog page

		$id = get_option('page_for_posts');
		
	} else {

		$id = get_the_ID();
	}

	return intval( $id );
}


/*
|--------------------------------------------------------------------------
| Option Tree Integration
|--------------------------------------------------------------------------
*/
if ( ! hb_is_plugin_active( 'option-tree/ot-loader.php' ) ) {

	add_filter( 'ot_show_new_layout', '__return_false' ); // Hide New Layout
	add_filter( 'ot_theme_mode', '__return_true' ); // Required: set 'ot_theme_mode' filter to true.
	
	if( ! HB_DEV_MODE )
		add_filter( 'ot_show_pages', '__return_false' ); // Show / hide Settings Pages

	/**
	 * Required: include OptionTree.
	 */
	load_template( trailingslashit( HB_THEME_PATH ) . 'admin/ot-loader.php' );

	/**
	 * Grid Builder
	 */
	load_template( trailingslashit( HB_THEME_PATH ) . 'admin/grid-builder/init.php' );

	/**
	 * Theme Options
	 */
	load_template( trailingslashit( HB_THEME_PATH ) . 'admin/hb-theme-options.php' );

	/**
	 * Metaboxes
	 */
	load_template( trailingslashit( HB_THEME_PATH ) . 'admin/hb-meta-boxes.php' );

	/**
	 * Google fonts
	 */
	load_template( trailingslashit( HB_THEME_PATH ) . 'admin/hb-google-fonts.php' );

} else {
	
	function notify_user_ot_detected() {
		
		$alert = '<div style="position:fixed; z-index:9999; width:100%; text-align:center; padding: 20px; background: #f6f6f6;border-bottom: 4px solid #FF7979;font-size: 16px;">';
			$alert .= __('Option Tree Plugin has been detected! Please deactivate this Plugin to prevent themecrashes and failures!', HB_DOMAIN_TXT );
	 	$alert .= '</div>';
		
		echo $alert;
		
	}
	
	/* display user information on front page with the help of the ut_before_header_hook */
	add_action( 'ut_before_header_hook', 'notify_user_ot_detected' );
}


if ( ! function_exists( 'r' ) ):

	/**
	 * 
	 * Helper function
	 *
	 */
	function r( $str ){

		echo "<pre>", var_dump($str), "</pre>";
	}
endif;


if ( ! function_exists('hb_sanitize_hex_color') ):
	/**
	 * sanitize hex color function
	 *
	 * @return null | string
	 * @author 
	 **/
	function hb_sanitize_hex_color( $color ){

		if ( '' === $color )
			return '';

		// 3 or 6 hex digits, or the empty string.
		if ( preg_match('|^#([A-Fa-f0-9]{3}){1,2}$|', $color ) ){
			return $color;
		}

		return null;
	}
endif;

/**
 * Set the content width based on the theme's design and stylesheet.
 *
 * @since Swiss Design Group 1.0
 */
if ( ! isset( $content_width ) ) {
	$content_width = 980;
}

/**
 * Swiss Design Group only works in WordPress 4.1 or later.
 */
if ( version_compare( $GLOBALS['wp_version'], '4.1-alpha', '<' ) ) {
	require get_template_directory() . '/inc/back-compat.php';
}

if ( ! function_exists( 'SDG_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 *
 * @since Swiss Design Group 1.0
 */
function SDG_setup() {

	add_theme_support('woocommerce');
	
	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on SDG, use a find and replace
	 * to change HB_DOMAIN_TXT to the name of your theme in all the template files
	 */
	load_theme_textdomain( HB_DOMAIN_TXT, get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * See: https://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
	 */
	add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size( 825, 510, true );

	// This theme uses wp_nav_menu() in two locations.
	register_nav_menus( array(
		'primary'   => __( 'Primary menu', HB_DOMAIN_TXT ),
		'secondary' => __( 'Alternative menu', HB_DOMAIN_TXT ),
		'footer_l'	=> __( 'Footer left menu', HB_DOMAIN_TXT ),
		'footer_r'	=> __( 'Footer right menu', HB_DOMAIN_TXT ),
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form', 'comment-form', 'comment-list', 'gallery', 'caption'
	) );

	/*
	 * Enable support for Post Formats.
	 *
	 * See: https://codex.wordpress.org/Post_Formats
	 */

	//	add_theme_support( 'post-formats', array(
	//		'aside', 'image', 'video', 'quote', 'link', 'gallery', 'status', 'audio', 'chat'
	//	) );

	$color_scheme  = SDG_get_color_scheme();
	$default_color = trim( $color_scheme[0], '#' );

	// Setup the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'SDG_custom_background_args', array(
		'default-color'      => $default_color,
		'default-attachment' => 'fixed',
	) ) );

	/*
	 * This theme styles the visual editor to resemble the theme style,
	 * specifically font, colors, icons, and column width.
	 */
	//add_editor_style( array( 'css/editor-style.css', SDG_fonts() ) );
}
endif; // SDG_setup
add_action( 'after_setup_theme', 'SDG_setup' );

/**
 * Register widget area.
 *
 * @since Swiss Design Group 1.0
 *
 * @link https://codex.wordpress.org/Function_Reference/register_sidebar
 */
function SDG_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Widget Area', HB_DOMAIN_TXT ),
		'id'            => 'sidebar-1',
		'description'   => __( 'Add widgets here to appear in your sidebar.', HB_DOMAIN_TXT ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );
}
add_action( 'widgets_init', 'SDG_widgets_init' );



if ( ! function_exists( 'SDG_get_google_font_url' ) ) :
/**
 * Register Google fonts for Swiss Design Group.
 *
 * @since Swiss Design Group 1.0
 *
 * @note should be call in wp_enqueue_scripts.
 */
function SDG_get_google_font_url( $fonts_object ) {

	$fonts_url = '';
	$fonts     = array();
	$subsets   = 'latin,latin-ext';

	foreach ( $fonts_object as $font ) {

		/* translators: If there are characters in your language that are not supported by font familiy, translate this to 'off'. Do not translate into your own language. */
		if ( 'off' !== _x( 'on', $font['family'].' font: on or off', HB_DOMAIN_TXT ) ) {
			$fonts[] = $font['family']. ':' .$font['weight'];
		}
	}

	/* translators: To add an additional character subset specific to your language, translate this to 'greek', 'cyrillic', 'devanagari' or 'vietnamese'. Do not translate into your own language. */
	$subset = _x( 'no-subset', 'Add new subset (greek, cyrillic, devanagari, vietnamese)', HB_DOMAIN_TXT );

	if ( 'cyrillic' == $subset ) {
		$subsets .= ',cyrillic,cyrillic-ext';
	} elseif ( 'greek' == $subset ) {
		$subsets .= ',greek,greek-ext';
	} elseif ( 'devanagari' == $subset ) {
		$subsets .= ',devanagari';
	} elseif ( 'vietnamese' == $subset ) {
		$subsets .= ',vietnamese';
	}

	if ( $fonts ) {
		$fonts_url = add_query_arg( array(
			'family' => implode( '|', $fonts ),
			'subset' => $subsets,
		), '//fonts.googleapis.com/css' );
	}

	return $fonts_url;
}
endif;

if ( ! function_exists( 'SDG_print_typekit' ) ) :
function SDG_print_typekit(){

	echo ot_get_option('typekit');
}
endif;

/**
 * Enqueue scripts and styles.
 *
 * @since Swiss Design Group 1.0
 */
function SDG_scripts() {

	global $detect;

	$tablet = $detect->isTablet();
	$mobile = $detect->isMobile();
	$chrome = preg_match("/chrome/",strtolower($_SERVER['HTTP_USER_AGENT']));

	$minify = '.min';

	// Add custom fonts
	switch ( ot_get_option('site_fonts_type') ) {

		case 'typekit':

			add_action( 'wp_head', 'SDG_print_typekit', 99 );

			break;

		case 'google-fonts':

			/* available google fonts */
			$google_fonts = hb_recognized_google_fonts();
			
			/* custom array of all affected option tree options */
			$option_keys = array(

				'body' 		=> ot_get_option('body_typo'),
				'alt'		=> ot_get_option('headlines_typo'),
			);

			$option_keys['body']['font-weight'] = '400';

			if ( 'italic' 	== $option_keys['alt']['font-weight'] ) $option_keys['alt']['font-weight'] = '400italic';
			if ( 'regular' 	== $option_keys['alt']['font-weight'] ) $option_keys['alt']['font-weight'] = '400';
				
			$fonts = array(
				'body' => array(
					'id'     => '',
					'family' => '',
					'font-family' => '',
					'weight' => array('300', '300italic', '400italic', '700', '700italic')
				),

				'alt' => array(
					'id'     => '',
					'family' => '',
					'font-family' => '',
					'weight' => array()
				)
			);

			/* create query string */		
			foreach( $option_keys as $key => $option ) {
				
				if( isset($option['font-id']) && !empty($google_fonts[$option['font-id']]) ) {

					/* replace whitespace with + */
					$family = preg_replace("/\s+/" , '+' , $google_fonts[$option['font-id']]['family'] );

					$fonts[$key]['id'] 			= $option['font-id'];
					$fonts[$key]['family'] 		= $family;
					$fonts[$key]['font-family'] = $google_fonts[$option['font-id']]['family'];
					$fonts[$key]['weight'][] 	= $option['font-weight'];
					$fonts[$key]['weight'] 		= array_unique( $fonts[$key]['weight'] );
					$fonts[$key]['weight'] 		= implode(',', $fonts[$key]['weight']);
				}
			}


			if ( empty($fonts['body']['font-family']) ){

				$fonts['body']['family'] = 'Inconsolata';
				$fonts['body']['font-family'] = 'Inconsolata';
				$fonts['body']['weight'] = '400,700';
			}

			if ( empty($fonts['alt']['font-family']) ){

				$fonts['alt']['family'] = 'Montserrat';
				$fonts['alt']['font-family'] = 'Montserrat';
				$fonts['alt']['weight'] = '700';
			}

			$alt_fint_style  = 'normal';
			$alt_font_weight = !empty($option_keys['alt']['font-weight']) ? $option_keys['alt']['font-weight'] : '700';

			if ( strpos( $alt_font_weight, 'italic') ){

				$alt_font_weight = str_replace('italic', '', $alt_font_weight);
				$alt_fint_style  = 'italic';
			}

			$css  = "";
			$css .= "h1,.h1,h2,.h2,h3,.h3,h4,.h4,h5,.h5,h6,.h6{";
			$css .= "font-family:'".$fonts['alt']['font-family']."',sans-serif;";
			$css .= "font-weight:".$alt_font_weight.";";
			$css .= "font-style:".$alt_fint_style.";";

			if ( !empty($option_keys['alt']['text-transform']) )
				$css .= "text-transform:".$option_keys['alt']['text-transform'].";";
			if ( !empty($option_keys['alt']['text-decoration']) )
				$css .= "text-decoration:".$option_keys['alt']['text-decoration'].";";
			if ( !empty($option_keys['alt']['letter-spacing']) )
				$css .= "letter-spacing:".$option_keys['alt']['letter-spacing'].";";

			$css .= "}";
			$css .= "body{font-family: '".$fonts['body']['font-family']."',sans-serif}";

			$font_url = SDG_get_google_font_url( $fonts );

			wp_enqueue_style( 'SDG-google-fonts', $font_url, array('SDG-style'), null );

			wp_add_inline_style( 'SDG-google-fonts', $css );

			break;
		
		default:

 			$fonts = array ( 
 				'alt' => array( 
 					'family' => 'Montserrat',
 					'weight' => '700'
 				), 

 				'body' => array(
 					'family' => 'Inconsolata',
 					'weight' => '400,700'
 				) 
 			) ;

			$css  = "h1,.h1,h2,.h2,h3,.h3,h4,.h4,h5,.h5,h6,.h6{font-family:'".$fonts['alt']['family']."',sans-serif;}";
			$css .= "body{font-family: '".$fonts['body']['family']."',sans-serif}";

			$font_url = SDG_get_google_font_url( $fonts );

			wp_enqueue_style( 'SDG-google-fonts', $font_url, array('SDG-style'), null );

			wp_add_inline_style( 'SDG-google-fonts', $css );

			break;
	}

	// Load our main stylesheet.
	wp_enqueue_style( 
		'SDG-style', 
		get_stylesheet_uri(), 
		array() 
	);

	// Load the Internet Explorer specific stylesheet.
	wp_enqueue_style( 'SDG-ie', get_template_directory_uri() . '/css/ie.css', array( 'SDG-style' ), '20141010' );
	wp_style_add_data( 'SDG-ie', 'conditional', 'lt IE 9' );

	// Load the Internet Explorer 7 specific stylesheet.
	wp_enqueue_style( 'SDG-ie7', get_template_directory_uri() . '/css/ie7.css', array( 'SDG-style' ), '20141010' );
	wp_style_add_data( 'SDG-ie7', 'conditional', 'lt IE 8' );

	if ( ! wp_script_is('jquery-cookie') ) {
		wp_enqueue_script( 'jquery-cookie', get_template_directory_uri() . '/js/jquery.cookie.min.js', array(), '1.4.1', true );
	}

	if ( is_singular() && wp_attachment_is_image() ) {
		wp_enqueue_script( 'SDG-keyboard-image-navigation', get_template_directory_uri() . '/js/keyboard-image-navigation.js', array( 'jquery' ), '20141010' );
	}

	wp_enqueue_script( 'SDG-script', get_template_directory_uri() . '/js/functions.js', array( 'jquery' ), '1.0', true );
	wp_localize_script( 'SDG-script', 'detect', array(
		'ajaxurl' 		=> esc_url(admin_url( 'admin-ajax.php')),
		'nonce' 		=> wp_create_nonce('hb-ajax'),
		'mobile' 		=> $detect->isMobile(),
		'tablet' 		=> $detect->isTablet(),
		'chrome' 		=> $chrome,
		'body_classes' 	=> esc_js( join( ' ', get_body_class() ) ),
		'all' 			=> __('All', HB_DOMAIN_TXT),
	) );

	if( $chrome && !$mobile && !$tablet ) 
		wp_enqueue_script( 'smooth-scroll', HB_THEME_URL . '/js/SmoothScroll.min.js', array( 'jquery' ), '1.2.1', true );

}
add_action( 'wp_enqueue_scripts', 'SDG_scripts' );

/**
 * Add featured image as background image to post navigation elements.
 *
 * @since Swiss Design Group 1.0
 *
 * @see wp_add_inline_style()
 */
function SDG_post_nav_background() {
	if ( ! is_single() ) {
		return;
	}

	$previous = ( is_attachment() ) ? get_post( get_post()->post_parent ) : get_adjacent_post( false, '', true );
	$next     = get_adjacent_post( false, '', false );
	$css      = '';

	if ( is_attachment() && 'attachment' == $previous->post_type ) {
		return;
	}

	if ( $previous &&  has_post_thumbnail( $previous->ID ) ) {
		$prevthumb = wp_get_attachment_image_src( get_post_thumbnail_id( $previous->ID ), 'post-thumbnail' );
		$css .= '
			.post-navigation .nav-previous { background-image: url(' . esc_url( $prevthumb[0] ) . '); }
			.post-navigation .nav-previous .post-title, .post-navigation .nav-previous a:hover .post-title, .post-navigation .nav-previous .meta-nav { color: #fff; }
			.post-navigation .nav-previous a:before { background-color: rgba(0, 0, 0, 0.4); }
		';
	}

	if ( $next && has_post_thumbnail( $next->ID ) ) {
		$nextthumb = wp_get_attachment_image_src( get_post_thumbnail_id( $next->ID ), 'post-thumbnail' );
		$css .= '
			.post-navigation .nav-next { background-image: url(' . esc_url( $nextthumb[0] ) . '); }
			.post-navigation .nav-next .post-title, .post-navigation .nav-next a:hover .post-title, .post-navigation .nav-next .meta-nav { color: #fff; }
			.post-navigation .nav-next a:before { background-color: rgba(0, 0, 0, 0.4); }
		';
	}

	wp_add_inline_style( 'SDG-style', $css );
}
//add_action( 'wp_enqueue_scripts', 'SDG_post_nav_background' );

/**
 *
 *
 *
 */
function hb_socials()
{

	$socials = ot_get_option('site_socials');

	if ( empty($socials) ) return;

	foreach ($socials as $social) {
		
		if ( empty($social['href']) ) continue;

		echo '<a href="', esc_attr($social['href']), '" target="_blank"><span class="screen-reader-text">', strip_tags($social['name']), '</span></a>';
	}
}

/**
 * Site banner action
 *
 * @return void
 * @author 
 **/
function hb_site_banner(){

	$hb_page_has_banner = apply_filters('hb_page_has_banner', true );
	$is_page_landing    = is_page_template('page-landing.php');

	if ( ! $is_page_landing && ! $hb_page_has_banner ){

		return;
	}

	$args = array(

		'title' 		=> '',
		'subtitle' 		=> '',
		'over_content' 	=> false,
		'fallback' 		=> 'hb_banner_default',
	);

	if ( is_home() && ! is_front_page() ) :

		$args['title'] = get_option('blogdescription');
		$args['over_content'] 	= true;

	elseif ( is_page() && $is_page_landing ) :

		$args['fallback'] = 'hb_banner_slider';

	elseif ( (is_single() && 'post' == get_post_type()) || is_page() ) :

		$args['title'] = get_the_title();

		$subtitle = get_post_meta(get_the_ID(), 'subtitle', true);
		if ( $subtitle )
			$args['subtitle'] = $subtitle;

		$args['over_content'] 	= true;

	// elseif ( is_category() ) :

	// 	$args['title'] 			= hb_get_the_archive_title();
	// 	$args['subtitle'] 		= get_the_archive_description();
	// 	$args['fallback'] 		= 'hb_banner_category';
	// 	$args['over_content'] 	= true;

	elseif ( is_archive() ) :

		//$args['title'] = hb_get_the_archive_title();
		$args['subtitle'] = get_the_archive_description();
		$args['over_content'] 	= true;

	elseif ( is_search() ) :

		$args['title'] = __( 'Search Results for:', HB_DOMAIN_TXT );
		$args['subtitle'] = get_search_query();
		$args['over_content'] 	= true;

	elseif ( is_404() ) :

		$args['title'] = __( 'Oops! That page can&rsquo;t be found.', HB_DOMAIN_TXT );
		$args['subtitle'] = __( 'It looks like nothing was found at this location. Maybe try a search?', HB_DOMAIN_TXT );
		$args['over_content'] 	= true;

	else:
		// huh?!
	endif;

	extract($args);

	?>
	<div id="hero-banner" class="<?php echo str_replace('_', '-', $fallback) ?>">
		<?php do_action($fallback); ?>
		<?php if ( $over_content ): ?>
		<div id="hero-wrapper" class="vertical-align">
			<div id="hero-content" class="vertical-box">
				<?php if ( $title ): ?>
				<h1 class="entry-title"><span><?php echo $title ?></span></h1>
				<?php endif; ?>
				<?php if ( $subtitle ): ?>
				<div class="entry-subtitle h3"><?php echo $subtitle ?></div>
				<?php endif; ?>
			</div>
		</div>
		<?php endif; ?>
	</div>
	<?php
}
add_action( 'hb_after_header', 'hb_site_banner', 5 );


/**
 * Custom page navigation function
 *
 * @return null | string
 **/
function hb_page_navigation(){

	$id = hb_get_page_ID();

	if ( ( !is_home() && !is_page() ) || !$custom_navigation = get_post_meta($id, 'page_custom_navigation', true) ){

		return;
	}

	?>
	<nav id="secondary-navigation" class="site-navigation" role="navigation">
		<?php wp_nav_menu( array( 'menu' => $custom_navigation, 'menu_class' => 'nav-menu', 'depth' => 1 ) ); ?>
	</nav>
	<?php
}
add_action( 'hb_after_header', 'hb_page_navigation', 10 );

/**
 *
 * Defult paralax image banner
 *
 */
function hb_banner_default_action() {

	echo '<div id="hb-banner-img" data-100-top="-webkit-transform: translateY(-7em);transform: translateY(-7em);" data-top-bottom="-webkit-transform: translateY(0em);transform: translateY(0em);"></div>';
}
add_action('hb_banner_default', 'hb_banner_default_action');

/**
 *
 * Defult paralax image banner
 *
 */
function hb_banner_slider_action() {

    $args  = array( 
        'post_type'         => 'slide', 
        'posts_per_page'    => 6 
    );

    $loop  = new WP_Query( $args );

    if ( $loop->have_posts() ):

    	echo '<div id="banner-slider" class="owl-carousel" data-100-top="-webkit-transform: translateY(-7em);transform: translateY(-7em);" data-top-bottom="-webkit-transform: translateY(0em);transform: translateY(0em);">';

	    while ( $loop->have_posts() ) : $loop->the_post();

	    	echo '<div class="item">';
				if ( has_post_thumbnail() ){
				$img = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full');
				echo '<div class="slide-image" style="background-image: url('.esc_url(current($img)).')">';
					the_post_thumbnail('full', array('class'=>'slide-img says'));
				echo '</div>';	
				}

				if ( $overlay_color = sanitize_hex_color(get_post_meta(get_the_ID(), 'overlay_color', true)) ){
				$overlay_opacity = get_post_meta(get_the_ID(), 'overlay_opacity', true) / 100;
				echo sprintf('<div class="slide-overlay" style="background:%s;%s;"></div>',
						esc_attr($overlay_color),
						$overlay_opacity ? 'opacity:'.esc_attr($overlay_opacity) : ''
					);
				}

	    		// echo '<div class="circles-wrapper visible-lg-block">';
	    		// 	echo '<div class="container">';
	    		// 		echo '<span class="circles"></span>';
	    		// 	echo '</div>';
	    		// echo '</div>';

	    		echo '<div class="vertical-align">';
	    			echo '<div class="vertical-box">';
	    				echo '<div class="container">';
	    					echo '<div class="tabel">';
	    						echo '<div class="cell">';
	    							echo '<div class="slide-content">';
						    			the_title('<h1 style="color:'.sanitize_hex_color(get_post_meta(get_the_ID(), 'title_color', true)).';">', '</h1>');
						    			the_content();
						    		echo '</div>';
			    				echo '</div>';
			    			echo '</div>';
			    		echo '</div>';
			    	echo '</div>';
			    echo '</div>';
	    	echo '</div>';

	    endwhile;

	    echo '</div>';

    else:

		do_action('hb_banner_default');
		?>
		<div id="hero-wrapper" class="vertical-align">
			<div id="hero-content" class="vertical-box">
				<h1 class="entry-title"><span><?php echo get_option('blogdescription'); ?></span></h1>
			</div>
		</div>
		<?php

    endif;

	wp_reset_query();
}
add_action('hb_banner_slider', 'hb_banner_slider_action');

/**
 * Banner inline styles
 *
 * @return void
 * @author 
 **/
function hb_site_banner_inline_styles() {

	$css = '';

	if ( ot_get_option('promo') ){

		$css .= '#promo {';
    		$css .= 'color:'.sanitize_hex_color(ot_get_option('promo_color')).';';
    		$css .= 'background:'.sanitize_hex_color(ot_get_option('promo_bg')).';';
		$css .= '}';
	}

	if ( ( (is_single() && 'post' == get_post_type()) || is_page() ) && has_post_thumbnail( get_the_ID() ) ){

		$thumb = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'full' );

		$css .= '#hb-banner-img{';
			$css .= 'background-image:url(' . esc_url(current($thumb)) . ')';
		$css .= '}';
	}

	if ( empty($css) ) $css = '#love-you{position:absolute;}'; // fix pjax call

	wp_add_inline_style( 'SDG-style', $css );
}
add_action( 'wp_enqueue_scripts', 'hb_site_banner_inline_styles' );

/**
 *
 * Activated values which user might use
 *
 * @since Swiss Design Group 1.0
 *
 * @return string
 */
function hb_shortcode_active_option_values(){

	return apply_filters( 'hb_shortcode_active_option_values', array(
		'1',
		'true',
		'active',
		'yes',
		'on',
		'whatever',
		'yup',
	));
}

/**
 * Modify theme's body classes
 *
 * @return array
 **/
function hb_theme_body_class_filter( $classes ){

	$classes[] = ( ! apply_filters('hb_page_has_banner', true ))? 'page-no-banner' : 'page-has-banner';

	return $classes;
}
add_filter('body_class', 'hb_theme_body_class_filter');

/**
 * Add a `screen-reader-text` class to the search form's submit button.
 *
 * @since Swiss Design Group 1.0
 *
 * @param string $html Search form HTML.
 * @return string Modified search form HTML.
 */
function SDG_search_form_modify( $html ) {
	return str_replace( 'class="search-submit"', 'class="search-submit screen-reader-text"', $html );
}
add_filter( 'get_search_form', 'SDG_search_form_modify' );

/**
 * Implement the Custom Header feature.
 *
 * @since Swiss Design Group 1.0
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 *
 * @since Swiss Design Group 1.0
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Customizer additions.
 *
 * @since Swiss Design Group 1.0
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * WooCommerce actions and filters.
 *
 * @since Swiss Design Group 1.0
 */
if ( hb_is_plugin_active('woocommerce/woocommerce.php') ){
	require get_template_directory() . '/inc/woocommerce.php';
}


// Post Types
require get_template_directory()  . '/post-types/init.php';

// Shortcodes
require get_template_directory() . '/shortcodes/shortcode-functions.php';



if(!function_exists('sanitize_hex_color')){
	function sanitize_hex_color( $color ) {
	    if ( '' === $color )
	        return '';
	 
	    // 3 or 6 hex digits, or the empty string.
	    if ( preg_match('|^#([A-Fa-f0-9]{3}){1,2}$|', $color ) )
	        return $color;
	}
}

function hb_site_promo(){

	get_template_part( 'content', 'promo' );
}
add_action('hb_before_page_content', 'hb_site_promo', 5);

//acf plugin add options page...
require_once('inc/acf.php');
