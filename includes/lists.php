<?php
/**
 * Theme lists
 *
 * @package WordPress
 * @subpackage SMART_CASA
 * @since SMART_CASA 1.0
 */

// Disable direct call
if ( ! defined( 'ABSPATH' ) ) { exit; }



// Return numbers range
if ( !function_exists( 'smart_casa_get_list_range' ) ) {
	function smart_casa_get_list_range($from=1, $to=2, $prepend_inherit=false) {
		$list = array();
		for ($i=$from; $i<=$to; $i++)
			$list[$i] = $i;
		return $prepend_inherit ? smart_casa_array_merge(array('inherit' => esc_html__("Inherit", 'smart-casa')), $list) : $list;
	}
}



// Return styles list
if ( !function_exists( 'smart_casa_get_list_styles' ) ) {
	function smart_casa_get_list_styles($from=1, $to=2, $prepend_inherit=false) {
		$list = array();
		for ($i=$from; $i<=$to; $i++) {
			// Translators: Add number to the style name 'Style 1', 'Style 2' ...
			$list[$i] = sprintf(esc_html__('Style %d', 'smart-casa'), $i);
		}
		return $prepend_inherit ? smart_casa_array_merge(array('inherit' => esc_html__("Inherit", 'smart-casa')), $list) : $list;
	}
}

// Return list with 'Yes' and 'No' items
if ( !function_exists( 'smart_casa_get_list_yesno' ) ) {
	function smart_casa_get_list_yesno($prepend_inherit=false) {
		$list = array(
			"yes"	=> esc_html__("Yes", 'smart-casa'),
			"no"	=> esc_html__("No", 'smart-casa')
		);
		return $prepend_inherit ? smart_casa_array_merge(array('inherit' => esc_html__("Inherit", 'smart-casa')), $list) : $list;
	}
}

// Return list with 'On' and 'Of' items
if ( !function_exists( 'smart_casa_get_list_onoff' ) ) {
	function smart_casa_get_list_onoff($prepend_inherit=false) {
		$list = array(
			"on"	=> esc_html__("On", 'smart-casa'),
			"off"	=> esc_html__("Off", 'smart-casa')
		);
		return $prepend_inherit ? smart_casa_array_merge(array('inherit' => esc_html__("Inherit", 'smart-casa')), $list) : $list;
	}
}

// Return list with 'Show' and 'Hide' items
if ( !function_exists( 'smart_casa_get_list_showhide' ) ) {
	function smart_casa_get_list_showhide($prepend_inherit=false) {
		$list = array(
			"show" => esc_html__("Show", 'smart-casa'),
			"hide" => esc_html__("Hide", 'smart-casa')
		);
		return $prepend_inherit ? smart_casa_array_merge(array('inherit' => esc_html__("Inherit", 'smart-casa')), $list) : $list;
	}
}

// Return list with 'Horizontal' and 'Vertical' items
if ( !function_exists( 'smart_casa_get_list_directions' ) ) {
	function smart_casa_get_list_directions($prepend_inherit=false) {
		$list = array(
			"horizontal" => esc_html__("Horizontal", 'smart-casa'),
			"vertical"   => esc_html__("Vertical", 'smart-casa')
		);
		return $prepend_inherit ? smart_casa_array_merge(array('inherit' => esc_html__("Inherit", 'smart-casa')), $list) : $list;
	}
}

// Return list with paddings sizes
if ( !function_exists( 'smart_casa_get_list_paddings' ) ) {
	function smart_casa_get_list_paddings($prepend_inherit=false) {
		$list = apply_filters('smart_casa_filter_list_paddings', array(
			"none" => esc_html__("None", 'smart-casa'),
			"small" => esc_html__("Small", 'smart-casa'),
			"medium" => esc_html__("Medium", 'smart-casa'),
			"large" => esc_html__("Large", 'smart-casa')
		));
		return $prepend_inherit ? smart_casa_array_merge(array('inherit' => esc_html__("Inherit", 'smart-casa')), $list) : $list;
	}
}

