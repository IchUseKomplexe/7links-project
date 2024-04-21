<?php
/**
 * The template to display default site footer
 *
 * @package WordPress
 * @subpackage SMART_CASA
 * @since SMART_CASA 1.0.10
 */

$smart_casa_footer_id = str_replace('footer-custom-', '', smart_casa_get_theme_option("footer_style"));
if ((int) $smart_casa_footer_id == 0) {
	$smart_casa_footer_id = smart_casa_get_post_id(array(
												'name' => $smart_casa_footer_id,
												'post_type' => defined('TRX_ADDONS_CPT_LAYOUTS_PT') ? TRX_ADDONS_CPT_LAYOUTS_PT : 'cpt_layouts'
												)
											);
} else {
	$smart_casa_footer_id = apply_filters('smart_casa_filter_get_translated_layout', $smart_casa_footer_id);
}
$smart_casa_footer_meta = get_post_meta($smart_casa_footer_id, 'trx_addons_options', true);
if (!empty($smart_casa_footer_meta['margin']) != '') 
	smart_casa_add_inline_css(sprintf('.page_content_wrap{padding-bottom:%s}', esc_attr(smart_casa_prepare_css_value($smart_casa_footer_meta['margin']))));
?>
<footer class="footer_wrap footer_custom footer_custom_<?php echo esc_attr($smart_casa_footer_id); 
						?> footer_custom_<?php echo esc_attr(sanitize_title(get_the_title($smart_casa_footer_id))); 
						if (!smart_casa_is_inherit(smart_casa_get_theme_option('footer_scheme')))
							echo ' scheme_' . esc_attr(smart_casa_get_theme_option('footer_scheme'));
						?>">
	<?php
    // Custom footer's layout
    do_action('smart_casa_action_show_layout', $smart_casa_footer_id);
	?>
</footer><!-- /.footer_wrap -->
