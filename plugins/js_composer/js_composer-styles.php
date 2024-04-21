<?php
// Add plugin-specific colors and fonts to the custom CSS
if ( !function_exists( 'smart_casa_vc_get_css' ) ) {
	add_filter( 'smart_casa_filter_get_css', 'smart_casa_vc_get_css', 10, 2 );
	function smart_casa_vc_get_css($css, $args) {

		if (isset($css['fonts']) && isset($args['fonts'])) {
			$fonts = $args['fonts'];
			$css['fonts'] .= <<<CSS
.vc_tta.vc_tta-accordion .vc_tta-panel-title .vc_tta-title-text {
	{$fonts['p_font-family']}
}
.vc_progress_bar.vc_progress_bar_narrow .vc_single_bar .vc_label .vc_label_units {
	{$fonts['info_font-family']}
}

CSS;
		}

		if (isset($css['colors']) && isset($args['colors'])) {
			$colors = $args['colors'];
			$css['colors'] .= <<<CSS

/* Row and columns */
.scheme_self.vc_section,
.scheme_self.wpb_row,
.scheme_self.wpb_column > .vc_column-inner > .wpb_wrapper,
.scheme_self.wpb_text_column {
	color: {$colors['text']};
}



/* Shape above and below rows */
.vc_shape_divider .vc-shape-fill {
	fill: {$colors['bg_color']};
}

/* Accordion */
.vc_tta.vc_tta-accordion .vc_tta-panel-heading .vc_tta-controls-icon {
	color: {$colors['inverse_link']};
	background-color: {$colors['text_dark']};
}
.vc_tta.vc_tta-accordion .vc_tta-panel-heading .vc_tta-controls-icon:before,
.vc_tta.vc_tta-accordion .vc_tta-panel-heading .vc_tta-controls-icon:after {
	border-color: {$colors['inverse_link']};
}
.vc_tta-color-grey.vc_tta-style-classic .vc_tta-panel .vc_tta-panel-title > a {
	color: {$colors['text_dark']};
}
.vc_tta-color-grey.vc_tta-style-classic .vc_tta-panel.vc_active .vc_tta-panel-title > a,
.vc_tta-color-grey.vc_tta-style-classic .vc_tta-panel .vc_tta-panel-title > a:hover {
	color: {$colors['text_link']};
}
.vc_tta-color-grey.vc_tta-style-classic .vc_tta-panel.vc_active .vc_tta-panel-title > a .vc_tta-controls-icon,
.vc_tta-color-grey.vc_tta-style-classic .vc_tta-panel .vc_tta-panel-title > a:hover .vc_tta-controls-icon {
	color: {$colors['inverse_link']};
	background-color: {$colors['text_link']};
}
.vc_tta-color-grey.vc_tta-style-classic .vc_tta-panel.vc_active .vc_tta-panel-title > a .vc_tta-controls-icon:before,
.vc_tta-color-grey.vc_tta-style-classic .vc_tta-panel.vc_active .vc_tta-panel-title > a .vc_tta-controls-icon:after {
	border-color: {$colors['inverse_link']};
}

/* Tabs */
.vc_tta-color-grey.vc_tta-style-classic .vc_tta-tabs-list .vc_tta-tab > a {
	color: {$colors['inverse_link']};
	background-color: {$colors['text_dark']};
}
.vc_tta-color-grey.vc_tta-style-classic .vc_tta-tabs-list .vc_tta-tab > a:hover,
.vc_tta-color-grey.vc_tta-style-classic .vc_tta-tabs-list .vc_tta-tab.vc_active > a {
	color: {$colors['inverse_hover']};
	background-color: {$colors['text_link']};
}

/* Separator */
.vc_separator.vc_sep_color_grey .vc_sep_line {
	border-color: {$colors['bd_color']};
}

/* Progress bar */
.vc_progress_bar.vc_progress_bar_narrow .vc_single_bar {
	background-color: {$colors['alter_bg_color']};
}
.vc_progress_bar.vc_progress_bar_narrow.vc_progress-bar-color-bar_red .vc_single_bar .vc_bar {
	background-color: {$colors['alter_link']};
}
.vc_progress_bar.vc_progress_bar_narrow .vc_single_bar .vc_label {
	color: {$colors['text']};
}
.vc_progress_bar.vc_progress_bar_narrow .vc_single_bar .vc_label .vc_label_units {
	color: {$colors['text']};
}
/* FAQ */

.vc_toggle_size_md.vc_toggle_round .vc_toggle_content {
    color: {$colors['text_dark']};
}
.vc_toggle_round.vc_toggle_size_md  {
    border-color: {$colors['text_dark_04']};
}
.vc_toggle_round.vc_toggle_color_inverted .vc_toggle_icon {
    border-color: {$colors['extra_hover']};
}
.vc_toggle_round.vc_toggle_color_inverted .vc_toggle_title:hover .vc_toggle_icon {
    border-color: {$colors['text_hover']};
}
.vc_toggle_round.vc_toggle_color_inverted .vc_toggle_icon:hover {
    border-color: {$colors['text_hover']};
}
.vc_toggle_round.vc_toggle_color_inverted .vc_toggle_icon::after,
.vc_toggle_round.vc_toggle_color_inverted .vc_toggle_icon::before {
    background-color: {$colors['extra_hover']};
 }
.vc_toggle_round.vc_toggle_color_inverted .vc_toggle_title:hover .vc_toggle_icon::after,
.vc_toggle_round.vc_toggle_color_inverted .vc_toggle_title:hover .vc_toggle_icon::before {
    background-color: {$colors['text_hover']};
}
.vc_toggle_round.vc_toggle_color_inverted .vc_toggle_icon:hover:after,
.vc_toggle_round.vc_toggle_color_inverted .vc_toggle_icon:hover:before {
    background-color: {$colors['text_hover']};
}


CSS;
		}
		
		return $css;
	}
}
?>