// Return custom sidebars list, prepended inherit and main sidebars item (if need)
if ( !function_exists( 'smart_casa_get_list_sidebars' ) ) {
	function smart_casa_get_list_sidebars($prepend_inherit=false, $add_hide=false) {
		if (($list = smart_casa_storage_get('list_sidebars'))=='') {
			global $wp_registered_sidebars;
			$list = array();
			if (is_array($wp_registered_sidebars)) {
				foreach ( $wp_registered_sidebars as $k => $v ) {
					$list[$v['id']] = $v['name'];
				}
			}
			smart_casa_storage_set('list_sidebars', $list);
		}
		if ($add_hide) $list = smart_casa_array_merge(array('hide' => esc_html__("- Select widgets -", 'smart-casa')), $list);
		return $prepend_inherit ? smart_casa_array_merge(array('inherit' => esc_html__("Inherit", 'smart-casa')), $list) : $list;
	}
}

// Return sidebars positions
if ( !function_exists( 'smart_casa_get_list_sidebars_positions' ) ) {
	function smart_casa_get_list_sidebars_positions($prepend_inherit=false) {
		$list = apply_filters('smart_casa_filter_list_sidebars_positions', array(
			'hide'  => esc_html__('Hide',  'smart-casa'),
			'left'  => esc_html__('Left',  'smart-casa'),
			'right' => esc_html__('Right', 'smart-casa')
		));
		return $prepend_inherit ? smart_casa_array_merge(array('inherit' => esc_html__("Inherit", 'smart-casa')), $list) : $list;
	}
}

// Return header/footer types
if ( !function_exists( 'smart_casa_get_list_header_footer_types' ) ) {
	function smart_casa_get_list_header_footer_types($prepend_inherit=false) {
		$list = apply_filters('smart_casa_filter_list_header_footer_types', array(
			'default' => esc_html__('Default', 'smart-casa'),
		));
		return $prepend_inherit ? smart_casa_array_merge(array('inherit' => esc_html__("Inherit", 'smart-casa')), $list) : $list;
	}
}

// Return header styles
if ( !function_exists( 'smart_casa_get_list_header_styles' ) ) {
	function smart_casa_get_list_header_styles($prepend_inherit=false) {
		static $list = false;
		if (!$list) {
			$list = apply_filters('smart_casa_filter_list_header_styles', array());
		}
		return $prepend_inherit ? smart_casa_array_merge(array('inherit' => esc_html__("Inherit", 'smart-casa')), $list) : $list;
	}
}

// Return header positions
if ( !function_exists( 'smart_casa_get_list_header_positions' ) ) {
	function smart_casa_get_list_header_positions($prepend_inherit=false) {
		$list = array(
			'default' => esc_html__('Default','smart-casa'),
			'over' => esc_html__('Over',	'smart-casa'),
			'under' => esc_html__('Under',	'smart-casa')
		);
		return $prepend_inherit ? smart_casa_array_merge(array('inherit' => esc_html__("Inherit", 'smart-casa')), $list) : $list;
	}
}

// Return footer styles
if ( !function_exists( 'smart_casa_get_list_footer_styles' ) ) {
	function smart_casa_get_list_footer_styles($prepend_inherit=false) {
		static $list = false;
		if (!$list) {
			$list = apply_filters('smart_casa_filter_list_footer_styles', array());
		}
		return $prepend_inherit ? smart_casa_array_merge(array('inherit' => esc_html__("Inherit", 'smart-casa')), $list) : $list;
	}
}

// Return body styles list, prepended inherit
if ( !function_exists( 'smart_casa_get_list_body_styles' ) ) {
	function smart_casa_get_list_body_styles($prepend_inherit=false) {
		$list = array(
			'boxed'		 => esc_html__('Boxed',		'smart-casa'),
			'wide'		 => esc_html__('Wide',		'smart-casa'),
			'wide extra' => esc_html__('Wide Extra', 'smart-casa'),
		);
		if (apply_filters('smart_casa_filter_allow_fullscreen', smart_casa_get_theme_setting('allow_fullscreen') || smart_casa_get_edited_post_type()=='page')) {
			$list['fullwide']	= esc_html__('Fullwidth',	'smart-casa');
			$list['fullscreen']	= esc_html__('Fullscreen',	'smart-casa');
		}
		$list = apply_filters('smart_casa_filter_list_body_styles', $list);
		return $prepend_inherit ? smart_casa_array_merge(array('inherit' => esc_html__("Inherit", 'smart-casa')), $list) : $list;
	}
}

