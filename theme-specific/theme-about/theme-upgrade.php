<?php
/**
 * Upgrade theme to the PRO version
 *
 * @package WordPress
 * @subpackage SMART_CASA
 * @since SMART_CASA 1.0.41
 */


// Add buttons, tabs and form to the 'About theme' screen
//--------------------------------------------------------------------

// Add tab 'Free vs PRO' to the 'About theme' screen
if (!function_exists('smart_casa_pro_add_tab_to_about')) {
	add_action( 'smart_casa_action_theme_about_after_tabs_list', 'smart_casa_pro_add_tab_to_about');
	function smart_casa_pro_add_tab_to_about() {	
		?><li><a href="#smart_casa_about_section_pro"><?php esc_html_e('Free vs PRO', 'smart-casa'); ?></a></li><?php
	}
}


// Add section 'Free vs PRO' to the 'About theme' screen
if (!function_exists('smart_casa_pro_add_section_to_about')) {
	add_action( 'smart_casa_action_theme_about_after_tabs_sections', 'smart_casa_pro_add_section_to_about', 10, 1);
	function smart_casa_pro_add_section_to_about($theme) {	
		?>
		<div id="smart_casa_about_section_pro" class="smart_casa_tabs_section smart_casa_about_section">
			<table class="smart_casa_about_table" cellpadding="0" cellspacing="0" border="0">
				<thead>
					<tr>
						<td class="smart_casa_about_table_info">&nbsp;</td>
						<td class="smart_casa_about_table_check"><?php
							// Translators: Show theme name with suffix 'Free'
							echo esc_html(sprintf(esc_html__('%s Free', 'smart-casa'), $theme->name));
						?></td>
						<td class="smart_casa_about_table_check"><?php
							// Translators: Show theme name with suffix 'PRO'
							echo esc_html(sprintf(esc_html__('%s PRO', 'smart-casa'), $theme->name));
						?></td>
					</tr>
				</thead>
				<tbody>


					<?php
					// Responsive layouts
					?>
					<tr>
						<td class="smart_casa_about_table_info">
							<h2 class="smart_casa_about_table_info_title">
								<?php esc_html_e('Mobile friendly', 'smart-casa'); ?>
							</h2>
							<div class="smart_casa_about_table_info_description"><?php
								esc_html_e('Responsive layout. Looks great on any device.', 'smart-casa');
							?></div>
						</td>
						<td class="smart_casa_about_table_check"><i class="dashicons dashicons-yes"></i></td>
						<td class="smart_casa_about_table_check"><i class="dashicons dashicons-yes"></i></td>
					</tr>

					<?php
					// Built-in slider
					?>
					<tr>
						<td class="smart_casa_about_table_info">
							<h2 class="smart_casa_about_table_info_title">
								<?php esc_html_e('Built-in posts slider', 'smart-casa'); ?>
							</h2>
							<div class="smart_casa_about_table_info_description"><?php
								esc_html_e('Allows you to add beautiful slides using the built-in shortcode/widget "Slider" with swipe gestures support.', 'smart-casa');
							?></div>
						</td>
						<td class="smart_casa_about_table_check"><i class="dashicons dashicons-yes"></i></td>
						<td class="smart_casa_about_table_check"><i class="dashicons dashicons-yes"></i></td>
					</tr>

					<?php
					// Revolution slider
					if (smart_casa_storage_isset('required_plugins', 'revslider')) {
					?>
					<tr>
						<td class="smart_casa_about_table_info">
							<h2 class="smart_casa_about_table_info_title">
								<?php esc_html_e('Revolution Slider Compatibility', 'smart-casa'); ?>
							</h2>
							<div class="smart_casa_about_table_info_description"><?php
								esc_html_e('Our built-in shortcode/widget "Slider" is able to work not only with posts, but also with slides created  in "Revolution Slider".', 'smart-casa');
							?></div>
						</td>
						<td class="smart_casa_about_table_check"><i class="dashicons dashicons-yes"></i></td>
						<td class="smart_casa_about_table_check"><i class="dashicons dashicons-yes"></i></td>
					</tr>
					<?php } ?>

					<?php
					// SiteOrigin Panels
					if (smart_casa_storage_isset('required_plugins', 'siteorigin-panels')) {
					?>
					<tr>
						<td class="smart_casa_about_table_info">
							<h2 class="smart_casa_about_table_info_title">
								<?php esc_html_e('Free PageBuilder', 'smart-casa'); ?>
							</h2>
							<div class="smart_casa_about_table_info_description"><?php
								esc_html_e('Full integration with a nice free page builder "SiteOrigin Panels".', 'smart-casa');
							?></div>
						</td>
						<td class="smart_casa_about_table_check"><i class="dashicons dashicons-yes"></i></td>
						<td class="smart_casa_about_table_check"><i class="dashicons dashicons-yes"></i></td>
					</tr>
					<tr>
						<td class="smart_casa_about_table_info">
							<h2 class="smart_casa_about_table_info_title">
								<?php esc_html_e('Additional widgets pack', 'smart-casa'); ?>
							</h2>
							<div class="smart_casa_about_table_info_description"><?php
								esc_html_e('A number of useful widgets to create beautiful homepages and other sections of your website with SiteOrigin Panels.', 'smart-casa');
							?></div>
						</td>
						<td class="smart_casa_about_table_check"><i class="dashicons dashicons-no"></i></td>
						<td class="smart_casa_about_table_check"><i class="dashicons dashicons-yes"></i></td>
					</tr>
					<?php } ?>

					<?php
					// WPBakery PageBuilder
					?>
					<tr>
						<td class="smart_casa_about_table_info">
							<h2 class="smart_casa_about_table_info_title">
								<?php esc_html_e('WPBakery PageBuilder', 'smart-casa'); ?>
							</h2>
							<div class="smart_casa_about_table_info_description"><?php
								esc_html_e('Full integration with a very popular page builder "WPBakery PageBuilder". A number of useful shortcodes and widgets to create beautiful homepages and other sections of your website.', 'smart-casa');
							?></div>
						</td>
						<td class="smart_casa_about_table_check"><i class="dashicons dashicons-no"></i></td>
						<td class="smart_casa_about_table_check"><i class="dashicons dashicons-yes"></i></td>
					</tr>
					<tr>
						<td class="smart_casa_about_table_info">
							<h2 class="smart_casa_about_table_info_title">
								<?php esc_html_e('Additional shortcodes pack', 'smart-casa'); ?>
							</h2>
							<div class="smart_casa_about_table_info_description"><?php
								esc_html_e('A number of useful shortcodes to create beautiful homepages and other sections of your website with WPBakery PageBuilder.', 'smart-casa');
							?></div>
						</td>
						<td class="smart_casa_about_table_check"><i class="dashicons dashicons-no"></i></td>
						<td class="smart_casa_about_table_check"><i class="dashicons dashicons-yes"></i></td>
					</tr>

					<?php
					// Layouts builder
					?>
					<tr>
						<td class="smart_casa_about_table_info">
							<h2 class="smart_casa_about_table_info_title">
								<?php esc_html_e('Headers and Footers builder', 'smart-casa'); ?>
							</h2>
							<div class="smart_casa_about_table_info_description"><?php
								esc_html_e('Powerful visual builder of headers and footers! No manual code editing - use all the advantages of drag-and-drop technology.', 'smart-casa');
							?></div>
						</td>
						<td class="smart_casa_about_table_check"><i class="dashicons dashicons-no"></i></td>
						<td class="smart_casa_about_table_check"><i class="dashicons dashicons-yes"></i></td>
					</tr>

					<?php
					// WooCommerce
					if (smart_casa_storage_isset('required_plugins', 'woocommerce')) {
					?>
					<tr>
						<td class="smart_casa_about_table_info">
							<h2 class="smart_casa_about_table_info_title">
								<?php esc_html_e('WooCommerce Compatibility', 'smart-casa'); ?>
							</h2>
							<div class="smart_casa_about_table_info_description"><?php
								esc_html_e('Ready for e-commerce. You can build an online store with this theme.', 'smart-casa');
							?></div>
						</td>
						<td class="smart_casa_about_table_check"><i class="dashicons dashicons-yes"></i></td>
						<td class="smart_casa_about_table_check"><i class="dashicons dashicons-yes"></i></td>
					</tr>
					<?php } ?>

					<?php
					// Easy Digital Downloads
					if (smart_casa_storage_isset('required_plugins', 'easy-digital-downloads')) {
					?>
					<tr>
						<td class="smart_casa_about_table_info">
							<h2 class="smart_casa_about_table_info_title">
								<?php esc_html_e('Easy Digital Downloads Compatibility', 'smart-casa'); ?>
							</h2>
							<div class="smart_casa_about_table_info_description"><?php
								esc_html_e('Ready for digital e-commerce. You can build an online digital store with this theme.', 'smart-casa');
							?></div>
						</td>
						<td class="smart_casa_about_table_check"><i class="dashicons dashicons-no"></i></td>
						<td class="smart_casa_about_table_check"><i class="dashicons dashicons-yes"></i></td>
					</tr>
					<?php } ?>

					<?php
					// Other plugins
					?>
					<tr>
						<td class="smart_casa_about_table_info">
							<h2 class="smart_casa_about_table_info_title">
								<?php esc_html_e('Many other popular plugins compatibility', 'smart-casa'); ?>
							</h2>
							<div class="smart_casa_about_table_info_description"><?php
								esc_html_e('PRO version is compatible (was tested and has built-in support) with many popular plugins.', 'smart-casa');
							?></div>
						</td>
						<td class="smart_casa_about_table_check"><i class="dashicons dashicons-no"></i></td>
						<td class="smart_casa_about_table_check"><i class="dashicons dashicons-yes"></i></td>
					</tr>

					<?php
					// Support
					?>
					<tr>
						<td class="smart_casa_about_table_info">
							<h2 class="smart_casa_about_table_info_title">
								<?php esc_html_e('Support', 'smart-casa'); ?>
							</h2>
							<div class="smart_casa_about_table_info_description"><?php
								esc_html_e('Our premium support is going to take care of any problems, in case there will be any of course.', 'smart-casa');
							?></div>
						</td>
						<td class="smart_casa_about_table_check"><i class="dashicons dashicons-no"></i></td>
						<td class="smart_casa_about_table_check"><i class="dashicons dashicons-yes"></i></td>
					</tr>

					<?php
					// Get PRO version
					?>
					<tr>
						<td class="smart_casa_about_table_info">&nbsp;</td>
						<td class="smart_casa_about_table_check" colspan="2">
							<a href="#" target="_blank" class="smart_casa_about_block_link smart_casa_pro_link button button-action"><?php
								esc_html_e('Get PRO version', 'smart-casa');
							?></a>
						</td>
					</tr>

				</tbody>
			</table>
		</div>
		<?php
	}
}


