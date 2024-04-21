<?php
/**
 * Theme functions: init, enqueue scripts and styles, include required files and widgets
 *
 * @package WordPress
 * @subpackage SMART_CASA
 * @since SMART_CASA 1.0
 */

if (!defined("SMART_CASA_THEME_DIR")) define("SMART_CASA_THEME_DIR", trailingslashit( get_template_directory() ));
if (!defined("SMART_CASA_CHILD_DIR")) define("SMART_CASA_CHILD_DIR", trailingslashit( get_stylesheet_directory() ));

/**
 * Fire the wp_body_open action.
 *
 * Added for backwards compatibility to support pre 5.2.0 WordPress versions.
 */
if ( ! function_exists( 'wp_body_open' ) ) {
    function wp_body_open() {
        /**
         * Triggered after the opening <body> tag.
         */
        do_action('wp_body_open');
    }
}

//-------------------------------------------------------
//-- Theme init
//-------------------------------------------------------

// Theme init priorities:
// Action 'after_setup_theme'
// 1 - register filters to add/remove lists items in the Theme Options
// 2 - create Theme Options
// 3 - add/remove Theme Options elements
// 5 - load Theme Options. Attention! After this step you can use only basic options (not overriden)
// 9 - register other filters (for installer, etc.)
//10 - standard Theme init procedures (not ordered)
// Action 'wp_loaded'
// 1 - detect override mode. Attention! Only after this step you can use overriden options (separate values for the shop, courses, etc.)

if ( !function_exists('smart_casa_theme_setup1') ) {
	add_action( 'after_setup_theme', 'smart_casa_theme_setup1', 1 );
	function smart_casa_theme_setup1() {
		// Make theme available for translation
		// Translations can be filed in the /languages directory
		// Attention! Translations must be loaded before first call any translation functions!
		load_theme_textdomain( 'smart-casa', get_template_directory() . '/languages' );
	}
}

if ( !function_exists('smart_casa_theme_setup') ) {
	add_action( 'after_setup_theme', 'smart_casa_theme_setup' );
	function smart_casa_theme_setup() {

		// Set theme content width
		$GLOBALS['content_width'] = apply_filters( 'smart_casa_filter_content_width', smart_casa_get_theme_option('page_width') );

		// Add default posts and comments RSS feed links to head 
		add_theme_support( 'automatic-feed-links' );
		
		// Custom header setup
		add_theme_support( 'custom-header', array(
			'header-text' => false,
			'video' => true
			)
		);
		
		// Custom logo
		add_theme_support( 'custom-logo', array(
			'width'       => 250,
			'height'      => 60,
			'flex-width'  => true,
			'flex-height' => true
			)
		);
		// Custom backgrounds setup
		add_theme_support( 'custom-background', array()	);

		// Partial refresh support in the Customize
		add_theme_support( 'customize-selective-refresh-widgets' );
		
		// Supported posts formats
		add_theme_support( 'post-formats', array('gallery', 'video', 'audio', 'link', 'quote', 'image', 'status', 'aside', 'chat') ); 
 
 		// Autogenerate title tag
		add_theme_support('title-tag');
 		
		// Add theme menus
		add_theme_support('nav-menus');
		
		// Switch default markup for search form, comment form, and comments to output valid HTML5.
		add_theme_support( 'html5', array('search-form', 'comment-form', 'comment-list', 'gallery', 'caption') );
		
		// Editor custom stylesheet - for user
		add_editor_style( array_merge(
			array(
				'css/editor-style.css',
				smart_casa_get_file_url('css/font-icons/css/fontello-embedded.css')
			),
			smart_casa_theme_fonts_for_editor()
			)
		);	
	
		// Register navigation menu
		register_nav_menus(array(
			'menu_main' => esc_html__('Main Menu', 'smart-casa'),
			'menu_mobile' => esc_html__('Mobile Menu', 'smart-casa')
			)
		);
		
		// Register theme-specific thumb sizes
		add_theme_support( 'post-thumbnails' );
		set_post_thumbnail_size(370, 0, false);
		$thumb_sizes = smart_casa_storage_get('theme_thumbs');
		$mult = smart_casa_get_theme_option('retina_ready', 1);
		if ($mult > 1) $GLOBALS['content_width'] = apply_filters( 'smart_casa_filter_content_width', 1170*$mult);
		foreach ($thumb_sizes as $k=>$v) {
			add_image_size( $k, $v['size'][0], $v['size'][1], $v['size'][2]);
			if ($mult > 1) add_image_size( $k.'-@retina', $v['size'][0]*$mult, $v['size'][1]*$mult, $v['size'][2]);
		}
		// Add new thumb names
		add_filter( 'image_size_names_choose',	'smart_casa_theme_thumbs_sizes' );

		// Excerpt filters
		add_filter( 'excerpt_length',			'smart_casa_excerpt_length' );
		add_filter( 'excerpt_more',				'smart_casa_excerpt_more' );
		
		// Add required meta tags in the head
		add_action('wp_head',		 			'smart_casa_wp_head', 0);
		
		// Load current page/post customization (if present)
		add_action('wp_footer',		 			'smart_casa_wp_footer');
		add_action('admin_footer',	 			'smart_casa_wp_footer');
		
		// Enqueue scripts and styles for frontend
		add_action('wp_enqueue_scripts', 		'smart_casa_wp_scripts', 1000);			// priority 1000 - load styles
																						// before the plugin's support custom styles
																						// (with priority 1100)
																						// and child-theme styles
																						// (with priority 1200)
		add_action('wp_enqueue_scripts', 		'smart_casa_wp_scripts_child', 1200);		// priority 1200 - load styles
																						// after the plugin's support custom styles
																						// (with priority 1100)
		add_action('wp_enqueue_scripts', 		'smart_casa_wp_scripts_responsive', 2000);	// priority 2000 - load responsive
																						// after all other styles
		add_action('wp_footer',		 			'smart_casa_localize_scripts');
		
		// Add body classes
		add_filter( 'body_class',				'smart_casa_add_body_classes' );

		// Register sidebars
		add_action('widgets_init',				'smart_casa_register_sidebars');
	}

}


