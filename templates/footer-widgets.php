<?php
/**
 * The template to display the widgets area in the footer
 *
 * @package WordPress
 * @subpackage SMART_CASA
 * @since SMART_CASA 1.0.10
 */

// Footer sidebar
$smart_casa_footer_name = smart_casa_get_theme_option('footer_widgets');
$smart_casa_footer_present = !smart_casa_is_off($smart_casa_footer_name) && is_active_sidebar($smart_casa_footer_name);
if ($smart_casa_footer_present) { 
	smart_casa_storage_set('current_sidebar', 'footer');
	$smart_casa_footer_wide = smart_casa_get_theme_option('footer_wide');
	ob_start();
	if ( is_active_sidebar($smart_casa_footer_name) ) {
		dynamic_sidebar($smart_casa_footer_name);
	}
	$smart_casa_out = trim(ob_get_contents());
	ob_end_clean();
	if (!empty($smart_casa_out)) {
		$smart_casa_out = preg_replace("/<\\/aside>[\r\n\s]*<aside/", "</aside><aside", $smart_casa_out);
		$smart_casa_need_columns = true;	
		if ($smart_casa_need_columns) {
			$smart_casa_columns = max(0, (int) smart_casa_get_theme_option('footer_columns'));
			if ($smart_casa_columns == 0) $smart_casa_columns = min(4, max(1, substr_count($smart_casa_out, '<aside ')));
			if ($smart_casa_columns > 1)
				$smart_casa_out = preg_replace("/<aside([^>]*)class=\"widget/", "<aside$1class=\"column-1_".esc_attr($smart_casa_columns).' widget', $smart_casa_out);
			else
				$smart_casa_need_columns = false;
		}
		?>
		<div class="footer_widgets_wrap widget_area<?php echo !empty($smart_casa_footer_wide) ? ' footer_fullwidth' : ''; ?> sc_layouts_row sc_layouts_row_type_normal">
			<div class="footer_widgets_inner widget_area_inner">
				<?php 
				if (!$smart_casa_footer_wide) { 
					?><div class="content_wrap"><?php
				}
				if ($smart_casa_need_columns) {
					?><div class="columns_wrap"><?php
				}
				do_action( 'smart_casa_action_before_sidebar' );
				smart_casa_show_layout($smart_casa_out);
				do_action( 'smart_casa_action_after_sidebar' );
				if ($smart_casa_need_columns) {
					?></div><!-- /.columns_wrap --><?php
				}
				if (!$smart_casa_footer_wide) {
					?></div><!-- /.content_wrap --><?php
				}
				?>
			</div><!-- /.footer_widgets_inner -->
		</div><!-- /.footer_widgets_wrap -->
		<?php
	}
}
?>