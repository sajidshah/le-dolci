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

	<div class="entry-content">
		<div class="container">

			<?php 
			$promo_boxes = get_post_meta(get_the_ID(), 'promo_boxes', true);
			if ( $promo_boxes ):
			?>
			<div class="row">
				<?php foreach ($promo_boxes as $box) : ?>
					<div class="col-sm-6 hb-animate-solo">
						<?php
						$label = '';
						$start = $end = 'div';
						if ( $box['link'] && $box['label'] ){

							$start 	= 'a href="' . esc_url( $box['link'] ) . '"';
							$end 	= 'a'; 
							$label  = '<strong>'. $box['label']  .'</strong>';
						}
						?>
						<<?php echo $start; ?> class="promo-box" style="color:<?php echo esc_attr($box['color']) ?>;background-image:url(<?php echo esc_url($box['img']); ?>)">
							<div class="promo-content">
								<h3 class="zigzag"><span><?php echo $box['title'] ?></span></h3>
								<p><?php echo strip_tags($box['desc']); ?></p>
								<?php echo $label; ?>
							</div>
						</<?php echo $end; ?>>
					</div>
				<?php endforeach; ?>
			</div>
			<?php endif; ?>

		</div>
	</div>

	<div class="content-grid">
		<div class="container">
			<div class="row">
				<div class="col-xs-12">
				<?php
				$grid = get_post_meta(get_the_ID(), 'grid', true);

				$grid = $grid ? json_decode($grid, true) : false;

				if ( $grid ):

					echo '<div class="hb-grid hb-animate-group hb-grid-gutter clearfix">';
						foreach ($grid as $item) {

							// Box Classes
							$classes= array(
								'hb-box-wrapp',
								'hb-animate'
							);

							$classes[] = 'hb-box-w-' . $item['width'];

							$classes[] = 'hb-box-h-' . $item['height']; 

							// Box Styles
							$styles = array();

							if ( $item['image'] )
								$styles[] = 'background-image:url(' . esc_url($item['image']) . ')';

							$styles  = ! empty($styles) ? ' style="'. esc_attr( implode(';', $styles) ) .'"' : '';

							$title   = ! empty($item['title']) ? '<h3 class="hb-box-title">'. $item['title'] .'</h3>' : '';
							echo '
							<div class="', esc_attr( implode(' ', $classes) ) ,'">
								<div class="hb-box"', $styles ,'>',
									'<div class="hb-box-content">',
										'<div class="hb-box-content-inner">',
											'<div class="vertical-align">',
												'<div class="vertical-box">',
													$title,
													do_shortcode($item['content']),
												'</div>
											</div>
										</div>
									</div>
								</div>
							</div>';

						}
					echo '</div>';
				else:

					the_content();
					wp_link_pages( array(
						'before'      => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', HB_DOMAIN_TXT ) . '</span>',
						'after'       => '</div>',
						'link_before' => '<span>',
						'link_after'  => '</span>',
						'pagelink'    => '<span class="screen-reader-text">' . __( 'Page', HB_DOMAIN_TXT ) . ' </span>%',
						'separator'   => '<span class="screen-reader-text">, </span>',
					) );
				endif;
				?>
				</div>
			</div>
		</div>
	</div>

</article>