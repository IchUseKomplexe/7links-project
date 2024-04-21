<?php
// Add plugin-specific colors and fonts to the custom CSS
if (!function_exists('smart_casa_mailchimp_get_css')) {
	add_filter('smart_casa_filter_get_css', 'smart_casa_mailchimp_get_css', 10, 2);
	function smart_casa_mailchimp_get_css($css, $args) {
		
		if (isset($css['fonts']) && isset($args['fonts'])) {
			$fonts = $args['fonts'];
			$css['fonts'] .= <<<CSS
form.mc4wp-form .mc4wp-form-fields input[type="email"] {
	{$fonts['input_font-family']}
	{$fonts['input_font-size']}
	{$fonts['input_font-weight']}
	{$fonts['input_font-style']}
	{$fonts['input_line-height']}
	{$fonts['input_text-decoration']}
	{$fonts['input_text-transform']}
	{$fonts['input_letter-spacing']}
}
form.mc4wp-form .mc4wp-form-fields input[type="submit"] {
	{$fonts['button_font-family']}
	{$fonts['button_font-size']}
	{$fonts['button_font-weight']}
	{$fonts['button_font-style']}
	{$fonts['button_line-height']}
	{$fonts['button_text-decoration']}
	{$fonts['button_text-transform']}
	{$fonts['button_letter-spacing']}
}
form.mc4wp-form .mc4wp-alert {
    {$fonts['button_font-family']}
}


CSS;
		}		

		if (isset($css['vars']) && isset($args['vars'])) {
			$vars = $args['vars'];
			
			$css['vars'] .= <<<CSS

form.mc4wp-form .mc4wp-form-fields input[type="email"],
form.mc4wp-form .mc4wp-form-fields input[type="submit"] {

}

CSS;
		}

		
		if (isset($css['colors']) && isset($args['colors'])) {
			$colors = $args['colors'];
			$css['colors'] .= <<<CSS

form.mc4wp-form .mc4wp-alert {
	background-color: {$colors['bg_color']};
	border-color: {$colors['text_hover']};
	color: {$colors['text']};
}
form.mc4wp-form .mc4wp-alert a {
    color: {$colors['text']};
}
form.mc4wp-form .mc4wp-alert a:hover {
    color: {$colors['text_hover']};
}

form.mc4wp-form .mc4wp-form-fields input[type="submit"]:disabled {
	background-color: {$colors['text_light']} !important;
    color: {$colors['text']} !important;
}

CSS;
		}

		return $css;
	}
}
?>