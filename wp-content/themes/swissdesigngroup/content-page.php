<?php
/**
 * The template used for displaying page content
 *
 * @package WordPress
 * @subpackage Swiss_Design_Group
 * @since Swiss Design Group 1.0
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<header class="entry-header">
		<?php 

		if ( hb_is_plugin_active('woocommerce/woocommerce.php') && ( is_cart() || is_checkout() ) ){

			do_action('woocommerce_page_header_navigation');

		} else {

			the_title( '<h1 class="entry-title underline">', '</h1>' );
		}

		?>
	</header>

	<div class="entry-content">
		<?php the_content(); ?>
		<?php
			wp_link_pages( array(
				'before'      => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', HB_DOMAIN_TXT ) . '</span>',
				'after'       => '</div>',
				'link_before' => '<span>',
				'link_after'  => '</span>',
				'pagelink'    => '<span class="screen-reader-text">' . __( 'Page', HB_DOMAIN_TXT ) . ' </span>%',
				'separator'   => '<span class="screen-reader-text">, </span>',
			) );
		?>
	</div>

</article>