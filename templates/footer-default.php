<?php
/**
 * The template to display default site footer
 *
 * @package WordPress
 * @subpackage SMART_CASA
 * @since SMART_CASA 1.0.10
 */

?>
<footer class="footer_wrap footer_default<?php
				if (!smart_casa_is_inherit(smart_casa_get_theme_option('footer_scheme')))
					echo ' scheme_' . esc_attr(smart_casa_get_theme_option('footer_scheme'));
				?>">
	<?php

	// Footer widgets area
	get_template_part( 'templates/footer-widgets' );

	// Logo
	get_template_part( 'templates/footer-logo' );

	// Socials
	get_template_part( 'templates/footer-socials' );

	// Copyright area
	get_template_part( 'templates/footer-copyright' );
	
	?>
</footer><!-- /.footer_wrap -->
