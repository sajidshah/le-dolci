<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the "site-content" div and all content after.
 *
 * @package WordPress
 * @subpackage Swiss_Design_Group
 * @since Swiss Design Group 1.0
 */
?>

	</div><!-- .site-content -->

	<footer id="colophon" class="site-footer" role="contentinfo">
		<div id="mailchimp-form">
			<div class="container">
				<?php echo do_shortcode('[mc4wp_form]'); ?>
			</div>
		</div>
		<div id="footer-nav">
			<div class="container">
				<div class="col-md-4 hidden-xs hidden-sm">
				<?php if ( has_nav_menu( 'footer_l' ) ) : ?>
					<nav id="footer-left-navigation" class="footer-navigation" role="navigation">
						<?php
							// Left footer navigation menu.
							wp_nav_menu( array(
								'theme_location' => 'footer_l',
								'depth'          => 1,
							) );
						?>
					</nav>
				<?php endif; ?>
				</div>
				<div class="col-md-3">
					<nav id="footer-social-navigation" class="social-navigation" role="navigation">
						<?php
							// Social navigation
							hb_socials();
						?>
					</nav>
				</div>
				<div class="col-md-4 hidden-xs hidden-sm">
				<?php if ( has_nav_menu( 'footer_r' ) ) : ?>
					<nav id="footer-right-navigation" class="footer-navigation" role="navigation">
						<?php
							// Left footer navigation menu.
							wp_nav_menu( array(
								'theme_location' => 'footer_r',
								'depth'          => 1,
							) );
						?>
					</nav>
				<?php endif; ?>
				</div>
			</div>
		</div>
	</footer>

	<?php 
	/**
	 * Hooked your actions and filter which goes after page and you dont want its content get refrush when user surf to the site.
	 */
	do_action('hb_after_page_content'); ?>

</div><!-- .site -->

<div id="wp-footer">
	<?php wp_footer(); ?>
</div>

</body>
</html>