<div class="front_page_section front_page_section_testimonials<?php
			$smart_casa_scheme = smart_casa_get_theme_option('front_page_testimonials_scheme');
			if (!smart_casa_is_inherit($smart_casa_scheme)) echo ' scheme_'.esc_attr($smart_casa_scheme);
			echo ' front_page_section_paddings_'.esc_attr(smart_casa_get_theme_option('front_page_testimonials_paddings'));
		?>"<?php
		$smart_casa_css = '';
		$smart_casa_bg_image = smart_casa_get_theme_option('front_page_testimonials_bg_image');
		if (!empty($smart_casa_bg_image)) 
			$smart_casa_css .= 'background-image: url('.esc_url(smart_casa_get_attachment_url($smart_casa_bg_image)).');';
		if (!empty($smart_casa_css))
			echo ' style="' . esc_attr($smart_casa_css) . '"';
?>><?php
	// Add anchor
	$smart_casa_anchor_icon = smart_casa_get_theme_option('front_page_testimonials_anchor_icon');	
	$smart_casa_anchor_text = smart_casa_get_theme_option('front_page_testimonials_anchor_text');	
	if ((!empty($smart_casa_anchor_icon) || !empty($smart_casa_anchor_text)) && shortcode_exists('trx_sc_anchor')) {
		echo do_shortcode('[trx_sc_anchor id="front_page_section_testimonials"'
										. (!empty($smart_casa_anchor_icon) ? ' icon="'.esc_attr($smart_casa_anchor_icon).'"' : '')
										. (!empty($smart_casa_anchor_text) ? ' title="'.esc_attr($smart_casa_anchor_text).'"' : '')
										. ']');
	}
	?>
	<div class="front_page_section_inner front_page_section_testimonials_inner<?php
			if (smart_casa_get_theme_option('front_page_testimonials_fullheight'))
				echo ' smart_casa-full-height sc_layouts_flex sc_layouts_columns_middle';
			?>"<?php
			$smart_casa_css = '';
			$smart_casa_bg_mask = smart_casa_get_theme_option('front_page_testimonials_bg_mask');
			$smart_casa_bg_color = smart_casa_get_theme_option('front_page_testimonials_bg_color');
			if (!empty($smart_casa_bg_color) && $smart_casa_bg_mask > 0)
				$smart_casa_css .= 'background-color: '.esc_attr($smart_casa_bg_mask==1
																	? $smart_casa_bg_color
																	: smart_casa_hex2rgba($smart_casa_bg_color, $smart_casa_bg_mask)
																).';';
			if (!empty($smart_casa_css))
				echo ' style="' . esc_attr($smart_casa_css) . '"';
	?>>
		<div class="front_page_section_content_wrap front_page_section_testimonials_content_wrap content_wrap">
			<?php
			// Caption
			$smart_casa_caption = smart_casa_get_theme_option('front_page_testimonials_caption');
			if (!empty($smart_casa_caption) || (current_user_can('edit_theme_options') && is_customize_preview())) {
				?><h2 class="front_page_section_caption front_page_section_testimonials_caption front_page_block_<?php echo !empty($smart_casa_caption) ? 'filled' : 'empty'; ?>"><?php echo wp_kses($smart_casa_caption, 'smart_casa_kses_content'); ?></h2><?php
			}
		
			// Description (text)
			$smart_casa_description = smart_casa_get_theme_option('front_page_testimonials_description');
			if (!empty($smart_casa_description) || (current_user_can('edit_theme_options') && is_customize_preview())) {
				?><div class="front_page_section_description front_page_section_testimonials_description front_page_block_<?php echo !empty($smart_casa_description) ? 'filled' : 'empty'; ?>"><?php echo wp_kses(wpautop($smart_casa_description), 'smart_casa_kses_content'); ?></div><?php
			}
		
			// Content (widgets)
			?><div class="front_page_section_output front_page_section_testimonials_output"><?php 
				if (is_active_sidebar('front_page_testimonials_widgets')) {
					dynamic_sidebar( 'front_page_testimonials_widgets' );
				} else if (current_user_can( 'edit_theme_options' )) {
					if (!smart_casa_exists_trx_addons())
						smart_casa_customizer_need_trx_addons_message();
					else
						smart_casa_customizer_need_widgets_message('front_page_testimonials_caption', 'ThemeREX Addons - Testimonials');
				}
			?></div>
		</div>
	</div>
</div>