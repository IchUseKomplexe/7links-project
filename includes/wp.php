<?php
/**
 * WP tags and utils
 *
 * @package WordPress
 * @subpackage SMART_CASA
 * @since SMART_CASA 1.0
 */

// Theme init
if (!function_exists('smart_casa_wp_theme_setup')) {
	add_action( 'after_setup_theme', 'smart_casa_wp_theme_setup' );
	function smart_casa_wp_theme_setup() {

		// Remove macros from title
		add_filter('wp_title',						'smart_casa_wp_title');
		add_filter('wp_title_parts',				'smart_casa_wp_title');
		add_filter('document_title_parts',			'smart_casa_wp_title');

		// Breadcrumbs link 'All posts'
		add_filter('post_type_archive_link',		'smart_casa_get_template_page_link', 10, 2);
		
		// Comment form fields order
		add_filter('comment_form_fields',			'smart_casa_comment_form_fields');
	}
}


/* Blog utilities
-------------------------------------------------------------------------------- */

// Detect current blog mode to get correspond options (post | page | search | blog | front)
if (!function_exists('smart_casa_detect_blog_mode')) {
	function smart_casa_detect_blog_mode() {
		if (is_front_page() && !is_home())
			$mode = 'front';
		else if (is_home())
			$mode = 'home';		// Specify 'blog' if you don't need a separate options for the homepage
		else if (is_single())
			$mode = 'post';
		else if (is_page() && !smart_casa_storage_isset('blog_archive'))
			$mode = 'page';
		else
			$mode = 'blog';
		return apply_filters('smart_casa_filter_detect_blog_mode', $mode);
	}
}
	
// Return image of current post/page/category/blog mode
if (!function_exists('smart_casa_get_current_mode_image')) {
	function smart_casa_get_current_mode_image($default='') {
		if (is_category()) {
			if (($img = smart_casa_get_category_image()) != '')
				$default = $img;
		} else if (is_singular() || smart_casa_storage_isset('blog_archive')) {
			if (has_post_thumbnail()) {
				$img = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full' );
				if (is_array($img)) $default = $img[0];
			} else
				$default = '';
		}
		return $default;
	}
}
	
// Return ID of the post/page
if (!function_exists('smart_casa_get_post_id')) {
	function smart_casa_get_post_id($args=array()) {
		$args = array_merge(array(
			'posts_per_page' => 1
		), $args);
		$id = 0;
		$query = new WP_Query( $args );
		while ( $query->have_posts() ) { $query->the_post();
			$id = get_the_ID();
			break;
		}
		wp_reset_postdata();
		return $id;
	}
}
	
// Return ID for the page with specified template
if (!function_exists('smart_casa_get_template_page_id')) {
	function smart_casa_get_template_page_id($args=array()) {
		$args = array_merge(array(
			'template' => 'blog.php',
			'post_type' => 'post',
			'parent_cat' => ''
		), $args);
		$q_args = array(
			'post_type' => 'page',
			'post_status' => 'publish',
			'posts_per_page' => 1,
			'orderby' => 'id',
			'order' => 'asc',
			'meta_query' => array('relation' => 'AND')
			);
		if (!empty($args['template'])) {
			$q_args['meta_query'][] = array(
				'key' => '_wp_page_template',
				'value' => $args['template'],
				'compare' => '='
			);
		}
		if (!empty($args['post_type'])) {
			$q_args['meta_query'][] = array(
				'key' => 'smart_casa_options_post_type',
				'value' => $args['post_type'],
				'compare' => '='
			);
		}
		if ($args['parent_cat'] !== '') {
			$q_args['meta_query'][] = array(
				'key' => 'smart_casa_options_parent_cat',
				'value' => $args['parent_cat'] > 0 ? $args['parent_cat'] : 1,
				'compare' => $args['parent_cat'] > 0 ? '=' : '<'
			);
		}
		return smart_casa_get_post_id($q_args);
	}
}

