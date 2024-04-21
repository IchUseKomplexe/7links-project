<?php
/* WP GDPR Compliance support functions
------------------------------------------------------------------------------- */

// Theme init priorities:
// 9 - register other filters (for installer, etc.)
if ( ! function_exists( 'smart_casa_wp_gdpr_compliance_theme_setup9' ) ) {
	add_action( 'after_setup_theme', 'smart_casa_wp_gdpr_compliance_theme_setup9', 9 );
	function smart_casa_wp_gdpr_compliance_theme_setup9() {
		if ( is_admin() ) {
			add_filter( 'smart_casa_filter_tgmpa_required_plugins', 'smart_casa_wp_gdpr_compliance_tgmpa_required_plugins' );
		}
	}
}

// Filter to add in the required plugins list
if ( !function_exists( 'smart_casa_wp_gdpr_compliance_tgmpa_required_plugins' ) ) {
	function smart_casa_wp_gdpr_compliance_tgmpa_required_plugins($list=array()) {
		if (smart_casa_storage_isset('required_plugins', 'wp-gdpr-compliance')) {
			$list[] = array(
				'name' 		=> smart_casa_storage_get_array('required_plugins', 'wp-gdpr-compliance'),
				'slug' 		=> 'wp-gdpr-compliance',
				'required' 	=> false
			);
		}
		return $list;
	}
}

// Check if this plugin installed and activated
if ( ! function_exists( 'smart_casa_exists_wp_gdpr_compliance' ) ) {
	function smart_casa_exists_wp_gdpr_compliance() {
		return defined( 'WP_GDPR_C_ROOT_FILE' ) || defined( 'WPGDPRC_ROOT_FILE' );
	}
}
