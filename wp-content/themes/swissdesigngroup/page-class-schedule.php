<?php
/**
 * @package WordPress
 * @subpackage Swiss_Design_Group
 * @since Swiss Design Group 1.0
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

		<div id="ledolci-classes-wrapper" class="container wide-container">
			<div class="row hb-animate-group">
			<?php

			$args = array(
				'post_type' 		=> 'product',
				'post_status' 		=> array( 'publish' ),
				'posts_per_page' 	=> apply_filters('hb_class_per_page', 12),
				'meta_key'   		=> '_class_date',
				'orderby'    		=> 'meta_value',
				'order'      		=> 'ASC',
				'meta_query' 		=> array(
										array (
											'key' 		=> '_class_date',
											'value' 	=> date("Y-m-d"),
											'compare' 	=> '>='
											)
										),
										array (
											'key' 		=> '_virtual',
											'value' 	=> 'yes',
											'compare' 	=> 'IN'
											),
				);

			$loop = new WP_Query( $args );

			if ( $loop->have_posts() ) {

				$filters = array();

				// Start the loop.
				while ( $loop->have_posts() ) : $loop->the_post();

					echo '<div class="' . join( ' ', get_post_class( 'ledolci-classes col-xs-12 col-sm-6 col-md-4' ) ) . '">';
						wc_get_template_part( 'content', 'class' );
					echo '</div>';

				$terms = get_the_terms( $loop->ID, 'product_cat' );

				if ( $terms ){

					foreach ($terms as $term) {

						$filters[$term->slug] = $term->name;
					}
				}

				endwhile;

				if ( ! empty($filters) ){

					asort($filters);

					echo '<div id="class-filter-elements" class="says">';

						echo sprintf('<span>%s | <span class="filter-name">%s</span></span>', __('Filter classes', HB_DOMAIN_TXT), __('All', HB_DOMAIN_TXT));

						echo '<ul>';

							echo '<li><a href="#ledolci-classes">', __('All', HB_DOMAIN_TXT),'</a></li>';

							foreach ($filters as $key => $value) {
								echo '<li><a href="#', $key,'">', $value,'</a></li>';
							}

						echo '</ul>';

					echo '</div>';
				}

			} else {

				echo '<div class="col-xs-12">';
					get_template_part( 'content', 'none' );
				echo '</div>';
			}

			wp_reset_postdata();

			?>
			</div>
		</div>

		</main><!-- .site-main -->
	</div><!-- .content-area -->

<?php get_footer(); ?>