// Return link to the page with theme specific $post_type archive template page:
if ( !function_exists( 'smart_casa_get_template_page_link' ) ) {
	
	function smart_casa_get_template_page_link($link='', $post_type='') {
		if (!empty($post_type)) {
			$id = smart_casa_get_template_page_id(array('post_type'=>$post_type, 'parent_cat'=>0));
			if ((int)$id > 0) $link = get_permalink($id);
		}
		return $link;
	}
}


// Return current site protocol
if (!function_exists('smart_casa_get_protocol')) {
	function smart_casa_get_protocol() {
		return is_ssl() ? 'https' : 'http';
	}
}

// Return internal page link - if is customize mode - full url else only hash part
if (!function_exists('smart_casa_get_hash_link')) {
	function smart_casa_get_hash_link($hash) {
		if (strpos($hash, 'http')!==0) {
			if ($hash[0]!='#') $hash = '#'.$hash;
			if (is_customize_preview()) {
				$url = smart_casa_get_current_url();
				if (($pos=strpos($url, '#'))!==false) $url = substr($url, 0, $pos);
				$hash = $url . $hash;
			}
		}
		return $hash;
	}
}

// Return URL to the current page
if (!function_exists('smart_casa_get_current_url')) {
	function smart_casa_get_current_url() {
		return add_query_arg(array());
	}
}

// Remove macros from the title
if ( !function_exists( 'smart_casa_wp_title' ) ) {
	
	
	
	function smart_casa_wp_title( $title ) {
		if (is_array($title)) {
			foreach ($title as $k=>$v)
				$title[$k] = smart_casa_remove_macros($v);
		} else
			$title = smart_casa_remove_macros($title);
		return $title;
	}
}

// Return blog title
if (!function_exists('smart_casa_get_blog_title')) {
	function smart_casa_get_blog_title() {

		if (is_front_page()) {
			$title = esc_html__( 'Home', 'smart-casa' );
		} else if ( is_home() ) {
			$title = esc_html__( 'All Posts', 'smart-casa' );
		} else if ( is_author() ) {
			$curauth = (get_query_var('author_name')) ? get_user_by('slug', get_query_var('author_name')) : get_userdata(get_query_var('author'));
			// Translators: Add the author's name to the title
			$title = sprintf(esc_html__('Author page: %s', 'smart-casa'), $curauth->display_name);
		} else if ( is_404() ) {
			$title = esc_html__('URL not found', 'smart-casa');
		} else if ( is_search() ) {
			// Translators: Add the author's name to the title
			$title = sprintf( esc_html__( 'Search: %s', 'smart-casa' ), get_search_query() );
		} else if ( is_day() ) {
			// Translators: Add the queried date to the title
			$title = sprintf( esc_html__( 'Daily Archives: %s', 'smart-casa' ), get_the_date() );
		} else if ( is_month() ) {
			// Translators: Add the queried month to the title
			$title = sprintf( esc_html__( 'Monthly Archives: %s', 'smart-casa' ), get_the_date( 'F Y' ) );
		} else if ( is_year() ) {
			// Translators: Add the queried year to the title
			$title = sprintf( esc_html__( 'Yearly Archives: %s', 'smart-casa' ), get_the_date( 'Y' ) );
		} else if ( is_category() ) {
			$title = single_cat_title( '', false );
		} else if ( is_tag() ) {
			// Translators: Add the tag's name to the title
			$title = sprintf( esc_html__( 'Tag: %s', 'smart-casa' ), single_tag_title( '', false ) );
		} else if ( is_tax() ) {
			$title = single_term_title( '', false );
		} else if ( is_post_type_archive() ) {
			$obj = get_queried_object();
			$title = !empty($obj->labels->all_items) ? $obj->labels->all_items : '';
		} else if ( is_attachment() ) {
			// Translators: Add the attachment's name to the title
			$title = sprintf( esc_html__( 'Attachment: %s', 'smart-casa' ), get_the_title());
		} else if ( is_single() || is_page() ) {
			$title = get_the_title();
		} else {
			$title = get_the_title();
		}
		return apply_filters('smart_casa_filter_get_blog_title', $title);
	}
}

