<?php
/**
 * The template to display the logo or the site name and the slogan in the Header
 *
 * @package WordPress
 * @subpackage SMART_CASA
 * @since SMART_CASA 1.0
 */

$smart_casa_args = get_query_var('smart_casa_logo_args');

// Site logo
$smart_casa_logo_type   = isset($smart_casa_args['type']) ? $smart_casa_args['type'] : '';
$smart_casa_logo_image  = smart_casa_get_logo_image($smart_casa_logo_type);
$smart_casa_logo_text   = smart_casa_is_on(smart_casa_get_theme_option('logo_text')) ? get_bloginfo( 'name' ) : '';
$smart_casa_logo_slogan = get_bloginfo( 'description', 'display' );
if (!empty($smart_casa_logo_image) || !empty($smart_casa_logo_text)) {
	?><a class="sc_layouts_logo" href="<?php echo esc_url(home_url('/')); ?>"><?php
		if (!empty($smart_casa_logo_image)) {
			if (empty($smart_casa_logo_type) && function_exists('the_custom_logo') && (is_numeric( $smart_logo_image ) && $smart_logo_image > 0)) {
				the_custom_logo();
			} else {
				$smart_casa_attr = smart_casa_getimagesize($smart_casa_logo_image);
				echo '<img src="'.esc_url($smart_casa_logo_image).'" alt="'.esc_attr($smart_casa_logo_text).'"'.(!empty($smart_casa_attr[3]) ? ' '.wp_kses_data($smart_casa_attr[3]) : '').'>';
			}
		} else {
			smart_casa_show_layout(smart_casa_prepare_macros($smart_casa_logo_text), '<span class="logo_text">', '</span>');
			smart_casa_show_layout(smart_casa_prepare_macros($smart_casa_logo_slogan), '<span class="logo_slogan">', '</span>');
		}
	?></a><?php
}
?>