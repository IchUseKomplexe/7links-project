<?php
/* Date Time Picker Field support functions
------------------------------------------------------------------------------- */
// Theme init priorities:
// 9 - register other filters (for installer, etc.)
if ( ! function_exists( 'smart_casa_date_time_picker_field_theme_setup9' ) ) {
    add_action( 'after_setup_theme', 'smart_casa_date_time_picker_field_theme_setup9', 9 );
    function smart_casa_date_time_picker_field_theme_setup9() {

        if ( is_admin() ) {
            add_filter( 'smart_casa_filter_tgmpa_required_plugins', 'smart_casa_date_time_picker_field_tgmpa_required_plugins' );
        }
    }
}

// Filter to add in the required plugins list
if ( ! function_exists( 'smart_casa_date_time_picker_field_tgmpa_required_plugins' ) ) {
    function smart_casa_date_time_picker_field_tgmpa_required_plugins( $list = array() ) {
        if (smart_casa_storage_isset('required_plugins', 'date-time-picker-field')) {
            $list[] = array(
                'name' 		=> esc_html__('Date Time Picker Field', 'smart-casa'),
                'slug'     => 'date-time-picker-field',
                'required' => false,
            );
        }
        return $list;
    }
}
// Set plugin's specific importer options
if ( !function_exists( 'smart_casa_date_time_picker_field_importer_set_options' ) ) {
    add_filter( 'trx_addons_filter_importer_options',	'smart_casa_date_time_picker_field_importer_set_options' );
    function smart_casa_date_time_picker_field_importer_set_options($options=array()) {
        if (is_array($options)) {
            $options['additional_options'][] = 'dtpicker';
        }
        return $options;
    }
}