// Return blog styles list, prepended inherit
if ( !function_exists( 'smart_casa_get_list_blog_styles' ) ) {
	function smart_casa_get_list_blog_styles($prepend_inherit=false) {
		$list = apply_filters('smart_casa_filter_list_blog_styles', array(
			'excerpt'	  => esc_html__('Default',				'smart-casa'),
			'classic_2'	  => esc_html__('Classic /2 columns/',	'smart-casa'),
			'classic_3'	  => esc_html__('Classic /3 columns/',	'smart-casa'),
			'masonry_2'	  => esc_html__('Masonry /2 columns/',	'smart-casa'),
			'masonry_3'	  => esc_html__('Masonry /3 columns/',	'smart-casa'),
			'portfolio_2' => esc_html__('Portfolio /2 columns/','smart-casa'),
			'portfolio_3' => esc_html__('Portfolio /3 columns/','smart-casa'),
			'portfolio_4' => esc_html__('Portfolio /4 columns/','smart-casa'),
			'gallery_2'   => esc_html__('Gallery /2 columns/',	'smart-casa'),
			'gallery_3'   => esc_html__('Gallery /3 columns/',	'smart-casa'),
			'gallery_4'   => esc_html__('Gallery /4 columns/',	'smart-casa'),
			'chess_1'	  => esc_html__('Chess /2 column/',		'smart-casa'),
			'chess_2'	  => esc_html__('Chess /4 columns/',	'smart-casa'),
			'chess_3'	  => esc_html__('Chess /6 columns/',	'smart-casa')
			)
		);
		return $prepend_inherit ? smart_casa_array_merge(array('inherit' => esc_html__("Inherit", 'smart-casa')), $list) : $list;
	}
}


// Return list of categories
if ( !function_exists( 'smart_casa_get_list_categories' ) ) {
	function smart_casa_get_list_categories($prepend_inherit=false) {
		if (($list = smart_casa_storage_get('list_categories'))=='') {
			$list = array();
			$taxonomies = get_categories( array(
											'type' => 'post',
											'orderby' => 'name',
											'order' => 'ASC',
											'hide_empty' => 0,
											'hierarchical' => 1,
											'taxonomy' => 'category',
											'pad_counts' => false
											)
										);
			if (is_array($taxonomies) && count($taxonomies) > 0) {
				foreach ($taxonomies as $cat) {
					$list[$cat->term_id] = $cat->name;
				}
			}
			smart_casa_storage_set('list_categories', $list);
		}
		return $prepend_inherit ? smart_casa_array_merge(array('inherit' => esc_html__("Inherit", 'smart-casa')), $list) : $list;
	}
}


// Return list of taxonomies
if ( !function_exists( 'smart_casa_get_list_terms' ) ) {
	function smart_casa_get_list_terms($prepend_inherit=false, $taxonomy='category') {
		if (($list = smart_casa_storage_get('list_taxonomies_'.($taxonomy)))=='') {
			$list = array();
			$taxonomies = get_terms( $taxonomy, array(
													'orderby' => 'name',
													'order' => 'ASC',
													'hide_empty' => 0,
													'hierarchical' => 1,
													'taxonomy' => $taxonomy,
													'pad_counts' => false 
													)
									);
			if (is_array($taxonomies) && count($taxonomies) > 0) {
				foreach ($taxonomies as $cat) {
					$list[$cat->term_id] = $cat->name;
				}
			}
			smart_casa_storage_set('list_taxonomies_'.($taxonomy), $list);
		}
		return $prepend_inherit ? smart_casa_array_merge(array('inherit' => esc_html__("Inherit", 'smart-casa')), $list) : $list;
	}
}

