<?php
/**
 * Override Theme Options on a posts and pages
 *
 * @package WordPress
 * @subpackage SMART_CASA
 * @since SMART_CASA 1.0.29
 */


// -----------------------------------------------------------------
// -- Override Theme Options
// -----------------------------------------------------------------

if ( !function_exists('smart_casa_options_override_init') ) {
	add_action( 'after_setup_theme', 'smart_casa_options_override_init' );
	function smart_casa_options_override_init() {
		if ( is_admin() ) {
			add_action('admin_enqueue_scripts',	            'smart_casa_options_override_add_scripts');
			add_action('save_post',				            'smart_casa_options_override_save_options');
            add_filter('smart_casa_filter_override_options',	'smart_casa_options_override_add_options');
		}
	}
}
	
// Load required styles and scripts for admin mode
if ( !function_exists( 'smart_casa_options_override_add_scripts' ) ) {
	
	function smart_casa_options_override_add_scripts() {
		// If current screen is 'Edit Page' - load font icons
		$screen = function_exists('get_current_screen') ? get_current_screen() : false;
		if (is_object($screen) && smart_casa_options_override_allow(!empty($screen->post_type) ? $screen->post_type : $screen->id)) {
			wp_enqueue_style( 'fontello-icons',  smart_casa_get_file_url('css/font-icons/css/fontello-embedded.css'), array(), null );
			wp_enqueue_script( 'jquery-ui-tabs', false, array('jquery', 'jquery-ui-core'), null, true );
			wp_enqueue_script( 'jquery-ui-accordion', false, array('jquery', 'jquery-ui-core'), null, true );
			wp_enqueue_script( 'smart-casa-options', smart_casa_get_file_url('theme-options/theme-options.js'), array('jquery'), null, true );
			wp_localize_script( 'smart-casa-options', 'smart_casa_dependencies', smart_casa_get_theme_dependencies() );
		}
	}
}


// Check if override options is allowed for specified post type
if (!function_exists('smart_casa_options_override_allow')) {
	function smart_casa_options_override_allow($post_type) {
		return apply_filters('smart_casa_filter_allow_override_options', in_array($post_type, array('page', 'post')), $post_type);
	}
}

// Add override options
if (!function_exists('smart_casa_options_override_add_options')) {
    add_filter('smart_casa_filter_override_options', 'smart_casa_options_override_add_options');
    function smart_casa_options_override_add_options($list) {
        global $post_type;
        if (smart_casa_options_override_allow($post_type)) {
            $list[] = array(sprintf('smart_casa_override_options_%s', $post_type),
                esc_html__('Theme Options', 'smart-casa'),
                'smart_casa_options_override_show',
                $post_type,
                $post_type=='post' ? 'side' : 'advanced',
                'default'
            );
        }
        return $list;
    }
}