// Add button 'Get PRO Version' to the 'About theme' screen
if (!function_exists('smart_casa_pro_add_button')) {
	add_action( 'smart_casa_action_theme_about_before_title', 'smart_casa_pro_add_button', 10);
	function smart_casa_pro_add_button() {
		?><a href="#" class="smart_casa_pro_link button button-action"><?php esc_html_e('Get PRO version', 'smart-casa'); ?></a><?php
	}
}


// Show form
if (!function_exists('smart_casa_pro_add_form')) {
	add_action( 'smart_casa_action_theme_about_before_title', 'smart_casa_pro_add_form', 12, 1);
	function smart_casa_pro_add_form($theme) {
		?><div class="smart_casa_pro_form_wrap">
			<div class="smart_casa_pro_form">
				<span class="smart_casa_pro_close"><?php esc_html_e('Close', 'smart-casa'); ?></span>
				<h2 class="smart_casa_pro_title"><?php
					// Translators: Add theme name and version to the 'Upgrade to PRO' message
					echo esc_html(sprintf(esc_html__('Upgrade %1$s Free v.%2$s to PRO', 'smart-casa'),
											$theme->name,
											$theme->version
										)
								);
				?></h2>
				<div class="smart_casa_pro_fields">
					<div class="smart_casa_pro_field smart_casa_pro_step1">
						<h5 class="smart_casa_pro_step_title"><?php esc_html_e('Step 1', 'smart-casa'); ?></h5>
						<a href="<?php echo esc_url(smart_casa_storage_get('theme_download_url')); ?>" target="_blank" class="smart_casa_pro_link_get"><?php
							esc_html_e('Get PRO License Key', 'smart-casa');
						?></a>
					</div>
					<div class="smart_casa_pro_field smart_casa_pro_step2">
						<h5 class="smart_casa_pro_step_title"><?php esc_html_e('Step 2', 'smart-casa'); ?></h5>
						<label><span class="smart_casa_pro_label"><?php esc_html_e('Paste License Key here:', 'smart-casa'); ?></span>
							<input type="text" class="smart_casa_pro_key" value="" placeholder="<?php esc_attr_e('License Key', 'smart-casa'); ?>">
						</label>
						<a href="#" class="button button-action smart_casa_pro_upgrade" disabled="disabled"><?php
							esc_html_e('Upgrade to PRO Version', 'smart-casa');
						?></a>
					</div>
				</div>
			</div>
		</div><?php
	}
}