// Comment form fields order
if ( !function_exists( 'smart_casa_comment_form_fields' ) ) {
	
	function smart_casa_comment_form_fields($comment_fields) {
		if (smart_casa_get_theme_setting('comment_after_name')) {
			$keys = array_keys($comment_fields);
			if ($keys[0]=='comment') $comment_fields['comment'] = array_shift($comment_fields);
		}
		return $comment_fields;
	}
}

// Return nav menu html
if ( !function_exists( 'smart_casa_get_nav_menu' ) ) {
	function smart_casa_get_nav_menu($location='', $menu = '', $depth=0, $custom_walker=false) {
		static $list = array();
		$class = '';
		if (is_array($location)) {
			$loc = $location;
			$location = '';
			if (!empty($loc['location']))	$location = $loc['location'];
			if (!empty($loc['class']))		$class = $loc['class'];
		}
		$slug = $location.'_'.$menu;
		if (empty($list[$slug])) {
			$list[$slug] = esc_html__('You are trying to use a menu inserted in himself!', 'smart-casa');
			$args = array(
					'menu'				=> empty($menu) || $menu=='default' || smart_casa_is_inherit($menu) ? '' : $menu,
					'container'			=> 'nav',
					'container_class'	=> (!empty($location) ? esc_attr($location) : 'menu_main') . '_nav_area' 
											. (!empty($class) ? ' '.esc_attr($class) : ''),
					'container_id'		=> '',
					'items_wrap'		=> '<ul id="%1$s" class="%2$s">%3$s</ul>',
					'menu_class'		=> 'sc_layouts_menu_nav ' . (!empty($location) ? esc_attr($location) : 'menu_main') . '_nav',
					'menu_id'			=> (!empty($location) ? esc_attr($location) : 'menu_main'),
					'echo'				=> false,
					'fallback_cb'		=> '',
					'before'			=> '',
					'after'				=> '',
					'link_before'       => '<span>',
					'link_after'        => '</span>',
					'depth'             => $depth
					);
			if (!empty($location))
				$args['theme_location'] = $location;
			if ($custom_walker && class_exists('smart_casa_custom_menu_walker'))
				$args['walker'] = new smart_casa_custom_menu_walker;
			// Remove spaces between menu items
			$list[$slug] = preg_replace(array("/>[\r\n\s]*<li/", "/>[\r\n\s]*<\\/ul>/"),
										array("><li", "></ul>"),
										wp_nav_menu(apply_filters('smart_casa_filter_get_nav_menu_args', $args))
										);
			// Add Structured Data Snippet
			$list[$slug] = str_replace("<nav", '<nav itemscope itemtype="//schema.org/SiteNavigationElement"', $list[$slug]);
		}
		return apply_filters('smart_casa_filter_get_nav_menu', $list[$slug], $location, $menu);
	}
}

// Return string with categories links
if (!function_exists('smart_casa_get_post_categories')) {
	function smart_casa_get_post_categories($delimiter=', ', $id=false, $links=true) {
		return smart_casa_get_post_terms($delimiter, $id, '', $links);
	}
}

// Return string with terms links
if (!function_exists('smart_casa_get_post_terms')) {
	function smart_casa_get_post_terms($delimiter=', ', $id=false, $taxonomy='category', $links=true) {
		$output = '';
		if (empty($id)) $id = get_the_ID();
		if (empty($taxonomy)) $taxonomy = smart_casa_get_post_type_taxonomy(get_post_type($id));
		$terms = get_the_terms($id, $taxonomy);
		if ( !empty( $terms ) && is_array($terms) ) {
			$cnt = count($terms);
			$i = 0;
			foreach( $terms as $term ) {
				if (empty($term->term_id)) continue;
				$i++;
				$output .= ($links 
									? '<a href="' . esc_url( get_term_link( $term->term_id, $taxonomy ) ) . '"'
											// Translators: Add the term's name to the title
											. ' title="' . sprintf( esc_attr__( 'View all posts in %s', 'smart-casa' ), esc_attr($term->name) ) . '"'
											. '>'
									: '<span>'
								)
								. esc_html( $term->name ) 
								. ($i<$cnt ? $delimiter : '') 
							. ($links ? '</a>' : '</span>');
			}
		}
		return $output;
	}
}