//-------------------------------------------------------
//-- Theme scripts and styles
//-------------------------------------------------------

// Load frontend scripts
if ( !function_exists( 'smart_casa_wp_scripts' ) ) {
	
	function smart_casa_wp_scripts() {
		
		// Enqueue styles
		//------------------------
		
		// Links to selected fonts
		$links = smart_casa_theme_fonts_links();
		if (count($links) > 0) {
			foreach ($links as $slug => $link) {
				wp_enqueue_style( sprintf('smart-casa-font-%s', $slug), $link, array(), null );
			}
		}
		
		// Font icons styles must be loaded before main stylesheet
		// This style NEED the theme prefix, because style 'fontello' in some plugin contain different set of characters
		// and can't be used instead this style!
		wp_enqueue_style( 'fontello-icons',  smart_casa_get_file_url('css/font-icons/css/fontello-embedded.css'), array(), null );

		// Load main stylesheet
		$main_stylesheet = get_template_directory_uri() . '/style.css';
		wp_enqueue_style( 'smart-casa-main', $main_stylesheet, array(), null );

		// Add custom bg image for the Front page
		if ( is_front_page() 
			&& smart_casa_is_on(smart_casa_get_theme_option('front_page_enabled'))
			&& ($bg_image = smart_casa_remove_protocol_from_url(smart_casa_get_theme_option('front_page_bg_image'), false)) != '' )
			wp_add_inline_style( 'smart-casa-main', 'body.frontpage, body.home-page { background-image:url('.esc_url($bg_image).') !important }' );

		// Add custom bg image for the body_style == 'boxed'
		else if ( smart_casa_get_theme_option('body_style') == 'boxed' && ($bg_image = smart_casa_get_theme_option('boxed_bg_image')) != '' )
			wp_add_inline_style( 'smart-casa-main', '.body_style_boxed { background-image:url('.esc_url($bg_image).') !important }' );

		// Custom colors, fonts and other rules
		if ( !is_customize_preview() && !isset($_GET['color_scheme']) && smart_casa_is_off(smart_casa_get_theme_option('debug_mode')) ) {
			wp_enqueue_style( 'smart-casa-custom', smart_casa_get_file_url('css/__custom.css'), array(), null );
			if (smart_casa_get_theme_setting('separate_schemes')) {
				$schemes = smart_casa_get_sorted_schemes();
				if (is_array($schemes)) {
					foreach ($schemes as $scheme => $data) {
						wp_enqueue_style( "smart-casa-color-{$scheme}", smart_casa_get_file_url("css/__colors_{$scheme}.css"), array(), null );
					}
				}
			}
		} else
			wp_add_inline_style( 'smart-casa-main', smart_casa_customizer_get_css() );

		// Add post nav background
		smart_casa_add_bg_in_post_nav();


		// Enqueue scripts	
		//------------------------

		// Modernizr will load in head before other scripts and styles
		$need_masonry = (smart_casa_storage_get('blog_archive')===true
							&& in_array(substr(smart_casa_get_theme_option('blog_style'), 0, 7), array('gallery', 'portfol', 'masonry')))
						|| (is_single()
							&& str_replace('post-format-', '', get_post_format())=='gallery');
		if ( $need_masonry )
			wp_enqueue_script( 'modernizr', smart_casa_get_file_url('js/theme-gallery/modernizr.min.js'), array(), null, false );

		// Superfish Menu
		// Attention! To prevent duplicate this script in the plugin and in the menu, don't merge it!
		wp_enqueue_script( 'superfish', smart_casa_get_file_url('js/superfish/superfish.min.js'), array('jquery'), null, true );
		
		// Merged scripts
		if ( smart_casa_is_off(smart_casa_get_theme_option('debug_mode')) )
			wp_enqueue_script( 'smart-casa-init', smart_casa_get_file_url('js/__scripts.js'), array('jquery'), null, true );
		else {
			// Skip link focus
			wp_enqueue_script( 'skip-link-focus-fix', smart_casa_get_file_url('js/skip-link-focus-fix.js'), null, true );
			// Background video
			$header_video = smart_casa_get_header_video();
			if (!empty($header_video) && !smart_casa_is_inherit($header_video)) {
				if (smart_casa_is_youtube_url($header_video))
					wp_enqueue_script( 'tubular', smart_casa_get_file_url('js/jquery.tubular.js'), array('jquery'), null, true );
				else
					wp_enqueue_script( 'bideo', smart_casa_get_file_url('js/bideo.js'), array(), null, true );
			}
			// Theme scripts
			wp_enqueue_script( 'smart-casa-utils', smart_casa_get_file_url('js/theme-utils.js'), array('jquery'), null, true );
			wp_enqueue_script( 'smart-casa-init', smart_casa_get_file_url('js/theme-init.js'), array('jquery'), null, true );	
		}
		// Load scripts for 'Masonry' layout
		if ( $need_masonry ) {
			wp_enqueue_script( 'imagesloaded' );
			wp_enqueue_script( 'masonry' );
			wp_enqueue_script( 'classie', smart_casa_get_file_url('js/theme-gallery/classie.min.js'), array(), null, true );
			wp_enqueue_script( 'smart-casa-gallery-script', smart_casa_get_file_url('js/theme-gallery/theme-gallery.js'), array(), null, true );
		}
		// Load scripts for 'Portfolio' layout
		if ( smart_casa_storage_get('blog_archive')===true
				&& in_array(substr(smart_casa_get_theme_option('blog_style'), 0, 7), array('gallery', 'portfol'))
				&& !is_customize_preview())
			wp_enqueue_script('jquery-ui-tabs', false, array('jquery', 'jquery-ui-core'), null, true);
		
		// Comments
		if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
			wp_enqueue_script( 'comment-reply' );
		}

		// Media elements library	
		if (smart_casa_get_theme_setting('use_mediaelements')) {
			wp_enqueue_style ( 'mediaelement' );
			wp_enqueue_style ( 'wp-mediaelement' );
			wp_enqueue_script( 'mediaelement' );
			wp_enqueue_script( 'wp-mediaelement' );
		}
	}
}

