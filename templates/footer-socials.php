<?php
/**
 * The template to display the socials in the footer
 *
 * @package WordPress
 * @subpackage SMART_CASA
 * @since SMART_CASA 1.0.10
 */


// Socials
if ( smart_casa_is_on(smart_casa_get_theme_option('socials_in_footer')) && ($smart_casa_output = smart_casa_get_socials_links()) != '') {
	?>
	<div class="footer_socials_wrap socials_wrap">
		<div class="footer_socials_inner">
			<?php smart_casa_show_layout($smart_casa_output); ?>
		</div>
	</div>
	<?php
}
?>