// Return taxonomy for current post type
if ( !function_exists( 'smart_casa_get_post_type_taxonomy' ) ) {
	function smart_casa_get_post_type_taxonomy($post_type='') {
		if (empty($post_type)) $post_type = get_post_type();
		if ($post_type == 'post')
			$tax = 'category';
		else {
	        $taxonomy_names = get_object_taxonomies( $post_type );
			$tax = !empty($taxonomy_names[0]) ? $taxonomy_names[0] : '';
		}
		return apply_filters( 'smart_casa_filter_post_type_taxonomy', $tax, $post_type );
	}
}

// Return editing post type or empty string if not edit mode
if ( !function_exists( 'smart_casa_get_edited_post_type' ) ) {
	function smart_casa_get_edited_post_type() {
		$pt = '';
		if (is_admin()) {
			$url = smart_casa_get_current_url();
			if (strpos($url, 'post.php') !== false) {
				if (smart_casa_get_value_gp('action') == 'edit' && ($id = smart_casa_get_value_gp('post')) > 0) {
					$post = get_post((int)$id);
					if (is_object($post) && !empty($post->post_type)) $pt = $post->post_type;
				}
			} else if (strpos($url, 'post-new.php')!==false) {
				$pt = smart_casa_get_value_gp('post_type');
			}
		}
		return $pt;
	}
}


/* Query manipulations
-------------------------------------------------------------------------------- */

// Add sorting parameter in query arguments
if (!function_exists('smart_casa_query_add_sort_order')) {
	function smart_casa_query_add_sort_order($args, $orderby='date', $order='desc') {
		if (!empty($orderby) && (empty($args['orderby']) || $orderby != 'none')) {
			$q = apply_filters('smart_casa_filter_query_sort_order', array(), $orderby, $order);
			$q['order'] = $order=='asc' ? 'asc' : 'desc';
			if (empty($q['orderby'])) {
				if ($orderby == 'none') {
					$q['orderby'] = 'none';
				} else if ($orderby == 'ID') {
					$q['orderby'] = 'ID';
				} else if ($orderby == 'comments') {
					$q['orderby'] = 'comment_count';
				} else if ($orderby == 'title' || $orderby == 'alpha') {
					$q['orderby'] = 'title';
				} else if ($orderby == 'rand' || $orderby == 'random')  {
					$q['orderby'] = 'rand';
				} else {
					$q['orderby'] = 'post_date';
				}
			}
			foreach ($q as $mk=>$mv) {
				if (is_array($args))
					$args[$mk] = $mv;
				else
					$args->set($mk, $mv);
			}
		}
		return $args;
	}
}