// Return list of post's types
if ( !function_exists( 'smart_casa_get_list_posts_types' ) ) {
	function smart_casa_get_list_posts_types($prepend_inherit=false) {
		if (($list = smart_casa_storage_get('list_posts_types'))=='') {
			$list = apply_filters('smart_casa_filter_list_posts_types', array(
				'post' => esc_html__('Post', 'smart-casa')
			));
			smart_casa_storage_set('list_posts_types', $list);
		}
		return $prepend_inherit ? smart_casa_array_merge(array('inherit' => esc_html__("Inherit", 'smart-casa')), $list) : $list;
	}
}


// Return list post items from any post type and taxonomy
if ( !function_exists( 'smart_casa_get_list_posts' ) ) {
	function smart_casa_get_list_posts($prepend_inherit=false, $opt=array()) {
		$opt = array_merge(array(
			'post_type'			=> 'post',
			'post_status'		=> 'publish',
			'post_parent'		=> '',
			'taxonomy'			=> 'category',
			'taxonomy_value'	=> '',
			'meta_key'			=> '',
			'meta_value'		=> '',
			'meta_compare'		=> '',
			'posts_per_page'	=> -1,
			'orderby'			=> 'post_date',
			'order'				=> 'desc',
			'not_selected'		=> true,
			'return'			=> 'id'
			), is_array($opt) ? $opt : array('post_type'=>$opt));

		$hash = 'list_posts'
				. '_' . (is_array($opt['post_type']) ? join('_', $opt['post_type']) : $opt['post_type'])
				. '_' . (is_array($opt['post_parent']) ? join('_', $opt['post_parent']) : $opt['post_parent'])
				. '_' . ($opt['taxonomy'])
				. '_' . (is_array($opt['taxonomy_value']) ? join('_', $opt['taxonomy_value']) : $opt['taxonomy_value'])
				. '_' . ($opt['meta_key'])
				. '_' . ($opt['meta_compare'])
				. '_' . ($opt['meta_value'])
				. '_' . ($opt['orderby'])
				. '_' . ($opt['order'])
				. '_' . ($opt['return'])
				. '_' . ($opt['posts_per_page']);
		if (($list = smart_casa_storage_get($hash))=='') {
			$list = array();
			if ($opt['not_selected']!==false) $list['none'] = $opt['not_selected']===true 
																				? esc_html__("- Not selected -", 'smart-casa')
																				: $opt['not_selected'];
			$args = array(
				'post_type' => $opt['post_type'],
				'post_status' => $opt['post_status'],
				'posts_per_page' => $opt['posts_per_page'],
				'ignore_sticky_posts' => true,
				'orderby'	=> $opt['orderby'],
				'order'		=> $opt['order']
			);
			if (!empty($opt['post_parent'])) {
				if (is_array($opt['post_parent']))
					$args['post_parent__in'] = $opt['post_parent'];
				else
					$args['post_parent'] = $opt['post_parent'];
			}
			if (!empty($opt['taxonomy_value'])) {
				$args['tax_query'] = array(
					array(
						'taxonomy' => $opt['taxonomy'],
						'field' => is_array($opt['taxonomy_value']) 
										? ((int) $opt['taxonomy_value'][0] > 0  ? 'term_taxonomy_id' : 'slug')
										: ((int) $opt['taxonomy_value'] > 0  ? 'term_taxonomy_id' : 'slug'),
						'terms' => is_array($opt['taxonomy_value'])
										? $opt['taxonomy_value'] 
										: ((int) $opt['taxonomy_value'] > 0 ? (int) $opt['taxonomy_value'] : $opt['taxonomy_value'] ) 
					)
				);
			}
			if (!empty($opt['meta_key'])) {
				$args['meta_key'] = $opt['meta_key'];
			}
			if (!empty($opt['meta_value'])) {
				$args['meta_value'] = $opt['meta_value'];
			}
			if (!empty($opt['meta_compare'])) {
				$args['meta_compare'] = $opt['meta_compare'];
			}
			$posts = get_posts( $args );
			if (is_array($posts) && count($posts) > 0) {
				foreach ($posts as $post) {
					$list[$opt['return']=='id' ? $post->ID : $post->post_title] = $post->post_title;
				}
			}
			smart_casa_storage_set($hash, $list);
		}
		return $prepend_inherit ? smart_casa_array_merge(array('inherit' => esc_html__("Inherit", 'smart-casa')), $list) : $list;
	}
}


