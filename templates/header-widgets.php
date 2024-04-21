<?php
/**
 * The template to display the widgets area in the header
 *
 * @package WordPress
 * @subpackage SMART_CASA
 * @since SMART_CASA 1.0
 */

// Header sidebar
$smart_casa_header_name = smart_casa_get_theme_option('header_widgets');
$smart_casa_header_present = !smart_casa_is_off($smart_casa_header_name) && is_active_sidebar($smart_casa_header_name);
if ($smart_casa_header_present) { 
	smart_casa_storage_set('current_sidebar', 'header');
	$smart_casa_header_wide = smart_casa_get_theme_option('header_wide');
	ob_start();
	if ( is_active_sidebar($smart_casa_header_name) ) {
		dynamic_sidebar($smart_casa_header_name);
	}
	$smart_casa_widgets_output = ob_get_contents();
	ob_end_clean();
	if (!empty($smart_casa_widgets_output)) {
		$smart_casa_widgets_output = preg_replace("/<\/aside>[\r\n\s]*<aside/", "</aside><aside", $smart_casa_widgets_output);
		$smart_casa_need_columns = strpos($smart_casa_widgets_output, 'columns_wrap')===false;
		if ($smart_casa_need_columns) {
			$smart_casa_columns = max(0, (int) smart_casa_get_theme_option('header_columns'));
			if ($smart_casa_columns == 0) $smart_casa_columns = min(6, max(1, substr_count($smart_casa_widgets_output, '<aside ')));
			if ($smart_casa_columns > 1)
				$smart_casa_widgets_output = preg_replace("/<aside([^>]*)class=\"widget/", "<aside$1class=\"column-1_".esc_attr($smart_casa_columns).' widget', $smart_casa_widgets_output);
			else
				$smart_casa_need_columns = false;
		}
		?>
		<div class="header_widgets_wrap widget_area<?php echo !empty($smart_casa_header_wide) ? ' header_fullwidth' : ' header_boxed'; ?>">
			<div class="header_widgets_inner widget_area_inner">
				<?php 
				if (!$smart_casa_header_wide) { 
					?><div class="content_wrap"><?php
				}
				if ($smart_casa_need_columns) {
					?><div class="columns_wrap"><?php
				}
				do_action( 'smart_casa_action_before_sidebar' );
				smart_casa_show_layout($smart_casa_widgets_output);
				do_action( 'smart_casa_action_after_sidebar' );
				if ($smart_casa_need_columns) {
					?></div>	<!-- /.columns_wrap --><?php
				}
				if (!$smart_casa_header_wide) {
					?></div>	<!-- /.content_wrap --><?php
				}
				?>
			</div>	<!-- /.header_widgets_inner -->
		</div>	<!-- /.header_widgets_wrap -->
		<?php
	}
}
?>