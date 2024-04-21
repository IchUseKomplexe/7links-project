<?php
/**
 * The template to display the copyright info in the footer
 *
 * @package WordPress
 * @subpackage SMART_CASA
 * @since SMART_CASA 1.0.10
 */

// Copyright area
?> 
<div class="footer_copyright_wrap<?php
				if (!smart_casa_is_inherit(smart_casa_get_theme_option('copyright_scheme')))
					echo ' scheme_' . esc_attr(smart_casa_get_theme_option('copyright_scheme'));
 				?>">
	<div class="footer_copyright_inner">
		<div class="content_wrap">
			<div class="copyright_text"><?php
				$smart_casa_copyright = smart_casa_get_theme_option('copyright');
				if (!empty($smart_casa_copyright)) {
					// Replace {{Y}} or {Y} with the current year
					$smart_casa_copyright = str_replace(array('{{Y}}', '{Y}'), date('Y'), $smart_casa_copyright);
					// Replace {{...}} and ((...)) on the <i>...</i> and <b>...</b>
					$smart_casa_copyright = smart_casa_prepare_macros($smart_casa_copyright);
					// Display copyright
					echo wp_kses(nl2br($smart_casa_copyright), 'smart_casa_kses_content');
				}
			?></div>
		</div>
	</div>
</div>
