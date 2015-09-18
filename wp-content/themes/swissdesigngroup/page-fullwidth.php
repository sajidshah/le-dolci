<?php
/**
 * Template Name: Fullwidth
 *
 * @package WordPress
 * @subpackage Swiss_Design_Group
 * @since Swiss Design Group 1.0
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main hb-default-tmp" role="main">

			<div class="container">
				<?php
				// Start the loop.
				while ( have_posts() ) : the_post();

					// Include the page content template.
					get_template_part( 'content', 'fullwidth' );

				// End the loop.
				endwhile;
				?>
			</div>

		</main><!-- .site-main -->
	</div><!-- .content-area -->

<?php get_footer(); ?>