// Callback function to show override options
if (!function_exists('smart_casa_options_override_show')) {
	function smart_casa_options_override_show($post=false, $args=false) {
		if (empty($post) || !is_object($post) || empty($post->ID)) {
			global $post, $post_type;
			$mb_post_id = $post->ID;
			$mb_post_type = $post_type;
		} else {
			$mb_post_id = $post->ID;
			$mb_post_type = $post->post_type;
		}
		if (smart_casa_options_override_allow($mb_post_type)) {
			// Load saved options 
			$meta = get_post_meta($mb_post_id, 'smart_casa_options', true);
			$tabs_titles = $tabs_content = array();
			global $SMART_CASA_STORAGE;
			// Refresh linked data if this field is controller for the another (linked) field
			// Do this before show fields to refresh data in the $SMART_CASA_STORAGE
			foreach ($SMART_CASA_STORAGE['options'] as $k=>$v) {
				if (!isset($v['override']) || strpos($v['override']['mode'], $mb_post_type)===false) continue;
				if (!empty($v['linked'])) {
					$v['val'] = isset($meta[$k]) ? $meta[$k] : 'inherit';
					if (!empty($v['val']) && !smart_casa_is_inherit($v['val']))
						smart_casa_refresh_linked_data($v['val'], $v['linked']);
				}
			}
			// Show fields
			foreach ($SMART_CASA_STORAGE['options'] as $k=>$v) {
				if (!isset($v['override']) || strpos($v['override']['mode'], $mb_post_type)===false || $v['type'] == 'hidden') continue;
				if (empty($v['override']['section']))
					$v['override']['section'] = esc_html__('General', 'smart-casa');
				if (!isset($tabs_titles[$v['override']['section']])) {
					$tabs_titles[$v['override']['section']] = $v['override']['section'];
					$tabs_content[$v['override']['section']] = '';
				}
				$v['val'] = isset($meta[$k]) ? $meta[$k] : 'inherit';
				$tabs_content[$v['override']['section']] .= smart_casa_options_show_field($k, $v, $mb_post_type);
			}
			if (count($tabs_titles) > 0) {
				?>
				<div class="smart_casa_options smart_casa_override_options">
					<input type="hidden" name="override_options_nonce" value="<?php echo esc_attr(wp_create_nonce(admin_url())); ?>" />
					<input type="hidden" name="override_options_post_type" value="<?php echo esc_attr($mb_post_type); ?>" />
					<div id="smart_casa_options_tabs" class="smart_casa_tabs">
						<ul><?php
							$cnt = 0;
							foreach ($tabs_titles as $k=>$v) {
								$cnt++;
								?><li><a href="#smart_casa_options_<?php echo esc_attr($cnt); ?>"><?php echo esc_html($v); ?></a></li><?php
							}
						?></ul>
						<?php
							$cnt = 0;
							foreach ($tabs_content as $k=>$v) {
								$cnt++;
								?>
								<div id="smart_casa_options_<?php echo esc_attr($cnt); ?>" class="smart_casa_tabs_section smart_casa_options_section">
									<?php smart_casa_show_layout($v); ?>
								</div>
								<?php
							}
						?>
					</div>
				</div>
				<?php		
			}
		}
	}
}


// Save overriden options
if (!function_exists('smart_casa_options_override_save_options')) {
	
	function smart_casa_options_override_save_options($post_id) {

		// verify nonce
		if ( !wp_verify_nonce( smart_casa_get_value_gp('override_options_nonce'), admin_url() ) )
			return $post_id;

		// check autosave
		if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
			return $post_id;
		}

		$post_type = wp_kses_data(wp_unslash(isset($_POST['override_options_post_type']) ?  smart_casa_get_value_gpc('override_options_post_type') :  smart_casa_get_value_gpc('post_type')));

		// check permissions
		$capability = 'page';
		$post_types = get_post_types( array( 'name' => $post_type), 'objects' );
		if (!empty($post_types) && is_array($post_types)) {
			foreach ($post_types  as $type) {
				$capability = $type->capability_type;
				break;
			}
		}
		if (!current_user_can('edit_'.($capability), $post_id)) {
			return $post_id;
		}

        // Save options
		$meta = array();
		$options = smart_casa_storage_get('options');
		foreach ($options as $k=>$v) {
			// Skip not overriden options
			if (!isset($v['override']) || strpos($v['override']['mode'], $post_type)===false) continue;
			// Skip inherited options
			if (!empty($_POST["smart_casa_options_inherit_{$k}"])) continue;
			// Skip hidden options
			if (!isset($_POST["smart_casa_options_field_{$k}"]) && $v['type']=='hidden') continue;
			// Get option value from POST
			$meta[$k] = isset($_POST["smart_casa_options_field_{$k}"])
							? smart_casa_get_value_gp("smart_casa_options_field_{$k}")
							: ($v['type']=='checkbox' ? 0 : '');
		}
		$meta = apply_filters( 'smart_casa_filter_update_post_options', $meta, $post_id );
		update_post_meta($post_id, 'smart_casa_options', $meta);
		
		// Save separate meta options to search template pages
		if ($post_type=='page' && !empty($_POST['page_template']) && $_POST['page_template']=='blog.php') {
			update_post_meta($post_id, 'smart_casa_options_post_type', isset($meta['post_type']) ? $meta['post_type'] : 'post');
			update_post_meta($post_id, 'smart_casa_options_parent_cat', isset($meta['parent_cat']) ? $meta['parent_cat'] : 0);
		}
	}
}
?>