// Add post type and posts list or categories list in query arguments
if (!function_exists('smart_casa_query_add_posts_and_cats')) {
	function smart_casa_query_add_posts_and_cats($args, $ids='', $post_type='', $cat='', $taxonomy='') {
		if (!empty($ids)) {
			$args['post_type'] = empty($args['post_type']) 
									? (empty($post_type) ? array('post', 'page') : $post_type)
									: $args['post_type'];
			$args['post__in'] = explode(',', str_replace(' ', '', $ids));
			if (empty($args['orderby']) || $args['orderby'] == 'none') {
				$args['orderby'] = 'post__in';
				if (isset($args['order'])) unset($args['order']);
			}
		} else {
			$args['post_type'] = empty($args['post_type']) 
									? (empty($post_type) ? 'post' : $post_type)
									: $args['post_type'];
			$post_type = is_array($args['post_type']) ? $args['post_type'][0] : $args['post_type'];
			if (!empty($cat)) {
				$cats = !is_array($cat) ? explode(',', $cat) : $cat;
				if (empty($taxonomy)) 
					$taxonomy = smart_casa_get_post_type_taxonomy($post_type);
				if ($taxonomy == 'category') {				// Add standard categories
					if (is_array($cats) && count($cats) > 1) {
						$cats_ids = array();
						foreach($cats as $c) {
							$c = trim($c);
							if (empty($c)) continue;
							if ((int) $c == 0) {
								$cat_term = get_term_by( 'slug', $c, $taxonomy, OBJECT);
								if ($cat_term) $c = $cat_term->term_id;
							}
							if ($c==0) continue;
							$cats_ids[] = (int) $c;
							$children = get_categories( array(
								'type'                     => $post_type,
								'child_of'                 => $c,
								'hide_empty'               => 0,
								'hierarchical'             => 0,
								'taxonomy'                 => $taxonomy,
								'pad_counts'               => false
							));
							if (is_array($children) && count($children) > 0) {
								foreach($children as $c) {
									if (!in_array((int) $c->term_id, $cats_ids)) $cats_ids[] = (int) $c->term_id;
								}
							}
						}
						if (count($cats_ids) > 0) {
							$args['category__in'] = $cats_ids;
						}
					} else {
						if ((int) $cat > 0) 
							$args['cat'] = (int) $cat;
						else
							$args['category_name'] = $cat;
					}
				} else {									// Add custom taxonomies
					if (!isset($args['tax_query']))
						$args['tax_query'] = array();
					$args['tax_query']['relation'] = 'AND';
					$args['tax_query'][] = array(
						'taxonomy' => $taxonomy,
						'include_children' => true,
						'field'    => (int) $cats[0] > 0 ? 'id' : 'slug',
						'terms'    => $cats
					);
				}
			}
		}
		return $args;
	}
}

// Add filters (meta parameters) in query arguments
if (!function_exists('smart_casa_query_add_filters')) {
	function smart_casa_query_add_filters($args, $filters=false) {
		if (!empty($filters)) {
			if (!is_array($filters)) $filters = array($filters);
			foreach ($filters as $v) {
				$found = false;
				if ($v=='thumbs') {							// Filter with meta_query
					if (!isset($args['meta_query']))
						$args['meta_query'] = array();
					else {
						for ($i=0; $i<count($args['meta_query']); $i++) {
							if ($args['meta_query'][$i]['meta_filter'] == $v) {
								$found = true;
								break;
							}
						}
					}
					if (!$found) {
						$args['meta_query']['relation'] = 'AND';
						if ($v == 'thumbs') {
							$args['meta_query'][] = array(
								'meta_filter' => $v,
								'key' => '_thumbnail_id',
								'value' => false,
								'compare' => '!='
							);
						}
					}
				} else if (in_array($v, array('video', 'audio', 'gallery'))) {			// Filter with tax_query
					if (!isset($args['tax_query']))
						$args['tax_query'] = array();
					else {
						for ($i=0; $i<count($args['tax_query']); $i++) {
							if ($args['tax_query'][$i]['tax_filter'] == $v) {
								$found = true;
								break;
							}
						}
					}
					if (!$found) {
						$args['tax_query']['relation'] = 'AND';
						if ($v == 'video') {
							$args['tax_query'][] = array(
								'tax_filter' => $v,
								'taxonomy' => 'post_format',
								'field' => 'slug',
								'terms' => array( 'post-format-video' )
							);
						} else if ($v == 'audio') {
							$args['tax_query'] = array(
								'tax_filter' => $v,
								'taxonomy' => 'post_format',
								'field' => 'slug',
								'terms' => array( 'post-format-audio' )
							);
						} else if ($v == 'gallery') {
							$args['tax_query'] = array(
								'tax_filter' => $v,
								'taxonomy' => 'post_format',
								'field' => 'slug',
								'terms' => array( 'post-format-gallery' )
							);
						}
					}
				}
			}
		}
		return $args;
	}
}



	
/* Widgets utils
------------------------------------------------------------------------------------- */

