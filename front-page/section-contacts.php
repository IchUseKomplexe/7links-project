<div class="front_page_section front_page_section_contacts<?php
			$smart_casa_scheme = smart_casa_get_theme_option('front_page_contacts_scheme');
			if (!smart_casa_is_inherit($smart_casa_scheme)) echo ' scheme_'.esc_attr($smart_casa_scheme);
			echo ' front_page_section_paddings_'.esc_attr(smart_casa_get_theme_option('front_page_contacts_paddings'));
		?>"<?php
		$smart_casa_css = '';
		$smart_casa_bg_image = smart_casa_get_theme_option('front_page_contacts_bg_image');
		if (!empty($smart_casa_bg_image)) 
			$smart_casa_css .= 'background-image: url('.esc_url(smart_casa_get_attachment_url($smart_casa_bg_image)).');';
		if (!empty($smart_casa_css))
			echo ' style="' . esc_attr($smart_casa_css) . '"';
?>><?php
	// Add anchor
	$smart_casa_anchor_icon = smart_casa_get_theme_option('front_page_contacts_anchor_icon');	
	$smart_casa_anchor_text = smart_casa_get_theme_option('front_page_contacts_anchor_text');	
	if ((!empty($smart_casa_anchor_icon) || !empty($smart_casa_anchor_text)) && shortcode_exists('trx_sc_anchor')) {
		echo do_shortcode('[trx_sc_anchor id="front_page_section_contacts"'
										. (!empty($smart_casa_anchor_icon) ? ' icon="'.esc_attr($smart_casa_anchor_icon).'"' : '')
										. (!empty($smart_casa_anchor_text) ? ' title="'.esc_attr($smart_casa_anchor_text).'"' : '')
										. ']');
	}
	?>
	<div class="front_page_section_inner front_page_section_contacts_inner<?php
			if (smart_casa_get_theme_option('front_page_contacts_fullheight'))
				echo ' smart_casa-full-height sc_layouts_flex sc_layouts_columns_middle';
			?>"<?php
			$smart_casa_css = '';
			$smart_casa_bg_mask = smart_casa_get_theme_option('front_page_contacts_bg_mask');
			$smart_casa_bg_color = smart_casa_get_theme_option('front_page_contacts_bg_color');
			if (!empty($smart_casa_bg_color) && $smart_casa_bg_mask > 0)
				$smart_casa_css .= 'background-color: '.esc_attr($smart_casa_bg_mask==1
																	? $smart_casa_bg_color
																	: smart_casa_hex2rgba($smart_casa_bg_color, $smart_casa_bg_mask)
																).';';
			if (!empty($smart_casa_css))
				echo ' style="' . esc_attr($smart_casa_css) . '"';
	?>>
		<div class="front_page_section_content_wrap front_page_section_contacts_content_wrap content_wrap">
			<?php

			// Title and description
			$smart_casa_caption = smart_casa_get_theme_option('front_page_contacts_caption');
			$smart_casa_description = smart_casa_get_theme_option('front_page_contacts_description');
			if (!empty($smart_casa_caption) || !empty($smart_casa_description) || (current_user_can('edit_theme_options') && is_customize_preview())) {
				// Caption
				if (!empty($smart_casa_caption) || (current_user_can('edit_theme_options') && is_customize_preview())) {
					?><h2 class="front_page_section_caption front_page_section_contacts_caption front_page_block_<?php echo !empty($smart_casa_caption) ? 'filled' : 'empty'; ?>"><?php
						echo wp_kses($smart_casa_caption, 'smart_casa_kses_content');
					?></h2><?php
				}
			
				// Description
				if (!empty($smart_casa_description) || (current_user_can('edit_theme_options') && is_customize_preview())) {
					?><div class="front_page_section_description front_page_section_contacts_description front_page_block_<?php echo !empty($smart_casa_description) ? 'filled' : 'empty'; ?>"><?php
						echo wp_kses(wpautop($smart_casa_description), 'smart_casa_kses_content');
					?></div><?php
				}
			}

			// Content (text)
			$smart_casa_content = smart_casa_get_theme_option('front_page_contacts_content');
			$smart_casa_layout = smart_casa_get_theme_option('front_page_contacts_layout');
			if ($smart_casa_layout == 'columns' && (!empty($smart_casa_content) || (current_user_can('edit_theme_options') && is_customize_preview()))) {
				?><div class="front_page_section_columns front_page_section_contacts_columns columns_wrap">
					<div class="column-1_3">
				<?php
			}

			if ((!empty($smart_casa_content) || (current_user_can('edit_theme_options') && is_customize_preview()))) {
				?><div class="front_page_section_content front_page_section_contacts_content front_page_block_<?php echo !empty($smart_casa_content) ? 'filled' : 'empty'; ?>"><?php
					echo wp_kses($smart_casa_content, 'smart_casa_kses_content');
				?></div><?php
			}

			if ($smart_casa_layout == 'columns' && (!empty($smart_casa_content) || (current_user_can('edit_theme_options') && is_customize_preview()))) {
				?></div><div class="column-2_3"><?php
			}
		
			// Shortcode output
			$smart_casa_sc = smart_casa_get_theme_option('front_page_contacts_shortcode');
			if (!empty($smart_casa_sc) || (current_user_can('edit_theme_options') && is_customize_preview())) {
				?><div class="front_page_section_output front_page_section_contacts_output front_page_block_<?php echo !empty($smart_casa_sc) ? 'filled' : 'empty'; ?>"><?php
					smart_casa_show_layout(do_shortcode($smart_casa_sc));
				?></div><?php
			}

			if ($smart_casa_layout == 'columns' && (!empty($smart_casa_content) || (current_user_can('edit_theme_options') && is_customize_preview()))) {
				?></div></div><?php
			}
			?>			
		</div>
	</div>
</div>