<?php
/* Revolution Slider support functions
------------------------------------------------------------------------------- */

// Theme init priorities:
// 9 - register other filters (for installer, etc.)
if (!function_exists('smart_casa_revslider_theme_setup9')) {
	add_action( 'after_setup_theme', 'smart_casa_revslider_theme_setup9', 9 );
	function smart_casa_revslider_theme_setup9() {

		add_filter( 'smart_casa_filter_merge_styles',				'smart_casa_revslider_merge_styles' );
		
		if (is_admin()) {
			add_filter( 'smart_casa_filter_tgmpa_required_plugins','smart_casa_revslider_tgmpa_required_plugins' );
		}
	}
}

// Filter to add in the required plugins list
if ( !function_exists( 'smart_casa_revslider_tgmpa_required_plugins' ) ) {
	function smart_casa_revslider_tgmpa_required_plugins($list=array()) {
		if (smart_casa_storage_isset('required_plugins', 'revslider')) {
			$path = smart_casa_get_file_dir('plugins/revslider/revslider.zip');
			if (!empty($path) || smart_casa_get_theme_setting('tgmpa_upload')) {
				$list[] = array(
					'name' 		=> smart_casa_storage_get_array('required_plugins', 'revslider'),
					'slug' 		=> 'revslider',
					'source'	=> !empty($path) ? $path : 'upload://revslider.zip',
					'version'   => '6.6.14',
					'required' 	=> false
				);
			}
		}
		return $list;
	}
}

// Check if RevSlider installed and activated
if ( !function_exists( 'smart_casa_exists_revslider' ) ) {
	function smart_casa_exists_revslider() {
		return function_exists('rev_slider_shortcode');
	}
}
	
// Merge custom styles
if ( !function_exists( 'smart_casa_revslider_merge_styles' ) ) {
	function smart_casa_revslider_merge_styles($list) {
		if (smart_casa_exists_revslider()) {
			$list[] = 'plugins/revslider/_revslider.scss';
		}
		return $list;
	}
}
?>