// Load child-theme stylesheet (if different) after all styles (with priorities 1000 and 1100)
if ( !function_exists( 'smart_casa_wp_scripts_child' ) ) {
	
	function smart_casa_wp_scripts_child() {
		$main_stylesheet = get_template_directory_uri() . '/style.css';
		$child_stylesheet = get_stylesheet_directory_uri() . '/style.css';
		if ($child_stylesheet != $main_stylesheet) {
			wp_enqueue_style( 'smart-casa-child', $child_stylesheet, array('smart_casa-main'), null );
		}
	}
}

// Add variables to the scripts in the frontend
if ( !function_exists( 'smart_casa_localize_scripts' ) ) {
	
	function smart_casa_localize_scripts() {

		$video = smart_casa_get_header_video();

		wp_localize_script( 'smart-casa-init', 'SMART_CASA_STORAGE', apply_filters( 'smart_casa_filter_localize_script', array(
			// AJAX parameters
			'ajax_url' => esc_url(admin_url('admin-ajax.php')),
			'ajax_nonce' => esc_attr(wp_create_nonce(admin_url('admin-ajax.php'))),
			
			// Site base url
			'site_url' => get_site_url(),
			'theme_url' => get_template_directory_uri(),
						
			// Site color scheme
			'site_scheme' => sprintf('scheme_%s', smart_casa_get_theme_option('color_scheme')),
			
			// User logged in
			'user_logged_in' => is_user_logged_in() ? true : false,
			
			// Window width to switch the site header to the mobile layout
			'mobile_layout_width' => 767,
			'mobile_device' => wp_is_mobile(),
						
			// Sidemenu options
			'menu_side_stretch' => smart_casa_get_theme_option('menu_side_stretch') > 0 ? true : false,
			'menu_side_icons' => smart_casa_get_theme_option('menu_side_icons') > 0 ? true : false,

			// Video background
			'background_video' => smart_casa_is_from_uploads($video) ? $video : '',

			// Video and Audio tag wrapper
			'use_mediaelements' => smart_casa_get_theme_setting('use_mediaelements') ? true : false,
			
			// Current mode
			'admin_mode' => false,
			
			// Strings for translation
			'msg_ajax_error' => esc_html__('Invalid server answer!', 'smart-casa')
			))
		);
	}
}

