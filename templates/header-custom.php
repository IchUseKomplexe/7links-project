<?php
/**
 * The template to display custom header from the ThemeREX Addons Layouts
 *
 * @package WordPress
 * @subpackage SMART_CASA
 * @since SMART_CASA 1.0.06
 */

$smart_casa_header_css = '';
$smart_casa_header_image = get_header_image();
$smart_casa_header_video = smart_casa_get_header_video();
if (!empty($smart_casa_header_image) && smart_casa_trx_addons_featured_image_override(is_singular() || smart_casa_storage_isset('blog_archive') || is_category())) {
	$smart_casa_header_image = smart_casa_get_current_mode_image($smart_casa_header_image);
}

$smart_casa_header_id = str_replace('header-custom-', '', smart_casa_get_theme_option("header_style"));
if ((int) $smart_casa_header_id == 0) {
	$smart_casa_header_id = smart_casa_get_post_id(array(
												'name' => $smart_casa_header_id,
												'post_type' => defined('TRX_ADDONS_CPT_LAYOUTS_PT') ? TRX_ADDONS_CPT_LAYOUTS_PT : 'cpt_layouts'
												)
											);
} else {
	$smart_casa_header_id = apply_filters('smart_casa_filter_get_translated_layout', $smart_casa_header_id);
}
$smart_casa_header_meta = get_post_meta($smart_casa_header_id, 'trx_addons_options', true);
if (!empty($smart_casa_header_meta['margin']) != '') 
	smart_casa_add_inline_css(sprintf('.page_content_wrap{padding-top:%s}', esc_attr(smart_casa_prepare_css_value($smart_casa_header_meta['margin']))));

?><header class="top_panel top_panel_custom top_panel_custom_<?php echo esc_attr($smart_casa_header_id); 
				?> top_panel_custom_<?php echo esc_attr(sanitize_title(get_the_title($smart_casa_header_id)));
				echo !empty($smart_casa_header_image) || !empty($smart_casa_header_video) 
					? ' with_bg_image' 
					: ' without_bg_image';
				if ($smart_casa_header_video!='') 
					echo ' with_bg_video';
				if ($smart_casa_header_image!='') 
					echo ' '.esc_attr(smart_casa_add_inline_css_class('background-image: url('.esc_url($smart_casa_header_image).');'));
				if (is_single() && has_post_thumbnail()) 
					echo ' with_featured_image';
				if (smart_casa_is_on(smart_casa_get_theme_option('header_fullheight'))) 
					echo ' header_fullheight smart_casa-full-height';
				if (!smart_casa_is_inherit(smart_casa_get_theme_option('header_scheme')))
					echo ' scheme_' . esc_attr(smart_casa_get_theme_option('header_scheme'));
				?>"><?php

	// Background video
	if (!empty($smart_casa_header_video)) {
		get_template_part( 'templates/header-video' );
	}
		
	// Custom header's layout
	do_action('smart_casa_action_show_layout', $smart_casa_header_id);

	// Header widgets area
	get_template_part( 'templates/header-widgets' );
		
?></header>