// Add messages to the admin script for both - 'About' screen and Customizer
if (!function_exists('smart_casa_pro_add_messages')) {
	add_filter( 'smart_casa_filter_localize_script_admin', 'smart_casa_pro_add_messages');
	function smart_casa_pro_add_messages($vars) {
		$vars['get_pro_error_msg'] = esc_html__('Error getting data from the update server!', 'smart-casa');
		$vars['get_pro_upgrader_msg'] = esc_html__('Upgrade details:', 'smart-casa');
		$vars['get_pro_success_msg'] = esc_html__('Theme upgraded successfully! Now you have the PRO version!', 'smart-casa');
		return $vars;
	}
}



// Create control for Customizer
//--------------------------------------------------------------------

// Theme init priorities:
// 3 - add/remove Theme Options elements
if (!function_exists('smart_casa_pro_theme_setup3')) {
	add_action( 'after_setup_theme', 'smart_casa_pro_theme_setup3', 3 );
	function smart_casa_pro_theme_setup3() {

		// Add section "Get PRO Version" if current theme is free
		// ------------------------------------------------------
		smart_casa_storage_set_array_before('options', 'title_tagline', array(
			'pro_section' => array(
				"title" => esc_html__('Get PRO Version', 'smart-casa'),
				"desc" => '',
				"priority" => 5,
				"type" => "section"
				),
			'pro_version' => array(
				"title" => esc_html__('Upgrade to the PRO Version', 'smart-casa'),
				"desc" => wp_kses_data( __('Get the PRO License Key and paste it to the field below to upgrade current theme to the PRO Version', 'smart-casa') ),
				"std" => '',
				"refresh" => false,
				"type" => "get_pro_version"
				),
		));
	}
}


