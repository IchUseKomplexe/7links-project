<?php
/* Contact Form 7 support functions
------------------------------------------------------------------------------- */

// Theme init priorities:
// 9 - register other filters (for installer, etc.)
if (!function_exists('smart_casa_cf7_theme_setup9')) {
	add_action( 'after_setup_theme', 'smart_casa_cf7_theme_setup9', 9 );
	function smart_casa_cf7_theme_setup9() {
		
		add_filter( 'smart_casa_filter_merge_styles',	'smart_casa_cf7_merge_styles' );

		if (smart_casa_exists_cf7()) {
			add_action( 'wp_enqueue_scripts',		'smart_casa_cf7_frontend_scripts', 1100 );
			add_filter('wpcf7_autop_or_not',        'smart_casa_cf7_wpcf7_autop');
		}
		
		if (is_admin()) {
			add_filter( 'smart_casa_filter_tgmpa_required_plugins',	'smart_casa_cf7_tgmpa_required_plugins' );
		}
	}
}

// Filter to add in the required plugins list
if ( !function_exists( 'smart_casa_cf7_tgmpa_required_plugins' ) ) {
	function smart_casa_cf7_tgmpa_required_plugins($list=array()) {
		if (smart_casa_storage_isset('required_plugins', 'contact-form-7')) {
			// CF7 plugin
			$list[] = array(
					'name' 		=> smart_casa_storage_get_array('required_plugins', 'contact-form-7'),
					'slug' 		=> 'contact-form-7',
					'required' 	=> false
			);
		}
		return $list;
	}
}



// Check if cf7 installed and activated
if ( !function_exists( 'smart_casa_exists_cf7' ) ) {
	function smart_casa_exists_cf7() {
		return class_exists('WPCF7');
	}
}

// Remove <p> and <br/> from Contact Form 7
if ( ! function_exists( 'smart_casa_cf7_wpcf7_autop' ) ) {
	function smart_casa_cf7_wpcf7_autop() {
		return false;
	}
}

// Enqueue custom scripts
if ( !function_exists( 'smart_casa_cf7_frontend_scripts' ) ) {
	function smart_casa_cf7_frontend_scripts() {
		if (smart_casa_exists_cf7()) {
			if (smart_casa_is_on(smart_casa_get_theme_option('debug_mode')) && ($smart_casa_url = smart_casa_get_file_url('plugins/contact-form-7/contact-form-7.js')) != '')
				wp_enqueue_script( 'cf7', $smart_casa_url, array('jquery'), null, true );
		}
	}
}

// Merge custom styles
if ( !function_exists( 'smart_casa_cf7_merge_styles' ) ) {
	function smart_casa_cf7_merge_styles($list) {
		if (smart_casa_exists_cf7()) {
			$list[] = 'plugins/contact-form-7/_contact-form-7.scss';
		}
		return $list;
	}
}
?>