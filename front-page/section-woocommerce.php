<div class="front_page_section front_page_section_woocommerce<?php
			$smart_casa_scheme = smart_casa_get_theme_option('front_page_woocommerce_scheme');
			if (!smart_casa_is_inherit($smart_casa_scheme)) echo ' scheme_'.esc_attr($smart_casa_scheme);
			echo ' front_page_section_paddings_'.esc_attr(smart_casa_get_theme_option('front_page_woocommerce_paddings'));
		?>"<?php
		$smart_casa_css = '';
		$smart_casa_bg_image = smart_casa_get_theme_option('front_page_woocommerce_bg_image');
		if (!empty($smart_casa_bg_image)) 
			$smart_casa_css .= 'background-image: url('.esc_url(smart_casa_get_attachment_url($smart_casa_bg_image)).');';
		if (!empty($smart_casa_css))
			echo ' style="' . esc_attr($smart_casa_css) . '"';
?>><?php
	// Add anchor
	$smart_casa_anchor_icon = smart_casa_get_theme_option('front_page_woocommerce_anchor_icon');	
	$smart_casa_anchor_text = smart_casa_get_theme_option('front_page_woocommerce_anchor_text');	
	if ((!empty($smart_casa_anchor_icon) || !empty($smart_casa_anchor_text)) && shortcode_exists('trx_sc_anchor')) {
		echo do_shortcode('[trx_sc_anchor id="front_page_section_woocommerce"'
										. (!empty($smart_casa_anchor_icon) ? ' icon="'.esc_attr($smart_casa_anchor_icon).'"' : '')
										. (!empty($smart_casa_anchor_text) ? ' title="'.esc_attr($smart_casa_anchor_text).'"' : '')
										. ']');
	}
	?>
	<div class="front_page_section_inner front_page_section_woocommerce_inner<?php
			if (smart_casa_get_theme_option('front_page_woocommerce_fullheight'))
				echo ' smart_casa-full-height sc_layouts_flex sc_layouts_columns_middle';
			?>"<?php
			$smart_casa_css = '';
			$smart_casa_bg_mask = smart_casa_get_theme_option('front_page_woocommerce_bg_mask');
			$smart_casa_bg_color = smart_casa_get_theme_option('front_page_woocommerce_bg_color');
			if (!empty($smart_casa_bg_color) && $smart_casa_bg_mask > 0)
				$smart_casa_css .= 'background-color: '.esc_attr($smart_casa_bg_mask==1
																	? $smart_casa_bg_color
																	: smart_casa_hex2rgba($smart_casa_bg_color, $smart_casa_bg_mask)
																).';';
			if (!empty($smart_casa_css))
				echo ' style="' . esc_attr($smart_casa_css) . '"';
	?>>
		<div class="front_page_section_content_wrap front_page_section_woocommerce_content_wrap content_wrap woocommerce">
			<?php
			// Content wrap with title and description
			$smart_casa_caption = smart_casa_get_theme_option('front_page_woocommerce_caption');
			$smart_casa_description = smart_casa_get_theme_option('front_page_woocommerce_description');
			if (!empty($smart_casa_caption) || !empty($smart_casa_description) || (current_user_can('edit_theme_options') && is_customize_preview())) {
				// Caption
				if (!empty($smart_casa_caption) || (current_user_can('edit_theme_options') && is_customize_preview())) {
					?><h2 class="front_page_section_caption front_page_section_woocommerce_caption front_page_block_<?php echo !empty($smart_casa_caption) ? 'filled' : 'empty'; ?>"><?php
						echo wp_kses($smart_casa_caption, 'smart_casa_kses_content');
					?></h2><?php
				}
			
				// Description (text)
				if (!empty($smart_casa_description) || (current_user_can('edit_theme_options') && is_customize_preview())) {
					?><div class="front_page_section_description front_page_section_woocommerce_description front_page_block_<?php echo !empty($smart_casa_description) ? 'filled' : 'empty'; ?>"><?php
						echo wp_kses(wpautop($smart_casa_description), 'smart_casa_kses_content');
					?></div><?php
				}
			}
		
			// Content (widgets)
			?><div class="front_page_section_output front_page_section_woocommerce_output list_products shop_mode_thumbs"><?php 
				$smart_casa_woocommerce_sc = smart_casa_get_theme_option('front_page_woocommerce_products');
				if ($smart_casa_woocommerce_sc == 'products') {
					$smart_casa_woocommerce_sc_ids = smart_casa_get_theme_option('front_page_woocommerce_products_per_page');
					$smart_casa_woocommerce_sc_per_page = count(explode(',', $smart_casa_woocommerce_sc_ids));
				} else {
					$smart_casa_woocommerce_sc_per_page = max(1, (int) smart_casa_get_theme_option('front_page_woocommerce_products_per_page'));
				}
				$smart_casa_woocommerce_sc_columns = max(1, min($smart_casa_woocommerce_sc_per_page, (int) smart_casa_get_theme_option('front_page_woocommerce_products_columns')));
				echo do_shortcode("[{$smart_casa_woocommerce_sc}"
									. ($smart_casa_woocommerce_sc == 'products' 
											? ' ids="'.esc_attr($smart_casa_woocommerce_sc_ids).'"' 
											: '')
									. ($smart_casa_woocommerce_sc == 'product_category' 
											? ' category="'.esc_attr(smart_casa_get_theme_option('front_page_woocommerce_products_categories')).'"' 
											: '')
									. ($smart_casa_woocommerce_sc != 'best_selling_products' 
											? ' orderby="'.esc_attr(smart_casa_get_theme_option('front_page_woocommerce_products_orderby')).'"'
											  . ' order="'.esc_attr(smart_casa_get_theme_option('front_page_woocommerce_products_order')).'"' 
											: '')
									. ' per_page="'.esc_attr($smart_casa_woocommerce_sc_per_page).'"' 
									. ' columns="'.esc_attr($smart_casa_woocommerce_sc_columns).'"' 
									. ']');
			?></div>
		</div>
	</div>
</div>