// Register custom controls for the customizer
if (!function_exists('smart_casa_pro_customizer_custom_controls')) {
	add_action( 'customize_register', 'smart_casa_pro_customizer_custom_controls' );
	function smart_casa_pro_customizer_custom_controls( $wp_customize ) {
		class Smart_casa_Customize_Get_Pro_Version_Control extends WP_Customize_Control {
			public $type = 'get_pro_version';

			public function render_content() {
				?><div class="customize-control-wrap"><?php
				if (!empty($this->label)) {
					?><span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span><?php
				}
				if (!empty($this->description)) {
					?><span class="customize-control-description description"><?php smart_casa_show_layout( $this->description ); ?></span><?php
				}
				?><span class="customize-control-field-wrap"><?php

				smart_casa_pro_add_form(wp_get_theme());
				
				?></span></div><?php
			}
		}
	}
}


// Register custom controls for the customizer
if (!function_exists('smart_casa_pro_customizer_register_controls')) {
	add_filter('smart_casa_filter_register_customizer_control', 'smart_casa_pro_customizer_register_controls', 10, 7);
	function smart_casa_pro_customizer_register_controls( $result, $wp_customize, $id, $section, $priority, $transport, $opt ) {

		if ($opt['type'] == 'get_pro_version') {
			$wp_customize->add_setting( $id, array(
				'default'           => smart_casa_get_theme_option($id),
				'sanitize_callback' => !empty($opt['sanitize']) 
											? $opt['sanitize'] 
											: 'wp_kses_post',
				'transport'         => $transport
			) );

			$wp_customize->add_control( new Smart_casa_Customize_Get_Pro_Version_Control( $wp_customize, $id, array(
					'label'    => $opt['title'],
					'description' => $opt['desc'],
					'section'  => esc_attr($section),
					'priority' => $priority,
					'active_callback' => !empty($opt['active_callback']) ? $opt['active_callback'] : '',
				) ) );

			$result = true;
		}

		return $result;
	}
}



// Upgrade theme to PRO version
//--------------------------------------------------------------------

