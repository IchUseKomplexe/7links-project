<?php
/**
 * The template to show mobile menu
 *
 * @package WordPress
 * @subpackage SMART_CASA
 * @since SMART_CASA 1.0
 */
?>
<div class="menu_mobile_overlay"></div>
<div class="menu_mobile menu_mobile_<?php echo esc_attr(smart_casa_get_theme_option('menu_mobile_fullscreen') > 0 ? 'fullscreen' : 'narrow'); ?> scheme_dark">
	<div class="menu_mobile_inner">
		<a class="menu_mobile_close icon-cancel"></a><?php

		// Logo
		set_query_var('smart_casa_logo_args', array('type' => 'mobile'));
		get_template_part( 'templates/header-logo' );
		set_query_var('smart_casa_logo_args', array());

		// Mobile menu
		$smart_casa_menu_mobile = smart_casa_get_nav_menu('menu_mobile');
		if (empty($smart_casa_menu_mobile)) {
			$smart_casa_menu_mobile = apply_filters('smart_casa_filter_get_mobile_menu', '');
			if (empty($smart_casa_menu_mobile)) $smart_casa_menu_mobile = smart_casa_get_nav_menu('menu_main');
			if (empty($smart_casa_menu_mobile)) $smart_casa_menu_mobile = smart_casa_get_nav_menu();
		}
		if (!empty($smart_casa_menu_mobile)) {
			if (!empty($smart_casa_menu_mobile))
				$smart_casa_menu_mobile = str_replace(
					array('menu_main', 'id="menu-', 'sc_layouts_menu_nav', 'sc_layouts_hide_on_mobile', 'hide_on_mobile'),
					array('menu_mobile', 'id="menu_mobile-', '', '', ''),
					$smart_casa_menu_mobile
					);
			if (strpos($smart_casa_menu_mobile, '<nav ')===false)
				$smart_casa_menu_mobile = sprintf('<nav class="menu_mobile_nav_area">%s</nav>', $smart_casa_menu_mobile);
			smart_casa_show_layout(apply_filters('smart_casa_filter_menu_mobile_layout', $smart_casa_menu_mobile));
		}
		
		// Social icons
		smart_casa_show_layout(smart_casa_get_socials_links(), '<div class="socials_mobile">', '</div>');
		?>
	</div>
</div>
