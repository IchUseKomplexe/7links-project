<?php
/**
 * The Sidebar containing the main widget areas.
 *
 * @package WordPress
 * @subpackage SMART_CASA
 * @since SMART_CASA 1.0
 */

if (smart_casa_sidebar_present()) {
	ob_start();
	$smart_casa_sidebar_name = smart_casa_get_theme_option('sidebar_widgets');
	smart_casa_storage_set('current_sidebar', 'sidebar');
	if ( is_active_sidebar($smart_casa_sidebar_name) ) {
		dynamic_sidebar($smart_casa_sidebar_name);
	}
	$smart_casa_out = trim(ob_get_contents());
	ob_end_clean();
	if (!empty($smart_casa_out)) {
		$smart_casa_sidebar_position = smart_casa_get_theme_option('sidebar_position');
		?>
		<div class="sidebar <?php echo esc_attr($smart_casa_sidebar_position); ?> widget_area<?php if (!smart_casa_is_inherit(smart_casa_get_theme_option('sidebar_scheme'))) echo ' scheme_'.esc_attr(smart_casa_get_theme_option('sidebar_scheme')); ?>" role="complementary">
			<div class="sidebar_inner">
				<?php
				do_action( 'smart_casa_action_before_sidebar' );
				smart_casa_show_layout(preg_replace("/<\/aside>[\r\n\s]*<aside/", "</aside><aside", $smart_casa_out));
				do_action( 'smart_casa_action_after_sidebar' );
				?>
			</div><!-- /.sidebar_inner -->
		</div><!-- /.sidebar -->
		<?php
	}
}
?>