// Load responsive styles (priority 2000 - load it after main styles and plugins custom styles)
if ( !function_exists( 'smart_casa_wp_scripts_responsive' ) ) {
	
	function smart_casa_wp_scripts_responsive() {
		wp_enqueue_style( 'smart-casa-responsive', smart_casa_get_file_url('css/responsive.css'), array(), null );
	}
}

//  Add meta tags and inline scripts in the header for frontend
if (!function_exists('smart_casa_wp_head')) {
	
	function smart_casa_wp_head() {
		?>
		<meta charset="<?php bloginfo( 'charset' ); ?>">
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
		<meta name="format-detection" content="telephone=no">
		<link rel="profile" href="//gmpg.org/xfn/11">
		<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
		<?php
	}
}

// Add theme specified classes to the body
if ( !function_exists('smart_casa_add_body_classes') ) {
	
	function smart_casa_add_body_classes( $classes ) {
		$classes[] = 'body_tag';	// Need for the .scheme_self
		$classes[] = 'scheme_' . esc_attr(smart_casa_get_theme_option('color_scheme'));

		$blog_mode = smart_casa_storage_get('blog_mode');
		$classes[] = 'blog_mode_' . esc_attr($blog_mode);
		$classes[] = 'body_style_' . esc_attr(smart_casa_get_theme_option('body_style'));

		if (in_array($blog_mode, array('post', 'page'))) {
			$classes[] = 'is_single';
		} else {
			$classes[] = ' is_stream';
			$classes[] = 'blog_style_'.esc_attr(smart_casa_get_theme_option('blog_style'));
			if (smart_casa_storage_get('blog_template') > 0)
				$classes[] = 'blog_template';
		}
		
		if (smart_casa_sidebar_present()) {
			$classes[] = 'sidebar_show sidebar_' . esc_attr(smart_casa_get_theme_option('sidebar_position')) ;
		} else {
			$classes[] = 'sidebar_hide';
			if (smart_casa_is_on(smart_casa_get_theme_option('expand_content')))
				 $classes[] = 'expand_content';
		}
		
		if (smart_casa_is_on(smart_casa_get_theme_option('remove_margins')))
			 $classes[] = 'remove_margins';

		if ( is_front_page() 
			&& smart_casa_is_on(smart_casa_get_theme_option('front_page_enabled')) 
			&& ($bg_image = smart_casa_get_theme_option('front_page_bg_image')) != '' )
			$classes[] = 'with_bg_image';

		$classes[] = 'trx_addons_' . esc_attr(smart_casa_exists_trx_addons() ? 'present' : 'absent');
		
		$classes[] = 'header_type_' . esc_attr(smart_casa_get_theme_option("header_type"));
		$classes[] = 'header_style_' . esc_attr(smart_casa_get_theme_option("header_type")=='default'
													? 'header-default'
													: smart_casa_get_theme_option("header_style"));
		$classes[] = 'header_position_' . esc_attr(smart_casa_get_theme_option("header_position"));

		$menu_style= smart_casa_get_theme_option("menu_style");
		$classes[] = 'menu_style_' . esc_attr($menu_style) . (in_array($menu_style, array('left', 'right'))	? ' menu_style_side' : '');
		$classes[] = 'no_layout';
		
		return $classes;
	}
}
	
