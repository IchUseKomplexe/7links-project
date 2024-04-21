<?php
/**
 * Admin utilities
 *
 * @package WordPress
 * @subpackage SMART_CASA
 * @since SMART_CASA 1.0.1
 */

// Disable direct call
if ( ! defined( 'ABSPATH' ) ) { exit; }


//-------------------------------------------------------
//-- Theme init
//-------------------------------------------------------

// Theme init priorities:
// 1 - register filters to add/remove lists items in the Theme Options
// 2 - create Theme Options
// 3 - add/remove Theme Options elements
// 5 - load Theme Options
// 9 - register other filters (for installer, etc.)
//10 - standard Theme init procedures (not ordered)

if ( !function_exists('smart_casa_admin_theme_setup') ) {
	add_action( 'after_setup_theme', 'smart_casa_admin_theme_setup' );
	function smart_casa_admin_theme_setup() {
		// Add theme icons
		add_action('admin_footer',	 						'smart_casa_admin_footer');

		// Enqueue scripts and styles for admin
		add_action("admin_enqueue_scripts",					'smart_casa_admin_scripts');
		add_action("admin_footer",							'smart_casa_admin_localize_scripts');
		
		// Show admin notice with control panel
		add_action('admin_notices',							'smart_casa_admin_notice');
		add_action('wp_ajax_smart_casa_hide_admin_notice',		'smart_casa_callback_hide_admin_notice');

		// Show admin notice with "Rate Us" panel
		add_action('after_switch_theme',					'smart_casa_save_activation_date');
		add_action('admin_notices',							'smart_casa_rate_notice');
		add_action('wp_ajax_smart_casa_hide_rate_notice',		'smart_casa_callback_hide_rate_notice');

		// TGM Activation plugin
		add_action('tgmpa_register',						'smart_casa_register_plugins');
	
		// Init internal admin messages
		smart_casa_init_admin_messages();
	}
}


//-------------------------------------------------------
//-- Welcome notice
//-------------------------------------------------------

// Show admin notice
if ( !function_exists( 'smart_casa_admin_notice' ) ) {
	
	function smart_casa_admin_notice() {
		if (in_array(smart_casa_get_value_gp('action'), array('vc_load_template_preview'))) return;
		if (smart_casa_get_value_gp('page') == 'smart_casa_about') return;
		if (!current_user_can('edit_theme_options')) return;
		$show = get_option('smart_casa_admin_notice');
		if ($show !== false && (int) $show == 0) return;
		get_template_part('templates/admin-notice');
	}
}

// Hide admin notice
if ( !function_exists( 'smart_casa_callback_hide_admin_notice' ) ) {
	
	function smart_casa_callback_hide_admin_notice() {
		update_option('smart_casa_admin_notice', '0');
		exit;
	}
}


//-------------------------------------------------------
//-- "Rate Us" notice
//-------------------------------------------------------

// Save activation date
if (!function_exists('smart_casa_save_activation_date')) {
	
	function smart_casa_save_activation_date() {
		$theme_time = (int) get_option( 'smart_casa_theme_activated' );
		if ($theme_time == 0) {
			$theme_slug = get_option( 'template' );
			$stylesheet_slug = get_option( 'stylesheet' );
			if ($theme_slug == $stylesheet_slug) {
				update_option('smart_casa_theme_activated', time());
			}
		}
	}
}

// Show Rate Us notice
if ( !function_exists( 'smart_casa_rate_notice' ) ) {
	
	function smart_casa_rate_notice() {
		if (in_array(smart_casa_get_value_gp('action'), array('vc_load_template_preview'))) return;
		if (!current_user_can('edit_theme_options')) return;
		// Display the message only on specified screens
		$allowed = array('dashboard', 'theme_options', 'trx_addons_options');
		$screen = function_exists('get_current_screen') ? get_current_screen() : false;
		if ( ( is_object($screen) && !empty($screen->id) && in_array($screen->id, $allowed) ) || in_array(smart_casa_get_value_gp('page'), $allowed) ) {
			$show = get_option('smart_casa_rate_notice');
			$start = get_option('smart_casa_theme_activated');
			if ( ($show !== false && (int) $show == 0) || ($start > 0 && (time()-$start)/(24*3600) < 14) ) return;
			get_template_part('templates/admin-rate');
		}
	}
}

// Hide rate notice
if ( !function_exists( 'smart_casa_callback_hide_rate_notice' ) ) {
	
	function smart_casa_callback_hide_rate_notice() {
		update_option('smart_casa_rate_notice', '0');
		exit;
	}
}


//-------------------------------------------------------
//-- Internal messages
//-------------------------------------------------------

// Init internal admin messages
if ( !function_exists( 'smart_casa_init_admin_messages' ) ) {
	function smart_casa_init_admin_messages() {
		$msg = get_option('smart_casa_admin_messages');
		if (is_array($msg))
			update_option('smart_casa_admin_messages', '');
		else
			$msg = array();
		smart_casa_storage_set('admin_messages', $msg);
	}
}

// Add internal admin message
if ( !function_exists( 'smart_casa_add_admin_message' ) ) {
	function smart_casa_add_admin_message($text, $type='success', $cur_session=false) {
		if (!empty($text)) {
			$new_msg = array('message' => $text, 'type' => $type);
			if ($cur_session) {
				smart_casa_storage_push_array('admin_messages', '', $new_msg);
			} else {
				$msg = get_option('smart_casa_admin_messages');
				if (!is_array($msg)) $msg = array();
				$msg[] = $new_msg;
				update_option('smart_casa_admin_messages', $msg);
			}
		}
	}
}