// AJAX callback - validate key and get PRO version
if (!function_exists('smart_casa_pro_get_pro_version_callback')) {
	add_action('wp_ajax_smart_casa_get_pro_version',			'smart_casa_pro_get_pro_version_callback');
	function smart_casa_pro_get_pro_version_callback() {
        if ( ! wp_verify_nonce( smart_casa_get_value_gp( 'nonce' ), admin_url( 'admin-ajax.php' ) ) || ! current_user_can( 'manage_options' ) )
			wp_die();

		$response = array(
			'error' => '', 
			'data'  => ''
		);

		$key = smart_casa_get_value_gp('license_key');

		if (!empty($key)) {
			$theme_slug = get_option( 'template' );
			$theme_name = wp_get_theme()->name;
			// Translators: Add the key and theme slug to the link
			$upgrade_url = sprintf('//upgrade.themerex.net/upgrade.php?key=%1$s&src=%2$s&theme_slug=%3$s&theme_name=%4$s',
									urlencode($key),
									urlencode(smart_casa_storage_get('theme_pro_key')),
									urlencode($theme_slug),
									urlencode($theme_name)
								);
			$result = function_exists('trx_addons_fgc') ? trx_addons_fgc($upgrade_url) : smart_casa_fgc($upgrade_url);
			if (substr($result, 0, 5) == 'a:2:{' && substr($result, -1, 1) == '}') {
				try {
					// JSON is bad working with big data:
					// Use serialization instead:
					$result = smart_casa_unserialize($result);
				} catch (Exception $e) {
					$result = array(
						'error' => esc_html__('Unrecognized server answer!', 'smart-casa'),
						'data' => ''
					);
				}
				if (isset($result['error']) && isset($result['data'])) {
					if (substr($result['data'], 0, 2) == "PK") {
						$tmp_name = 'tmp-'.rand().'.zip';
						$tmp = wp_upload_bits($tmp_name, null, $result['data']);
						if ($tmp['error']) {
							$response['error'] = esc_html__('Problem with save upgrade file to the folder with uploads', 'smart-casa');
						} else {
							if (file_exists($tmp['file'])) {
								ob_start();
								// Upgrade theme
								$response['error'] .= smart_casa_pro_upgrade_theme($theme_slug, $tmp['file']);
								// Remove uploaded archive
								unlink($tmp['file']);
								// Upgrade plugin
								$plugin = 'trx_addons';
								$plugin_path = smart_casa_get_file_dir("plugins/{$plugin}/{$plugin}.zip");
								if (!empty($plugin_path))
									$response['error'] .= smart_casa_pro_upgrade_plugin($plugin, $plugin_path);
								$log = ob_get_contents();
								ob_end_clean();
							} else {
								$response['error'] = esc_html__('Uploaded file with upgrade package not available', 'smart-casa');
							}
						}
					} else {
						$response['error'] = !empty($result['error'])
														? $result['error']
														: esc_html__('Package with upgrade is corrupt', 'smart-casa');
					}
				} else {
					$response['error'] = esc_html__('Incorrect server answer', 'smart-casa');
				}
			} else {
				$response['error'] = esc_html__('Unrecognized server answer format:', 'smart-casa') . strlen($result) . ' "' . substr($result, 0, 100) . '...' . substr($result, -100) . '"';
			}
		} else {
			$response['error'] = esc_html__('Entered key is not valid!', 'smart-casa');
		}

		echo json_encode($response);
		wp_die();
	}
}


// Upgrade theme from uploaded file
if (!function_exists('smart_casa_pro_upgrade_theme')) {
	function smart_casa_pro_upgrade_theme($theme_slug, $path) {
		
		$msg = '';

		$theme = wp_get_theme();

		// Load WordPress Upgrader
		if ( ! class_exists( 'Theme_Upgrader', false ) ) {
			require_once ABSPATH . 'wp-admin/includes/class-wp-upgrader.php';
		}

		// Prep variables for Theme_Installer_Skin class
		$extra         = array();
		$extra['slug'] = $theme_slug;	// Needed for potentially renaming of directory name
		$source        = $path;
		$api           = null;

		$url = add_query_arg(
					array(
						'action' => 'update-theme',
						'theme' => urlencode( $theme_slug ),
					),
					'update.php'
				);

		// Create Skin
		$skin_args = array(
					'type'   => 'upload',
					'title'  => '',
					'url'    => esc_url_raw( $url ),
					'nonce'  => 'update-theme_' . $theme_slug,
					'theme'  => $path,
					'api'    => $api,
					'extra'  => array(
								'slug' => $theme_slug
								)
				);
		$skin = new Theme_Upgrader_Skin( $skin_args );

		// Create a new instance of Theme_Upgrader
		$upgrader = new Theme_Upgrader( $skin );

		// Inject our info into the update transient
		$repo_updates = get_site_transient( 'update_themes' );
		if ( !is_object( $repo_updates ) ) {
			$repo_updates = new stdClass;
		}
		if ( empty( $repo_updates->response[ $theme_slug ] ) ) {
			$repo_updates->response[ $theme_slug ] = array();
		}
		$repo_updates->response[ $theme_slug ]['slug']        = $theme_slug;
		$repo_updates->response[ $theme_slug ]['theme']       = $theme_slug;
		$repo_updates->response[ $theme_slug ]['new_version'] = $theme->version;
		$repo_updates->response[ $theme_slug ]['package']     = $path;
		$repo_updates->response[ $theme_slug ]['url']         = $path;
		set_site_transient( 'update_themes', $repo_updates );

		// Upgrade theme
		$upgrader->upgrade( $theme_slug );

		return $msg;
	}
}