// Load current page/post customization (if present)
if ( !function_exists( 'smart_casa_wp_footer' ) ) {
	
	//and add_action('admin_footer', 'smart_casa_wp_footer');
	function smart_casa_wp_footer() {
		// Add header zoom
		$header_zoom = max(0.3, min(2, (float) smart_casa_get_theme_option('header_zoom')));
		if ( $header_zoom != 1 ) smart_casa_add_inline_css(".sc_layouts_title_title{font-size:{$header_zoom}em}");
		// Add logo zoom
		$logo_zoom = max(0.3, min(2, (float) smart_casa_get_theme_option('logo_zoom')));
		if ( $logo_zoom != 1 ) smart_casa_add_inline_css(".custom-logo-link,.sc_layouts_logo{font-size:{$logo_zoom}em}");
		// Put inline styles to the output
		if (($css = smart_casa_get_inline_css()) != '') {
			wp_enqueue_style(  'smart-casa-inline-styles',  smart_casa_get_file_url('css/__inline.css'), array(), null );
			wp_add_inline_style( 'smart-casa-inline-styles', $css );
		}
	}
}


//-------------------------------------------------------
//-- Sidebars and widgets
//-------------------------------------------------------

// Register widgetized areas
if ( !function_exists('smart_casa_register_sidebars') ) {
	
	function smart_casa_register_sidebars() {
		$sidebars = smart_casa_get_sidebars();
		if (is_array($sidebars) && count($sidebars) > 0) {
			foreach ($sidebars as $id=>$sb) {
				register_sidebar( array(
										'name'          => $sb['name'],
										'description'   => esc_html($sb['description']),
										'id'            => esc_attr($id),
										'before_widget' => '<aside id="%1$s" class="widget %2$s">',
										'after_widget'  => '</aside>',
										'before_title'  => '<h5 class="widget_title">',
										'after_title'   => '</h5>'
										)
								);
			}
		}
	}
}

// Return theme specific widgetized areas
if ( !function_exists('smart_casa_get_sidebars') ) {
	function smart_casa_get_sidebars() {
		$list = apply_filters('smart_casa_filter_list_sidebars', array(
			'sidebar_widgets'		=> array(
							'name' => esc_html__('Sidebar Widgets', 'smart-casa'),
							'description' => esc_html__('Widgets to be shown on the main sidebar', 'smart-casa')
							),
			'header_widgets'		=> array(
							'name' => esc_html__('Header Widgets', 'smart-casa'),
							'description' => esc_html__('Widgets to be shown at the top of the page (in the page header area)', 'smart-casa')
							),
			'above_page_widgets'	=> array(
							'name' => esc_html__('Top Page Widgets', 'smart-casa'),
							'description' => esc_html__('Widgets to be shown below the header, but above the content and sidebar', 'smart-casa')
							),
			'above_content_widgets' => array(
							'name' => esc_html__('Above Content Widgets', 'smart-casa'),
							'description' => esc_html__('Widgets to be shown above the content, near the sidebar', 'smart-casa')
							),
			'below_content_widgets' => array(
							'name' => esc_html__('Below Content Widgets', 'smart-casa'),
							'description' => esc_html__('Widgets to be shown below the content, near the sidebar', 'smart-casa')
							),
			'below_page_widgets' 	=> array(
							'name' => esc_html__('Bottom Page Widgets', 'smart-casa'),
							'description' => esc_html__('Widgets to be shown below the content and sidebar, but above the footer', 'smart-casa')
							),
			'footer_widgets'		=> array(
							'name' => esc_html__('Footer Widgets', 'smart-casa'),
							'description' => esc_html__('Widgets to be shown at the bottom of the page (in the page footer area)', 'smart-casa')
							)
			)
		);
		return $list;
	}
}


//-------------------------------------------------------
//-- Theme fonts
//-------------------------------------------------------

