<?php
/**
 * The template to display default site header
 *
 * @package WordPress
 * @subpackage SMART_CASA
 * @since SMART_CASA 1.0
 */

$smart_casa_header_css = '';
$smart_casa_header_image = get_header_image();
$smart_casa_header_video = smart_casa_get_header_video();
if (!empty($smart_casa_header_image) && smart_casa_trx_addons_featured_image_override(is_singular() || smart_casa_storage_isset('blog_archive') || is_category())) {
	$smart_casa_header_image = smart_casa_get_current_mode_image($smart_casa_header_image);
}

?><header class="top_panel top_panel_default<?php
					echo !empty($smart_casa_header_image) || !empty($smart_casa_header_video) ? ' with_bg_image' : ' without_bg_image';
					if ($smart_casa_header_video!='') echo ' with_bg_video';
					if ($smart_casa_header_image!='') echo ' '.esc_attr(smart_casa_add_inline_css_class('background-image: url('.esc_url($smart_casa_header_image).');'));
					if (is_single() && has_post_thumbnail()) echo ' with_featured_image';
					if (smart_casa_is_on(smart_casa_get_theme_option('header_fullheight'))) echo ' header_fullheight smart_casa-full-height';
					if (!smart_casa_is_inherit(smart_casa_get_theme_option('header_scheme')))
						echo ' scheme_' . esc_attr(smart_casa_get_theme_option('header_scheme'));
					?>"><?php

	// Background video
	if (!empty($smart_casa_header_video)) {
		get_template_part( 'templates/header-video' );
	}
	
	// Main menu
	if (smart_casa_get_theme_option("menu_style") == 'top') {
		get_template_part( 'templates/header-navi' );
	}

	// Mobile header
	if (smart_casa_is_on(smart_casa_get_theme_option("header_mobile_enabled"))) {
		get_template_part( 'templates/header-mobile' );
	}
	
	// Page title and breadcrumbs area
	get_template_part( 'templates/header-title');

	// Header widgets area
	get_template_part( 'templates/header-widgets' );

	// Display featured image in the header on the single posts
	// Comment next line to prevent show featured image in the header area
	// and display it in the post's content


?></header>