// Create widgets area
if (!function_exists('smart_casa_create_widgets_area')) {
	function smart_casa_create_widgets_area($name, $add_classes='') {
		$widgets_name = smart_casa_get_theme_option($name);
		if (!smart_casa_is_off($widgets_name) && is_active_sidebar($widgets_name)) { 
			smart_casa_storage_set('current_sidebar', $name);
			ob_start();
			dynamic_sidebar($widgets_name);
			$out = trim(ob_get_contents());
			ob_end_clean();
			if (!empty($out)) {
				$out = preg_replace("/<\/aside>[\r\n\s]*<aside/", "</aside><aside", $out);
				$need_columns = strpos($out, 'columns_wrap')===false;
				if ($need_columns) {
					$columns = min(3, max(1, substr_count($out, '<aside ')));
					$out = preg_replace("/<aside([^>]*)class=\"widget/", "<aside$1class=\"column-1_".esc_attr($columns).' widget', $out);
				}
				?>
				<div class="<?php echo esc_attr($name); ?> <?php echo esc_attr($name); ?>_wrap widget_area">
					<div class="<?php echo esc_attr($name); ?>_inner <?php echo esc_attr($name); ?>_inner widget_area_inner">
						<?php
						do_action( 'smart_casa_action_before_sidebar' );
						smart_casa_show_layout($out,
										true==$need_columns ? '<div class="columns_wrap">' : '',
                                        true==$need_columns ? '</div>' : ''
                                        );
						do_action( 'smart_casa_action_after_sidebar' );
						?>
					</div> <!-- /.widget_area_inner -->
				</div> <!-- /.widget_area -->
				<?php
			}
		}
	}
}

// Check if sidebar present
if (!function_exists('smart_casa_sidebar_present')) {
	function smart_casa_sidebar_present() {
		global $wp_query;
		$sidebar_position = smart_casa_get_theme_option('sidebar_position');
		$sidebar_name = smart_casa_get_theme_option('sidebar_widgets');
		return apply_filters('smart_casa_filter_sidebar_present', 
					!smart_casa_is_off($sidebar_position) 
					&& !smart_casa_is_off($sidebar_name) 
					&& is_active_sidebar($sidebar_name)
					&& !is_404() 
					&& (!is_search() || $wp_query->found_posts > 0) 
					&& (!is_single() || smart_casa_is_off(smart_casa_get_theme_option('hide_sidebar_on_single'))) 
					);
	}
}


// Return text for the Privacy Policy checkbox
if ( ! function_exists('smart_casa_get_privacy_text' ) ) {
    function smart_casa_get_privacy_text() {
        $page = get_option( 'wp_page_for_privacy_policy' );
        $privacy_text = smart_casa_get_theme_option( 'privacy_text' );
        return apply_filters( 'smart_casa_filter_privacy_text', wp_kses(
            $privacy_text
            . ( ! empty( $page ) && ! empty( $privacy_text )
                // Translators: Add url to the Privacy Policy page
                ? ' ' . sprintf( esc_html__( 'For further details on handling user data, see our %s', 'smart-casa' ),
                        '<a href="' . esc_url( get_permalink( $page ) ) . '" target="_blank">'
                            . esc_html__( 'Privacy Policy', 'smart-casa' )
                        . '</a>' )
                : ''
                ), 'smart_casa_kses_content'
            )
        );
    }
}


	
/* Inline styles and scripts
------------------------------------------------------------------------------------- */

// Add inline styles and return class for it
if (!function_exists('smart_casa_add_inline_css_class')) {
	function smart_casa_add_inline_css_class($css, $suffix='') {
		$class_name = sprintf('smart_casa_inline_%d', mt_rand());
		smart_casa_add_inline_css(sprintf('.%s%s{%s}', $class_name, !empty($suffix) ? (substr($suffix, 0, 1) != ':' ? ' ' : '') . esc_attr($suffix) : '', $css));
		return $class_name;
	}
}

