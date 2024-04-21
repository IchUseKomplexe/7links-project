<?php
/* Essential Grid support functions
------------------------------------------------------------------------------- */


// Theme init priorities:
// 9 - register other filters (for installer, etc.)
if (!function_exists('smart_casa_essential_grid_theme_setup9')) {
	add_action( 'after_setup_theme', 'smart_casa_essential_grid_theme_setup9', 9 );
	function smart_casa_essential_grid_theme_setup9() {
		
		add_filter( 'smart_casa_filter_merge_styles',						'smart_casa_essential_grid_merge_styles' );

		if (is_admin()) {
			add_filter( 'smart_casa_filter_tgmpa_required_plugins',		'smart_casa_essential_grid_tgmpa_required_plugins' );
		}
	}
}

// Filter to add in the required plugins list
if ( !function_exists( 'smart_casa_essential_grid_tgmpa_required_plugins' ) ) {
	function smart_casa_essential_grid_tgmpa_required_plugins($list=array()) {
		if (smart_casa_storage_isset('required_plugins', 'essential-grid')) {
			$path = smart_casa_get_file_dir('plugins/essential-grid/essential-grid.zip');
			if (!empty($path) || smart_casa_get_theme_setting('tgmpa_upload')) {
				$list[] = array(
						'name' 		=> smart_casa_storage_get_array('required_plugins', 'essential-grid'),
						'slug' 		=> 'essential-grid',
						'source'	=> !empty($path) ? $path : 'upload://essential-grid.zip',
						'version'   => '3.0.19',
						'required' 	=> false
				);
			}
		}
		return $list;
	}
}

// Check if plugin installed and activated
if ( !function_exists( 'smart_casa_exists_essential_grid' ) ) {
	function smart_casa_exists_essential_grid() {
        return defined( 'ESG_PLUGIN_PATH' ) || defined( 'EG_PLUGIN_PATH' );
	}
}
	
// Merge custom styles
if ( !function_exists( 'smart_casa_essential_grid_merge_styles' ) ) {
	function smart_casa_essential_grid_merge_styles($list) {
		if (smart_casa_exists_essential_grid()) {
			$list[] = 'plugins/essential-grid/_essential-grid.scss';
		}
		return $list;
	}
}
?>