// Show internal admin messages
if ( !function_exists( 'smart_casa_show_admin_messages' ) ) {
	function smart_casa_show_admin_messages() {
		$msg = smart_casa_storage_get('admin_messages');
		if (!is_array($msg) || count($msg) == 0) return;
		?><div class="smart_casa_admin_messages"><?php
			foreach ($msg as $m) {
				?><div class="smart_casa_admin_message_item <?php echo esc_attr(str_replace('success', 'updated', $m['type'])); ?>">
					<p><?php echo wp_kses_data($m['message']); ?></p>
				</div><?php
			}
		?></div><?php
	}
}


//-------------------------------------------------------
//-- Styles and scripts
//-------------------------------------------------------
	
// Load inline styles
if ( !function_exists( 'smart_casa_admin_footer' ) ) {
	
	function smart_casa_admin_footer() {
		// Get current screen
		$screen = function_exists('get_current_screen') ? get_current_screen() : false;
		if (is_object($screen) && $screen->id=='nav-menus') {
			smart_casa_show_layout(smart_casa_show_custom_field('smart_casa_icons_popup',
													array(
														'type'	=> 'icons',
														'style'	=> smart_casa_get_theme_setting('icons_type'),
														'button'=> false,
														'icons'	=> true
													),
													null)
								);
		}
	}
}
	
// Load required styles and scripts for admin mode
if ( !function_exists( 'smart_casa_admin_scripts' ) ) {
	
	function smart_casa_admin_scripts() {

		// Add theme styles
		wp_enqueue_style(  'smart-casa-admin',  smart_casa_get_file_url('css/admin.css'), array(), null );

		// Links to selected fonts
		$screen = function_exists('get_current_screen') ? get_current_screen() : false;
		if (is_object($screen)) {
			if (smart_casa_options_override_allow(!empty($screen->post_type) ? $screen->post_type : $screen->id)) {
				// Load font icons
				wp_enqueue_style(  'fontello-icons', smart_casa_get_file_url('css/font-icons/css/fontello-embedded.css'), array(), null );
				wp_enqueue_style(  'fontello-icons-animation', smart_casa_get_file_url('css/font-icons/css/animation.css'), array(), null );
				// Load theme fonts
				$links = smart_casa_theme_fonts_links();
				if (count($links) > 0) {
					foreach ($links as $slug => $link) {
						wp_enqueue_style( sprintf('smart-casa-font-%s', $slug), $link, array(), null );
					}
				}
			} else if (apply_filters('smart_casa_filter_allow_theme_icons', is_customize_preview() || $screen->id=='nav-menus', !empty($screen->post_type) ? $screen->post_type : $screen->id)) {
				// Load font icons
				wp_enqueue_style(  'fontello-icons', smart_casa_get_file_url('css/font-icons/css/fontello-embedded.css'), array(), null );
			}
		}

		// Add theme scripts
		wp_enqueue_script( 'smart-casa-utils', smart_casa_get_file_url('js/theme-utils.js'), array('jquery'), null, true );
		wp_enqueue_script( 'smart-casa-admin', smart_casa_get_file_url('js/theme-admin.js'), array('jquery'), null, true );
	}
}
	
// Add variables in the admin mode
if ( !function_exists( 'smart_casa_admin_localize_scripts' ) ) {
	
	function smart_casa_admin_localize_scripts() {
		$screen = function_exists('get_current_screen') ? get_current_screen() : false;
		wp_localize_script( 'smart-casa-admin', 'SMART_CASA_STORAGE', apply_filters( 'smart_casa_filter_localize_script_admin', array(
			'admin_mode' => true,
			'screen_id' => is_object($screen) ? esc_attr($screen->id) : '',
			'ajax_url' => esc_url(admin_url('admin-ajax.php')),
			'ajax_nonce' => esc_attr(wp_create_nonce(admin_url('admin-ajax.php'))),
			'ajax_error_msg' => esc_html__('Server response error', 'smart-casa'),
			'icon_selector_msg' => esc_html__('Select the icon for this menu item', 'smart-casa'),
			'scheme_reset_msg' => esc_html__('Reset all changes of the current color scheme?', 'smart-casa'),
			'scheme_copy_msg' => esc_html__('Enter the name for a new color scheme', 'smart-casa'),
			'scheme_delete_msg' => esc_html__('Do you really want to delete the current color scheme?', 'smart-casa'),
			'scheme_delete_last_msg' => esc_html__('You cannot delete the last color scheme!', 'smart-casa'),
			'scheme_delete_internal_msg' => esc_html__('You cannot delete the built-in color scheme!', 'smart-casa'),
			'user_logged_in' => true
			))
		);
	}
}



//-------------------------------------------------------
//-- Third party plugins
//-------------------------------------------------------

// Register optional plugins
if ( !function_exists( 'smart_casa_register_plugins' ) ) {
	
	function smart_casa_register_plugins() {
		tgmpa(	apply_filters('smart_casa_filter_tgmpa_required_plugins', array(
				// Plugins to include in the autoinstall queue.
				)),
				array(
					'id'           => 'tgmpa',                 // Unique ID for hashing notices for multiple instances of TGMPA.
					'default_path' => '',                      // Default absolute path to bundled plugins.
					'menu'         => 'tgmpa-install-plugins', // Menu slug.
					'parent_slug'  => 'themes.php',            // Parent menu slug.
					'capability'   => 'edit_theme_options',    // Capability needed to view plugin install page, should be a capability associated with the parent menu used.
					'has_notices'  => true,                    // Show admin notices or not.
					'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
					'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
					'is_automatic' => false,                   // Automatically activate plugins after installation or not.
					'message'      => ''                       // Message to output right before the plugins table.
				)
			);
	}
}
?>