// Return list of registered users
if ( !function_exists( 'smart_casa_get_list_users' ) ) {
	function smart_casa_get_list_users($prepend_inherit=false, $roles=array('administrator', 'editor', 'author', 'contributor', 'shop_manager')) {
		if (($list = smart_casa_storage_get('list_users'))=='') {
			$list = array();
			$list['none'] = esc_html__("- Not selected -", 'smart-casa');
			$users = get_users( array(
									'orderby' => 'display_name',
									'order' => 'ASC'
									)
								);
			if (is_array($users) && count($users) > 0) {
				foreach ($users as $user) {
					$accept = true;
					if (is_array($user->roles)) {
						if (is_array($user->roles) && count($user->roles) > 0) {
							$accept = false;
							foreach ($user->roles as $role) {
								if (in_array($role, $roles)) {
									$accept = true;
									break;
								}
							}
						}
					}
					if ($accept) $list[$user->user_login] = $user->display_name;
				}
			}
			smart_casa_storage_set('list_users', $list);
		}
		return $prepend_inherit ? smart_casa_array_merge(array('inherit' => esc_html__("Inherit", 'smart-casa')), $list) : $list;
	}
}

// Return menus list, prepended inherit
if ( !function_exists( 'smart_casa_get_list_menus' ) ) {
	function smart_casa_get_list_menus($prepend_inherit=false) {
		if (($list = smart_casa_storage_get('list_menus'))=='') {
			$list = array();
			$list['default'] = esc_html__("Default", 'smart-casa');
			$menus = wp_get_nav_menus();
			if (is_array($menus) && count($menus) > 0) {
				foreach ($menus as $menu) {
					$list[$menu->slug] = $menu->name;
				}
			}
			smart_casa_storage_set('list_menus', $list);
		}
		return $prepend_inherit ? smart_casa_array_merge(array('inherit' => esc_html__("Inherit", 'smart-casa')), $list) : $list;
	}
}

// Return iconed classes list
if ( !function_exists( 'smart_casa_get_list_icons' ) ) {
	function smart_casa_get_list_icons($prepend_inherit=false) {
		static $list = false;
		if (!is_array($list)) 
			$list = !is_admin() ? array() : smart_casa_parse_icons_classes(smart_casa_get_file_dir("css/font-icons/css/fontello-codes.css"));
		$list = smart_casa_array_merge(array('none' => 'none'), $list);
		return $prepend_inherit ? smart_casa_array_merge(array('inherit' => esc_html__("Inherit", 'smart-casa')), $list) : $list;
	}
}

// Return images list
if ( !function_exists( 'smart_casa_get_list_images' ) ) {
	function smart_casa_get_list_images($prepend_inherit=false) {
		$list = function_exists('trx_addons_get_list_files')
				? trx_addons_get_list_files('css/icons.png', 'png')
				: array();
		return $prepend_inherit ? smart_casa_array_merge(array('inherit' => esc_html__("Inherit", 'smart-casa')), $list) : $list;
	}
}


// Additional attributes for VC and SOW
//----------------------------------------------------
if ( !function_exists( 'smart_casa_get_list_sc_color_styles' ) ) {
	function smart_casa_get_list_sc_color_styles($prepend_inherit=false) {
		$list = apply_filters('smart_casa_filter_get_list_sc_color_styles', array(
			'default' => esc_html__('Default', 'smart-casa'),
			'link2' => esc_html__('Link 2', 'smart-casa'),
			'link3' => esc_html__('Link 3', 'smart-casa'),
			'dark' => esc_html__('Dark', 'smart-casa')
		));
		return $prepend_inherit ? smart_casa_array_merge(array('inherit' => esc_html__("Inherit", 'smart-casa')), $list) : $list;
	}
}
?>