// Return links for all theme fonts
if ( !function_exists('smart_casa_theme_fonts_links') ) {
	function smart_casa_theme_fonts_links() {
		$links = array();
		
		/*
		Translators: If there are characters in your language that are not supported
		by chosen font(s), translate this to 'off'. Do not translate into your own language.
		*/
		$google_fonts_enabled = ( 'off' !== esc_html_x( 'on', 'Google fonts: on or off', 'smart-casa' ) );
		$custom_fonts_enabled = ( 'off' !== esc_html_x( 'on', 'Custom fonts (included in the theme): on or off', 'smart-casa' ) );
		
		if ( ($google_fonts_enabled || $custom_fonts_enabled) && !smart_casa_storage_empty('load_fonts') ) {
			$load_fonts = smart_casa_storage_get('load_fonts');
			if (count($load_fonts) > 0) {
				$google_fonts = '';
				foreach ($load_fonts as $font) {
					$url = '';
					if ($custom_fonts_enabled && empty($font['styles'])) {
						$slug = smart_casa_get_load_fonts_slug($font['name']);
						$url  = smart_casa_get_file_url( sprintf('css/font-face/%s/stylesheet.css', $slug));
						if ($url != '') $links[$slug] = $url;
					}
					if ($google_fonts_enabled && empty($url)) {
						$google_fonts .= ($google_fonts ? '%7C' : '')
										. str_replace(' ', '+', $font['name'])
										. ':' 
										. (empty($font['styles']) ? '400,400italic,700,700italic' : $font['styles']);
					}
				}
				if ($google_fonts && $google_fonts_enabled) {
					$links['google_fonts'] = sprintf('%s://fonts.googleapis.com/css?family=%s&subset=%s', smart_casa_get_protocol(), $google_fonts, smart_casa_get_theme_option('load_fonts_subset'));
				}
			}
		}
		return $links;
	}
}

// Return links for WP Editor
if ( !function_exists('smart_casa_theme_fonts_for_editor') ) {
	function smart_casa_theme_fonts_for_editor() {
		$links = array_values(smart_casa_theme_fonts_links());
		if (is_array($links) && count($links) > 0) {
			for ($i=0; $i<count($links); $i++) {
				$links[$i] = str_replace(',', '%2C', $links[$i]);
			}
		}
		return $links;
	}
}


//-------------------------------------------------------
//-- The Excerpt
//-------------------------------------------------------
if ( !function_exists('smart_casa_excerpt_length') ) {
	function smart_casa_excerpt_length( $length ) {
		return max(1, smart_casa_get_theme_option('excerpt_length'));
	}
}

if ( !function_exists('smart_casa_excerpt_more') ) {
	function smart_casa_excerpt_more( $more ) {
		return '&hellip;';
	}
}




//-------------------------------------------------------
//-- Thumb sizes
//-------------------------------------------------------
if ( !function_exists('smart_casa_theme_thumbs_sizes') ) {
	
	function smart_casa_theme_thumbs_sizes( $sizes ) {
		$thumb_sizes = smart_casa_storage_get('theme_thumbs');
		$mult = smart_casa_get_theme_option('retina_ready', 1);
		foreach($thumb_sizes as $k=>$v) {
			$sizes[$k] = $v['title'];
			if ($mult > 1) $sizes[$k.'-@retina'] = $v['title'].' '.esc_html__('@2x', 'smart-casa' );
		}
		return $sizes;
	}
}



//-------------------------------------------------------
//-- Include theme (or child) PHP-files
//-------------------------------------------------------

require_once SMART_CASA_THEME_DIR . 'includes/utils.php';
require_once SMART_CASA_THEME_DIR . 'includes/storage.php';
require_once SMART_CASA_THEME_DIR . 'includes/lists.php';
require_once SMART_CASA_THEME_DIR . 'includes/wp.php';

if (is_admin()) {
	require_once SMART_CASA_THEME_DIR . 'includes/tgmpa/class-tgm-plugin-activation.php';
	require_once SMART_CASA_THEME_DIR . 'includes/admin.php';
}

require_once SMART_CASA_THEME_DIR . 'theme-options/theme-customizer.php';

require_once SMART_CASA_THEME_DIR . 'front-page/front-page-options.php';

require_once SMART_CASA_THEME_DIR . 'theme-specific/theme-tags.php';
require_once SMART_CASA_THEME_DIR . 'theme-specific/theme-hovers/theme-hovers.php';
require_once SMART_CASA_THEME_DIR . 'theme-specific/theme-about/theme-about.php';

if (SMART_CASA_THEME_FREE) {
	require_once SMART_CASA_THEME_DIR . 'theme-specific/theme-about/theme-upgrade.php';
}


// Plugins support
if (is_array($SMART_CASA_STORAGE['required_plugins']) && count($SMART_CASA_STORAGE['required_plugins']) > 0) {
	foreach ($SMART_CASA_STORAGE['required_plugins'] as $plugin_slug => $plugin_name) {
		$plugin_slug = smart_casa_esc($plugin_slug);
		$plugin_path = SMART_CASA_THEME_DIR . sprintf('plugins/%s/%s.php', $plugin_slug, $plugin_slug);
		if (file_exists($plugin_path)) { require_once $plugin_path; }
	}
}
?>