// Add inline styles
if (!function_exists('smart_casa_add_inline_css')) {
	function smart_casa_add_inline_css($css) {
		if (function_exists('trx_addons_add_inline_css'))
			trx_addons_add_inline_css($css);
		else
			smart_casa_storage_concat( 'inline_styles', $css );
	}
}

// Return inline styles
if (!function_exists('smart_casa_get_inline_css')) {
	function smart_casa_get_inline_css() {
		return smart_casa_storage_get('inline_styles');
	}
}



/* Date & Time
----------------------------------------------------------------------------------------------------- */

// Return post date
if (!function_exists('smart_casa_get_date')) {
	function smart_casa_get_date($dt='', $format='') {
		global $wp_query;
		if ($dt == '')
			$dt = get_the_time('U', $wp_query->current_post>=0 ? null : $wp_query->post->ID);
		if (date('U') - $dt > intval(smart_casa_get_theme_option('time_diff_before'))*24*3600)
			$dt = date_i18n($format=='' ? get_option('date_format') : $format, $dt);
		else {
			// Translators: Add the human-friendly date difference
			$dt = sprintf( esc_html__('%s ago', 'smart-casa'), human_time_diff($dt, current_time('timestamp')) );
		}
		return $dt;
	}
}



/* Structured Data
----------------------------------------------------------------------------------------------------- */

// Return markup schema
if (!function_exists('smart_casa_get_markup_schema')) {
	function smart_casa_get_markup_schema() {
	if (is_single())										// Is single post
		$type = "Article";
	else if (is_home() || is_archive() || is_category())	// Is blog home, archive or category
		$type = "Blog";
	else if(is_front_page())								// Is static front page
		$type = "Website";
	else													// Is a general page
		$type = 'WebPage';
	return $type;
	}
}

/* wp_kses handlers
----------------------------------------------------------------------------------------------------- */
if ( ! function_exists( 'smart_casa_kses_allowed_html' ) ) {
    add_filter( 'wp_kses_allowed_html', 'smart_casa_kses_allowed_html', 10, 2);
    function smart_casa_kses_allowed_html($tags, $context) {
        if ( in_array( $context, array( 'smart_casa_kses_content', 'trx_addons_kses_content' ) ) ) {
            $tags = array(
                'h1'     => array( 'id' => array(), 'class' => array(), 'title' => array(), 'align' => array() ),
                'h2'     => array( 'id' => array(), 'class' => array(), 'title' => array(), 'align' => array() ),
                'h3'     => array( 'id' => array(), 'class' => array(), 'title' => array(), 'align' => array() ),
                'h4'     => array( 'id' => array(), 'class' => array(), 'title' => array(), 'align' => array() ),
                'h5'     => array( 'id' => array(), 'class' => array(), 'title' => array(), 'align' => array() ),
                'h6'     => array( 'id' => array(), 'class' => array(), 'title' => array(), 'align' => array() ),
                'p'      => array( 'id' => array(), 'class' => array(), 'title' => array(), 'align' => array() ),
                'span'   => array( 'id' => array(), 'class' => array(), 'title' => array() ),
                'div'    => array( 'id' => array(), 'class' => array(), 'title' => array(), 'align' => array() ),
                'a'      => array( 'id' => array(), 'class' => array(), 'title' => array(), 'href' => array(), 'target' => array() ),
                'sub'    => array( 'id' => array(), 'class' => array(), 'title' => array() ),
                'sup'    => array( 'id' => array(), 'class' => array(), 'title' => array() ),
                'b'      => array( 'id' => array(), 'class' => array(), 'title' => array() ),
                'i'      => array( 'id' => array(), 'class' => array(), 'title' => array() ),
                'em'     => array( 'id' => array(), 'class' => array(), 'title' => array() ),
                'strong' => array( 'id' => array(), 'class' => array(), 'title' => array() ),
                'img'    => array( 'id' => array(), 'class' => array(), 'src' => array(), 'width' => array(), 'height' => array(), 'alt' => array() ),
                'br'     => array( 'clear' => array() ),
            );
        }
        return $tags;
    }
}
?>