// Upgrade plugin from uploaded file
if (!function_exists('smart_casa_pro_upgrade_plugin')) {
	function smart_casa_pro_upgrade_plugin($plugin_slug, $path) {
		
		$msg = '';

		// Load plugin utilities
		if ( ! function_exists('get_plugin_data') ) {
			require_once ABSPATH . 'wp-admin/includes/plugin.php';
		}

		// Detect plugin path
		$plugin_base = "{$plugin_slug}/{$plugin_slug}.php";
		$plugin_path = trailingslashit(WP_PLUGIN_DIR) . $plugin_base;

		// If not installed - exit
		if (!file_exists($plugin_path)) return '';

		// Get plugin info
        $plugin_active = !is_plugin_inactive($plugin_base);
		$plugin_data = get_plugin_data($plugin_path);
		$tmp = explode('.', $plugin_data['Version']);
		$tmp[count($tmp)-1]++;
		$plugin_data['Version'] = implode('.', $tmp);

		// Load WordPress Upgrader
		if ( ! class_exists( 'Plugin_Upgrader', false ) ) {
			require_once ABSPATH . 'wp-admin/includes/class-wp-upgrader.php';
		}

		// Prep variables for Plugin_Installer_Skin class
		$extra         = array();
		$extra['slug'] = $plugin_slug;	// Needed for potentially renaming of directory name
		$source        = $path;
		$api           = null;

		$url = add_query_arg(
					array(
						'action' => 'update-plugin',
						'theme' => urlencode( $plugin_slug ),
					),
					'update.php'
				);

		// Create Skin
		$skin_args = array(
					'type'   => 'upload',
					'title'  => '',
					'url'    => esc_url_raw( $url ),
					'nonce'  => 'update-plugin_' . $plugin_slug,
					'theme'  => $path,
					'api'    => $api,
					'extra'  => array(
								'slug' => $plugin_slug
								)
				);
		$skin = new Plugin_Upgrader_Skin( $skin_args );

		// Create a new instance of Theme_Upgrader
		$upgrader = new Plugin_Upgrader( $skin );

		// Inject our info into the update transient
		$repo_updates = get_site_transient( 'update_plugins' );
		if ( !is_object( $repo_updates ) ) {
			$repo_updates = new stdClass;
		}
		if ( empty( $repo_updates->response[ $plugin_base ] ) ) {
			$repo_updates->response[ $plugin_base ] = new stdClass;
		}
		$repo_updates->response[ $plugin_base ]->slug        = $plugin_slug;
		$repo_updates->response[ $plugin_base ]->plugin      = $plugin_base;
		$repo_updates->response[ $plugin_base ]->new_version = $plugin_data['Version'];
		$repo_updates->response[ $plugin_base ]->package     = $path;
		$repo_updates->response[ $plugin_base ]->url         = $path;
		set_site_transient( 'update_plugins', $repo_updates );

		// Upgrade plugin
		$upgrader->upgrade( $plugin_base );

		// Activate plugin
		if ( is_plugin_inactive($plugin_base) ) {
			$result = activate_plugin( $plugin_base );
			if ( is_wp_error( $result ) ) {
				$msg = esc_html__('Error with plugin activation. Try to manually activate in the Plugins menu', 'smart-casa');
			}
		}

		return $msg;
	}
}
?>