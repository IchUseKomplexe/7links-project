<?php
/**
 * Setup theme-specific fonts and colors
 *
 * @package WordPress
 * @subpackage SMART_CASA
 * @since SMART_CASA 1.0.22
 */

if (!defined("SMART_CASA_THEME_FREE"))		define("SMART_CASA_THEME_FREE", false);
if (!defined("SMART_CASA_THEME_FREE_WP"))	define("SMART_CASA_THEME_FREE_WP", false);

// Theme storage
$SMART_CASA_STORAGE = array(
	// Theme required plugin's slugs
	'required_plugins' => array_merge(

		// List of plugins for both - FREE and PREMIUM versions
		//-----------------------------------------------------
		array(
			// Required plugins
			// DON'T COMMENT OR REMOVE NEXT LINES!
			'trx_addons'					=> esc_html__('ThemeREX Addons', 'smart-casa'),
			
			// Recommended (supported) plugins fot both (lite and full) versions
			// If plugin not need - comment (or remove) it
            'trx_updater'				    => esc_html__('ThemeREX Updater', 'smart-casa'),
			'contact-form-7'				=> esc_html__('Contact Form 7', 'smart-casa'),
			'mailchimp-for-wp'				=> esc_html__('MailChimp for WP', 'smart-casa'),
			'woocommerce'					=> esc_html__('WooCommerce', 'smart-casa'),
			'date-time-picker-field'	    => esc_html__('Date Time Picker Field', 'smart-casa'),
            'elegro-payment'				=> esc_html__('Elegro Crypto Payment', 'smart-casa'),
			'wp-gdpr-compliance'			=> esc_html__('Cookie Information', 'smart-casa')
		),

		// List of plugins for the FREE version only
		//-----------------------------------------------------
		SMART_CASA_THEME_FREE 
			? array(
					// Recommended (supported) plugins for the FREE (lite) version

					) 

		// List of plugins for the PREMIUM version only
		//-----------------------------------------------------
			: array(
					// Recommended (supported) plugins for the PRO (full) version
					// If plugin not need - comment (or remove) it
					'essential-grid'			=> esc_html__('Essential Grid', 'smart-casa'),
					'revslider'					=> esc_html__('Revolution Slider', 'smart-casa'),
					'js_composer'				=> esc_html__('WPBakery PageBuilder', 'smart-casa'),
					)
	),

	// Key validator: market[env|loc]-vendor[axiom|ancora|themerex]
	'theme_pro_key'		=> SMART_CASA_THEME_FREE 
								? 'env-axiom'
								: '',


	// Theme-specific URLs (will be escaped in place of the output)
	'theme_demo_url'	=> '//smart-casa.axiomthemes.com',
	'theme_doc_url'		=> '//smart-casa.axiomthemes.com/doc',
	'theme_download_url'=> 'https://1.envato.market/c/1262870/275988/4415?subId1=axioma&u=themeforest.net/item/smart-casa-home-automation-technologies-wordpress-theme/22077415',
	'theme_support_url'	=> 'https://themerex.net/support/',									// Axiom
	'theme_video_url'	=> 'https://www.youtube.com/channel/UCBjqhuwKj3MfE3B6Hg2oA8Q',	// Axiom

	// Comma separated slugs of theme-specific categories (for get relevant news in the dashboard widget)
	// (i.e. 'children,kindergarten')
	'theme_categories'  => '',

	// Responsive resolutions
	// Parameters to create css media query: min, max
	'responsive'		=> array(
						// By device
						'desktop'	=> array('min' => 1680),
						'notebook'	=> array('min' => 1280, 'max' => 1679),
						'tablet'	=> array('min' =>  768, 'max' => 1279),
						'mobile'	=> array('max' =>  767),
						// By size
						'xxxl'		=> array('min' => 1921),
						'xxl'		=> array('max' => 1679),
						'xl'		=> array('max' => 1439),
						'lg'		=> array('max' => 1279),
						'md'		=> array('max' => 1023),
						'sm'		=> array('max' =>  767),
						'sm_wp'		=> array('max' =>  600),
						'xs'		=> array('max' =>  479)
						)
);

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

if ( !function_exists('smart_casa_customizer_theme_setup1') ) {
	add_action( 'after_setup_theme', 'smart_casa_customizer_theme_setup1', 1 );
	function smart_casa_customizer_theme_setup1() {

		// -----------------------------------------------------------------
		// -- ONLY FOR PROGRAMMERS, NOT FOR CUSTOMER
		// -- Internal theme settings
		// -----------------------------------------------------------------
		smart_casa_storage_set('settings', array(
			
			'duplicate_options'		=> 'child',		// none  - use separate options for the main and the child-theme
													// child - duplicate theme options from the main theme to the child-theme only
													// both  - sinchronize changes in the theme options between main and child themes

			'customize_refresh'		=> 'auto',		// Refresh method for preview area in the Appearance - Customize:
													// auto - refresh preview area on change each field with Theme Options
													// manual - refresh only obn press button 'Refresh' at the top of Customize frame

			'max_load_fonts'		=> 5,			// Max fonts number to load from Google fonts or from uploaded fonts

			'comment_after_name'	=> true,		// Place 'comment' field before the 'name' and 'email'

			'socials_type'			=> 'icons',		// Type of socials:
													// icons - use font icons to present social networks
													// images - use images from theme's folder trx_addons/css/icons.png

			'icons_type'			=> 'icons',		// Type of other icons:
													// icons - use font icons to present icons
													// images - use images from theme's folder trx_addons/css/icons.png

			'icons_selector'		=> 'internal',	// Icons selector in the shortcodes:
													// standard VC or Elementor's icons selector (very slow and don't support images)
													// internal - internal popup with plugin's or theme's icons list (fast)
			'check_min_version'		=> true,		// Check if exists a .min version of .css and .js and return path to it
													// instead the path to the original file
													// (if debug_mode is off and modification time of the original file < time of the .min file)
			'autoselect_menu'		=> true,		// Show any menu if no menu selected in the location 'main_menu'
													// (for example, the theme is just activated)
			'disable_jquery_ui'		=> false,		// Prevent loading custom jQuery UI libraries in the third-party plugins
		
			'use_mediaelements'		=> true,		// Load script "Media Elements" to play video and audio
			
			'tgmpa_upload'			=> false,		// Allow upload not pre-packaged plugins via TGMPA
			
			'allow_no_image'		=> false,		// Allow use image placeholder if no image present in the blog, related posts, post navigation, etc.

			'separate_schemes'		=> true, 		// Save color schemes to the separate files __color_xxx.css (true) or append its to the __custom.css (false)

			'allow_fullscreen'		=> false 		// Allow cases 'fullscreen' and 'fullwide' for the body style in the Theme Options
													// In the Page Options this styles are present always (can be removed if filter 'smart_casa_filter_allow_fullscreen' return false)
		));


		// -----------------------------------------------------------------
		// -- Theme fonts (Google and/or custom fonts)
		// -----------------------------------------------------------------
		
		// Fonts to load when theme start
		// It can be Google fonts or uploaded fonts, placed in the folder /css/font-face/font-name inside the theme folder
		// Attention! Font's folder must have name equal to the font's name, with spaces replaced on the dash '-'
		
		smart_casa_storage_set('load_fonts', array(
			// Google font
			array(
                'name'	 => 'Frank Ruhl Libre',
                'family' => 'serif',
                'styles' => '300,400,500,700'		// Parameter 'style' used only for the Google fonts
            ),
            array(
                'name'	 => 'Muli',
                'family' => 'sans-serif',
                'styles' => '300,300i,400,400i,600,600i,700,700i'		// Parameter 'style' used only for the Google fonts
            ),

		));
		
		// Characters subset for the Google fonts. Available values are: latin,latin-ext,cyrillic,cyrillic-ext,greek,greek-ext,vietnamese
		smart_casa_storage_set('load_fonts_subset', 'latin,latin-ext');
		
		// Settings of the main tags
		// Attention! Font name in the parameter 'font-family' will be enclosed in the quotes and no spaces after comma!

		smart_casa_storage_set('theme_fonts', array(
			'p' => array(
				'title'				=> esc_html__('Main text', 'smart-casa'),
				'description'		=> esc_html__('Font settings of the main text of the site. Attention! For correct display of the site on mobile devices, use only units "rem", "em" or "ex"', 'smart-casa'),
				'font-family'		=> '"Frank Ruhl Libre",serif',
				'font-size' 		=> '1rem',
				'font-weight'		=> '500',
				'font-style'		=> 'normal',
				'line-height'		=> '1.5em',
				'text-decoration'	=> 'none',
				'text-transform'	=> 'none',
				'letter-spacing'	=> '',
				'margin-top'		=> '0em',
				'margin-bottom'		=> '1.5em'
				),
			'h1' => array(
				'title'				=> esc_html__('Heading 1', 'smart-casa'),
				'font-family'		=> '"Frank Ruhl Libre",serif',
				'font-size' 		=> '4.500em',
				'font-weight'		=> '700',
				'font-style'		=> 'normal',
				'line-height'		=> '1.065em',
				'text-decoration'	=> 'none',
				'text-transform'	=> 'none',
				'letter-spacing'	=> '-0.4px',
				'margin-top'		=> '1.5817em',
				'margin-bottom'		=> '0.5733em'
				),
			'h2' => array(
				'title'				=> esc_html__('Heading 2', 'smart-casa'),
				'font-family'		=> '"Frank Ruhl Libre",serif',
				'font-size' 		=> '4.000em',
				'font-weight'		=> '700',
				'font-style'		=> 'normal',
				'line-height'		=> '1.0652em',
				'text-decoration'	=> 'none',
				'text-transform'	=> 'none',
				'letter-spacing'	=> '-0.2px',
				'margin-top'		=> '1.7852em',
				'margin-bottom'		=> '0.7619em'
				),
			'h3' => array(
				'title'				=> esc_html__('Heading 3', 'smart-casa'),
				'font-family'		=> '"Frank Ruhl Libre",serif',
				'font-size' 		=> '3.250em',
				'font-weight'		=> '700',
				'font-style'		=> 'normal',
				'line-height'		=> '1.1615em',
				'text-decoration'	=> 'none',
				'text-transform'	=> 'none',
				'letter-spacing'	=> '-0.2px',
				'margin-top'		=> '2.1975em',
				'margin-bottom'		=> '0.7879em'
				),
			'h4' => array(
				'title'				=> esc_html__('Heading 4', 'smart-casa'),
				'font-family'		=> '"Frank Ruhl Libre",serif',
				'font-size' 		=> '2.500em',
				'font-weight'		=> '700',
				'font-style'		=> 'normal',
				'line-height'		=> '1.1177em',
				'text-decoration'	=> 'none',
				'text-transform'	=> 'none',
				'letter-spacing'	=> '-0.2px',
				'margin-top'		=> '2.134em',
				'margin-bottom'		=> '0.944em'
				),
			'h5' => array(
				'title'				=> esc_html__('Heading 5', 'smart-casa'),
				'font-family'		=> '"Frank Ruhl Libre",serif',
				'font-size' 		=> '2.000em',
				'font-weight'		=> '700',
				'font-style'		=> 'normal',
				'line-height'		=> '1.13em',
				'text-decoration'	=> 'none',
				'text-transform'	=> 'none',
				'letter-spacing'	=> '0px',
				'margin-top'		=> '2.495em',
				'margin-bottom'		=> '1.2em'
				),
			'h6' => array(
				'title'				=> esc_html__('Heading 6', 'smart-casa'),
				'font-family'		=> '"Frank Ruhl Libre",serif',
				'font-size' 		=> '1.250em',
				'font-weight'		=> '700',
				'font-style'		=> 'normal',
				'line-height'		=> '1.2306em',
				'text-decoration'	=> 'none',
				'text-transform'	=> 'none',
				'letter-spacing'	=> '0px',
				'margin-top'		=> '3.206em',
				'margin-bottom'		=> '0.9112em'
				),
			'logo' => array(
				'title'				=> esc_html__('Logo text', 'smart-casa'),
				'description'		=> esc_html__('Font settings of the text case of the logo', 'smart-casa'),
				'font-family'		=> '"Frank Ruhl Libre",serif',
				'font-size' 		=> '1.8em',
				'font-weight'		=> '400',
				'font-style'		=> 'normal',
				'line-height'		=> '1.25em',
				'text-decoration'	=> 'none',
				'text-transform'	=> 'uppercase',
				'letter-spacing'	=> '1px'
				),
			'button' => array(
				'title'				=> esc_html__('Buttons', 'smart-casa'),
				'font-family'		=> '"Muli",sans-serif',
				'font-size' 		=> '14px',
				'font-weight'		=> '700',
				'font-style'		=> 'normal',
				'line-height'		=> '24px',
				'text-decoration'	=> 'none',
				'text-transform'	=> 'uppercase',
				'letter-spacing'	=> '2px'
				),
            'button-small' => array(
                'title'				=> esc_html__('Small Buttons', 'smart-casa'),
                'font-family'		=> '"Muli",sans-serif',
                'font-size' 		=> '13px',
                'font-weight'		=> '700',
                'font-style'		=> 'normal',
                'line-height'		=> '21px',
                'text-decoration'	=> 'none',
                'text-transform'	=> 'uppercase',
                'letter-spacing'	=> '2px'
                ),
			'input' => array(
				'title'				=> esc_html__('Input fields', 'smart-casa'),
				'description'		=> esc_html__('Font settings of the input fields, dropdowns and textareas', 'smart-casa'),
				'font-family'		=> 'inherit',
				'font-size' 		=> '18px',
				'font-weight'		=> '500',
				'font-style'		=> 'normal',
				'line-height'		=> '1.5em',	// Attention! Firefox don't allow line-height less then 1.5em in the select
				'text-decoration'	=> 'none',
				'text-transform'	=> 'none',
				'letter-spacing'	=> '0px'
				),
			'info' => array(
				'title'				=> esc_html__('Post meta', 'smart-casa'),
				'description'		=> esc_html__('Font settings of the post meta: date, counters, share, etc.', 'smart-casa'),
				'font-family'		=> 'inherit',
				'font-size' 		=> '16px',
				'font-weight'		=> '500',
				'font-style'		=> 'normal',
				'line-height'		=> '1.3em',
				'text-decoration'	=> 'none',
				'text-transform'	=> 'none',
				'letter-spacing'	=> '0px',
				'margin-top'		=> '0.5em',
				'margin-bottom'		=> ''
				),
			'menu' => array(
				'title'				=> esc_html__('Main menu', 'smart-casa'),
				'description'		=> esc_html__('Font settings of the main menu items', 'smart-casa'),
				'font-family'		=> '"Muli",sans-serif',
				'font-size' 		=> '15px',
				'font-weight'		=> '700',
				'font-style'		=> 'normal',
				'line-height'		=> '1.5em',
				'text-decoration'	=> 'none',
				'text-transform'	=> 'uppercase',
				'letter-spacing'	=> '2px'
				),
			'submenu' => array(
				'title'				=> esc_html__('Dropdown menu', 'smart-casa'),
				'description'		=> esc_html__('Font settings of the dropdown menu items', 'smart-casa'),
				'font-family'		=> '"Muli",sans-serif',
				'font-size' 		=> '15px',
				'font-weight'		=> '700',
				'font-style'		=> 'normal',
				'line-height'		=> '1.5em',
				'text-decoration'	=> 'none',
				'text-transform'	=> 'uppercase',
				'letter-spacing'	=> '2px'
				)
		));
		
		
		// -----------------------------------------------------------------
		// -- Theme colors for customizer
		// -- Attention! Inner scheme must be last in the array below
		// -----------------------------------------------------------------
		smart_casa_storage_set('scheme_color_groups', array(
			'main'	=> array(
							'title'			=> esc_html__('Main', 'smart-casa'),
							'description'	=> esc_html__('Colors of the main content area', 'smart-casa')
							),
			'alter'	=> array(
							'title'			=> esc_html__('Alter', 'smart-casa'),
							'description'	=> esc_html__('Colors of the alternative blocks (sidebars, etc.)', 'smart-casa')
							),
			'extra'	=> array(
							'title'			=> esc_html__('Extra', 'smart-casa'),
							'description'	=> esc_html__('Colors of the extra blocks (dropdowns, price blocks, table headers, etc.)', 'smart-casa')
							),
			'inverse' => array(
							'title'			=> esc_html__('Inverse', 'smart-casa'),
							'description'	=> esc_html__('Colors of the inverse blocks - when link color used as background of the block (dropdowns, blockquotes, etc.)', 'smart-casa')
							),
			'input'	=> array(
							'title'			=> esc_html__('Input', 'smart-casa'),
							'description'	=> esc_html__('Colors of the form fields (text field, textarea, select, etc.)', 'smart-casa')
							),
			)
		);
		smart_casa_storage_set('scheme_color_names', array(
			'bg_color'	=> array(
							'title'			=> esc_html__('Background color', 'smart-casa'),
							'description'	=> esc_html__('Background color of this block in the normal state', 'smart-casa')
							),
			'bg_hover'	=> array(
							'title'			=> esc_html__('Background hover', 'smart-casa'),
							'description'	=> esc_html__('Background color of this block in the hovered state', 'smart-casa')
							),
			'bd_color'	=> array(
							'title'			=> esc_html__('Border color', 'smart-casa'),
							'description'	=> esc_html__('Border color of this block in the normal state', 'smart-casa')
							),
			'bd_hover'	=>  array(
							'title'			=> esc_html__('Border hover', 'smart-casa'),
							'description'	=> esc_html__('Border color of this block in the hovered state', 'smart-casa')
							),
			'text'		=> array(
							'title'			=> esc_html__('Text', 'smart-casa'),
							'description'	=> esc_html__('Color of the plain text inside this block', 'smart-casa')
							),
			'text_dark'	=> array(
							'title'			=> esc_html__('Text dark', 'smart-casa'),
							'description'	=> esc_html__('Color of the dark text (bold, header, etc.) inside this block', 'smart-casa')
							),
			'text_light'=> array(
							'title'			=> esc_html__('Text light', 'smart-casa'),
							'description'	=> esc_html__('Color of the light text (post meta, etc.) inside this block', 'smart-casa')
							),
			'text_link'	=> array(
							'title'			=> esc_html__('Link', 'smart-casa'),
							'description'	=> esc_html__('Color of the links inside this block', 'smart-casa')
							),
			'text_hover'=> array(
							'title'			=> esc_html__('Link hover', 'smart-casa'),
							'description'	=> esc_html__('Color of the hovered state of links inside this block', 'smart-casa')
							),
			'text_link2'=> array(
							'title'			=> esc_html__('Link 2', 'smart-casa'),
							'description'	=> esc_html__('Color of the accented texts (areas) inside this block', 'smart-casa')
							),
			'text_hover2'=> array(
							'title'			=> esc_html__('Link 2 hover', 'smart-casa'),
							'description'	=> esc_html__('Color of the hovered state of accented texts (areas) inside this block', 'smart-casa')
							),
			'text_link3'=> array(
							'title'			=> esc_html__('Link 3', 'smart-casa'),
							'description'	=> esc_html__('Color of the other accented texts (buttons) inside this block', 'smart-casa')
							),
			'text_hover3'=> array(
							'title'			=> esc_html__('Link 3 hover', 'smart-casa'),
							'description'	=> esc_html__('Color of the hovered state of other accented texts (buttons) inside this block', 'smart-casa')
							)
			)
		);
		smart_casa_storage_set('schemes', array(
		
			// Color scheme: 'default'
			'default' => array(
				'title'	 => esc_html__('Default', 'smart-casa'),
				'internal' => true,
				'colors' => array(
					
					// Whole block border and background
					'bg_color'			=> '#ffffff', //ok
					'bd_color'			=> '#e3e7e8', //ok
		
					// Text and links colors
					'text'				=> '#728288', //ok
					'text_light'		=> '#a7bac1', //ok
					'text_dark'			=> '#171e43', //ok
					'text_link'			=> '#390eb2', //ok
					'text_hover'		=> '#1aceff', //ok
					'text_link2'		=> '#d1f5ff', //ok light blue
					'text_hover2'		=> '#1aceff', //ok blue
					'text_link3'		=> '#1aceff', //ok blue
					'text_hover3'		=> '#390eb2', //ok violet
		
					// Alternative blocks (sidebar, tabs, alternative blocks, etc.)
					'alter_bg_color'	=> '#f2f4f5', //ok
					'alter_bg_hover'	=> '#e3e7e8', //ok
					'alter_bd_color'	=> '#e3e7e8', //ok
					'alter_bd_hover'	=> '#ffffff', //ok
					'alter_text'		=> '#728288', //ok
					'alter_light'		=> '#a7bac1', //ok
					'alter_dark'		=> '#171e43', //ok
					'alter_link'		=> '#1aceff', //ok
					'alter_hover'		=> '#2f127e', //ok
					'alter_link2'		=> '#d1f5ff', //ok
					'alter_hover2'		=> '#1aceff', //ok
					'alter_link3'		=> '#a7bac1', //ok
					'alter_hover3'		=> '#ddb837',
		
					// Extra blocks (submenu, tabs, color blocks, etc.)
					'extra_bg_color'	=> '#2f127e', //ok
					'extra_bg_hover'	=> '#171e43', //ok
					'extra_bd_color'	=> '#4d2690', //ok
					'extra_bd_hover'	=> '#e6eaeb', //ok
					'extra_text'		=> '#ffffff', //ok
					'extra_light'		=> '#a7bac1', //ok
					'extra_dark'		=> '#ffffff', //ok
					'extra_link'		=> '#1aceff', //ok
					'extra_hover'		=> '#390eb2', //ok
					'extra_link2'		=> '#390eb2', //ok
					'extra_hover2'		=> '#1aceff', //ok
					'extra_link3'		=> '#1aceff', //ok
					'extra_hover3'		=> '#eec432',
		
					// Input fields (form's fields and textarea)
					'input_bg_color'	=> '#e3e7e8', //ok
					'input_bg_hover'	=> '#e3e7e8', //ok
					'input_bd_color'	=> '#e3e7e8', //ok
					'input_bd_hover'	=> '#1aceff', //ok
					'input_text'		=> '#728288', //ok
					'input_light'		=> '#728288', //ok
					'input_dark'		=> '#728288', //ok
					
					// Inverse blocks (text and links on the 'text_link' background)
					'inverse_bd_color'	=> '#67bcc1',
					'inverse_bd_hover'	=> '#5aa4a9',
					'inverse_text'		=> '#ffffff', //ok
					'inverse_light'		=> '#7b959e', //ok
					'inverse_dark'		=> '#171e43', //ok
					'inverse_link'		=> '#ffffff', //ok
					'inverse_hover'		=> '#ffffff'  //ok
				)
			),
		
			// Color scheme: 'dark'
			'dark' => array(
				'title'  => esc_html__('Dark', 'smart-casa'),
				'internal' => true,
				'colors' => array(
					
					// Whole block border and background
					'bg_color'			=> '#290e72', //ok
					'bd_color'			=> '#51408e', //ok
		
					// Text and links colors
					'text'				=> '#8981a0', //ok
					'text_light'		=> '#8981a0', //ok
					'text_dark'			=> '#ffffff', //ok
					'text_link'			=> '#1aceff', //ok
					'text_hover'		=> '#ffffff', //ok
					'text_link2'		=> '#d1f5ff', //ok light blue
					'text_hover2'		=> '#1aceff', //ok blue
					'text_link3'		=> '#1aceff', //ok
					'text_hover3'		=> '#390eb2', //ok violet

					// Alternative blocks (sidebar, tabs, alternative blocks, etc.)
					'alter_bg_color'	=> '#2f127e', //ok
					'alter_bg_hover'	=> '#51408e', //ok
					'alter_bd_color'	=> '#51408e', //ok
					'alter_bd_hover'	=> '#51408e', //ok
					'alter_text'		=> '#8981a0', //ok
					'alter_light'		=> '#8981a0', //ok
					'alter_dark'		=> '#ffffff', //ok
					'alter_link'		=> '#ffffff', //ok
					'alter_hover'		=> '#1aceff', //ok
					'alter_link2'		=> '#d1f5ff', //ok
					'alter_hover2'		=> '#1aceff', //ok
					'alter_link3'		=> '#ffffff', //ok
					'alter_hover3'		=> '#ddb837',

					// Extra blocks (submenu, tabs, color blocks, etc.)
					'extra_bg_color'	=> '#ffffff', //ok
					'extra_bg_hover'	=> '#e3e7e8', //ok
					'extra_bd_color'	=> '#e3e7e8', //ok
					'extra_bd_hover'	=> '#51408e', //ok
					'extra_text'		=> '#728288', //ok
					'extra_light'		=> '#a7bac1', //ok
					'extra_dark'		=> '#171e43', //ok
					'extra_link'		=> '#390eb2', //ok
					'extra_hover'		=> '#1aceff', //ok
					'extra_link2'		=> '#ffffff', //ok
					'extra_hover2'		=> '#390eb2', //ok
					'extra_link3'		=> '#2f127e', //ok
					'extra_hover3'		=> '#eec432',

					// Input fields (form's fields and textarea)
					'input_bg_color'	=> '#51408e', //ok
					'input_bg_hover'	=> '#51408e', //ok
					'input_bd_color'	=> '#51408e', //ok
					'input_bd_hover'	=> '#ffffff', //ok
					'input_text'		=> '#8981a0', //ok
					'input_light'		=> '#8981a0', //ok
					'input_dark'		=> '#ffffff', //ok
					
					// Inverse blocks (text and links on the 'text_link' background)
					'inverse_bd_color'	=> '#e36650',
					'inverse_bd_hover'	=> '#cb5b47',
					'inverse_text'		=> '#ffffff', //ok
					'inverse_light'		=> '#8981a0', //ok
					'inverse_dark'		=> '#171e43', //ok
					'inverse_link'		=> '#ffffff', //ok
					'inverse_hover'		=> '#1aceff'  //ok
				)
			)
		
		));
		
		// Simple schemes substitution
		smart_casa_storage_set('schemes_simple', array(
			// Main color	// Slave elements and it's darkness koef.
			'text_link'		=> array('alter_hover' => 1,	'extra_link' => 1, 'inverse_bd_color' => 0.85, 'inverse_bd_hover' => 0.7),
			'text_hover'	=> array('alter_link' => 1,		'extra_hover' => 1),
			'text_link2'	=> array('alter_hover2' => 1,	'extra_link2' => 1),
			'text_hover2'	=> array('alter_link2' => 1,	'extra_hover2' => 1),
			'text_link3'	=> array('alter_hover3' => 1,	'extra_link3' => 1),
			'text_hover3'	=> array('alter_link3' => 1,	'extra_hover3' => 1)
		));

		// Additional colors for each scheme
		// Parameters:	'color' - name of the color from the scheme that should be used as source for the transformation
		//				'alpha' - to make color transparent (0.0 - 1.0)
		//				'hue', 'saturation', 'brightness' - inc/dec value for each color's component
		smart_casa_storage_set('scheme_colors_add', array(
			'bg_color_0'		=> array('color' => 'bg_color',			'alpha' => 0),
			'bg_color_02'		=> array('color' => 'bg_color',			'alpha' => 0.2),
			'bg_color_03'		=> array('color' => 'bg_color',			'alpha' => 0.3),
			'bg_color_07'		=> array('color' => 'bg_color',			'alpha' => 0.7),
			'bg_color_08'		=> array('color' => 'bg_color',			'alpha' => 0.8),
			'bg_color_09'		=> array('color' => 'bg_color',			'alpha' => 0.9),
			'alter_bg_color_07'	=> array('color' => 'alter_bg_color',	'alpha' => 0.7),
			'alter_bg_hover_06'	=> array('color' => 'alter_bg_hover',	'alpha' => 0.6),
			'alter_bg_hover_08'	=> array('color' => 'alter_bg_hover',	'alpha' => 0.8),
			'alter_bg_color_04'	=> array('color' => 'alter_bg_color',	'alpha' => 0.4),
			'alter_bg_color_02'	=> array('color' => 'alter_bg_color',	'alpha' => 0.2),
			'alter_bd_color_02'	=> array('color' => 'alter_bd_color',	'alpha' => 0.2),
			'alter_dark_015'	=> array('color' => 'alter_dark',		'alpha' => 0.15),
			'alter_link_01' 	=> array('color' => 'alter_link',		'alpha' => 0.1),
			'alter_link_02'		=> array('color' => 'alter_link',		'alpha' => 0.2),
			'alter_link_03'		=> array('color' => 'alter_link',		'alpha' => 0.3),
			'alter_link_07'		=> array('color' => 'alter_link',		'alpha' => 0.7),
			'extra_bg_color_07'	=> array('color' => 'extra_bg_color',	'alpha' => 0.7),
			'extra_bd_hover_07'	=> array('color' => 'extra_bg_color',	'alpha' => 0.7),
			'extra_dark_015'	=> array('color' => 'extra_dark',		'alpha' => 0.15),
			'extra_link_02'		=> array('color' => 'extra_link',		'alpha' => 0.2),
			'extra_link_07'		=> array('color' => 'extra_link',		'alpha' => 0.7),
			'text_dark_005'		=> array('color' => 'text_dark',		'alpha' => 0.05),
			'text_dark_008'		=> array('color' => 'text_dark',		'alpha' => 0.08),
			'text_dark_01'		=> array('color' => 'text_dark',		'alpha' => 0.1),
            'text_dark_015'		=> array('color' => 'text_dark',		'alpha' => 0.15),
            'text_dark_07'		=> array('color' => 'text_dark',		'alpha' => 0.7),
            'text_dark_04'		=> array('color' => 'text_dark',		'alpha' => 0.4),
			'text_link_02'		=> array('color' => 'text_link',		'alpha' => 0.2),
            'inverse_link_01'	=> array('color' => 'inverse_link',		'alpha' => 0.1),
			'inverse_link_015'	=> array('color' => 'inverse_link',		'alpha' => 0.15),
    		'inverse_link_02'	=> array('color' => 'inverse_link',		'alpha' => 0.2),
			'inverse_link_03'	=> array('color' => 'inverse_link',		'alpha' => 0.3),
			'inverse_link_05'	=> array('color' => 'inverse_link',		'alpha' => 0.5),
			'inverse_link_08'	=> array('color' => 'inverse_link',		'alpha' => 0.8),
			'inverse_hover_01'	=> array('color' => 'inverse_hover',	'alpha' => 0.1),
			'inverse_hover_08'	=> array('color' => 'inverse_hover',	'alpha' => 0.8),
			'inverse_dark_015'	=> array('color' => 'inverse_dark',		'alpha' => 0.15),
			'inverse_hover_015'	=> array('color' => 'inverse_hover',	'alpha' => 0.15),
			'inverse_hover_02'	=> array('color' => 'inverse_hover',	'alpha' => 0.2),
			'text_link_07'		=> array('color' => 'text_link',		'alpha' => 0.7),
			'text_hover_015'	=> array('color' => 'text_hover',		'alpha' => 0.15),
			'text_hover_02'		=> array('color' => 'text_hover',		'alpha' => 0.2),
			'text_link_blend'	=> array('color' => 'text_link',		'hue' => 2, 'saturation' => -5, 'brightness' => 5),
			'alter_hover_blend'	=> array('color' => 'alter_hover',		'hue' => 5, 'saturation' => -5, 'brightness' => 5),
			'text_hover_blend'	=> array('color' => 'text_hover',		'hue' => 5, 'saturation' => -5, 'brightness' => 5),
            'text_link3_blend'	=> array('color' => 'text_link3',		'hue' => 5, 'saturation' => -5, 'brightness' => 5),
			'alter_link_blend'	=> array('color' => 'alter_link',		'hue' => 2, 'saturation' => -5, 'brightness' => 5)
		));
		
		// Parameters to set order of schemes in the css
		smart_casa_storage_set('schemes_sorted', array(
													'color_scheme', 'header_scheme', 'menu_scheme', 'sidebar_scheme', 'footer_scheme'
													));
		
		
		// -----------------------------------------------------------------
		// -- Theme specific thumb sizes
		// -----------------------------------------------------------------
		smart_casa_storage_set('theme_thumbs', apply_filters('smart_casa_filter_add_thumb_sizes', array(
			// Width of the image is equal to the content area width (without sidebar)
			// Height is fixed
			'smart_casa-thumb-huge'		=> array(
												'size'	=> array(1170, 658, true),
												'title' => esc_html__( 'Huge image', 'smart-casa' ),
												'subst'	=> 'trx_addons-thumb-huge'
												),
			// Width of the image is equal to the content area width (with sidebar)
			// Height is fixed
			'smart_casa-thumb-big' 		=> array(
												'size'	=> array( 737, 415, true),
												'title' => esc_html__( 'Large image', 'smart-casa' ),
												'subst'	=> 'trx_addons-thumb-big'
												),

			// Width of the image is equal to the 1/3 of the content area width (without sidebar)
			// Height is fixed
			'smart_casa-thumb-med' 		=> array(
												'size'	=> array( 370, 208, true),
												'title' => esc_html__( 'Medium image', 'smart-casa' ),
												'subst'	=> 'trx_addons-thumb-medium'
												),

			// Small square image (for avatars in comments, etc.)
			'smart_casa-thumb-tiny' 		=> array(
												'size'	=> array(  90,  90, true),
												'title' => esc_html__( 'Small square avatar', 'smart-casa' ),
												'subst'	=> 'trx_addons-thumb-tiny'
												),

			// Width of the image is equal to the content area width (with sidebar)
			// Height is proportional (only downscale, not crop)
			'smart_casa-thumb-masonry-big' => array(
												'size'	=> array( 737,   0, false),		// Only downscale, not crop
												'title' => esc_html__( 'Masonry Large (scaled)', 'smart-casa' ),
												'subst'	=> 'trx_addons-thumb-masonry-big'
												),

			// Width of the image is equal to the 1/3 of the full content area width (without sidebar)
			// Height is proportional (only downscale, not crop)
			'smart_casa-thumb-masonry'		=> array(
												'size'	=> array( 370,   0, false),		// Only downscale, not crop
												'title' => esc_html__( 'Masonry (scaled)', 'smart-casa' ),
												'subst'	=> 'trx_addons-thumb-masonry'
												),
            // Alter image (for recent posts in sidebar)
            'smart_casa-thumb-alter' 		=> array(
                                                'size'	=> array(  548,  260, true),
                                                'title' => esc_html__( 'Alter Image', 'smart-casa' ),
                                                'subst'	=> 'trx_addons-thumb-alter'
                                                ),
            // Extra image (for related post in single page & blogger)
            'smart_casa-thumb-extra' 		=> array(
                                                'size'	=> array(  706,  482, true),
                                                'title' => esc_html__( 'Extra Image', 'smart-casa' ),
                                                'subst'	=> 'trx_addons-thumb-extra'
                                                ),
            // Portrait image (image for default Team)
            'smart_casa-thumb-portrait' 		=> array(
                                                'size'	=> array(  540,  640, true),
                                                'title' => esc_html__( 'Portrait Image', 'smart-casa' ),
                                                'subst'	=> 'trx_addons-thumb-portrait'
                                                ),
            // Additional image (image for Timeline Services)
            'smart_casa-thumb-additional' 		=> array(
                                                'size'	=> array(  450,  327, true),
                                                'title' => esc_html__( 'Additional Image', 'smart-casa' ),
                                                'subst'	=> 'trx_addons-thumb-additional'
                                                ),
            // Extra image (image for Extra Services)
            'smart_casa-thumb-square' 		=> array(
                                                'size'	=> array(  460,  460, true),
                                                'title' => esc_html__( 'Square Image', 'smart-casa' ),
                                                'subst'	=> 'trx_addons-thumb-square'
                                                )

			))
		);
	}
}




//------------------------------------------------------------------------
// One-click import support
//------------------------------------------------------------------------

// Set theme specific importer options
if ( !function_exists( 'smart_casa_importer_set_options' ) ) {
	add_filter( 'trx_addons_filter_importer_options', 'smart_casa_importer_set_options', 9 );
	function smart_casa_importer_set_options($options=array()) {
		if (is_array($options)) {
			// Save or not installer's messages to the log-file
			$options['debug'] = false;
			// Prepare demo data
			$options['demo_url'] = esc_url(smart_casa_get_protocol() . '://demofiles.axiomthemes.com/smart-casa/');
			// Required plugins
			$options['required_plugins'] = array_keys(smart_casa_storage_get('required_plugins'));
			// Set number of thumbnails to regenerate when its imported (if demo data was zipped without cropped images)
			// Set 0 to prevent regenerate thumbnails (if demo data archive is already contain cropped images)
			$options['regenerate_thumbnails'] = 3;
			// Default demo
			$options['files']['default']['title'] = esc_html__('Smart Casa Demo', 'smart-casa');
			$options['files']['default']['domain_dev'] = ''; // Developers domain
			$options['files']['default']['domain_demo']= esc_url(smart_casa_get_protocol().'://smart-casa.axiomthemes.com/');// Demo-site domain

			// Banners
			$options['banners'] = array(
				array(
					'image' => smart_casa_get_file_url('theme-specific/theme-about/images/frontpage.png'),
					'title' => esc_html__('Front Page Builder', 'smart-casa'),
					'content' => wp_kses(__("Create your front page right in the WordPress Customizer. There's no need any page builder. Simply enable/disable sections, fill them out with content, and customize to your liking.", 'smart-casa'), 'smart_casa_kses_content'),
					'link_url' => esc_url('//www.youtube.com/watch?v=VT0AUbMl_KA'),
					'link_caption' => esc_html__('Watch Video Introduction', 'smart-casa'),
					'duration' => 20
					),
				array(
					'image' => smart_casa_get_file_url('theme-specific/theme-about/images/layouts.png'),
					'title' => esc_html__('Layouts Builder', 'smart-casa'),
					'content' => wp_kses(__('Use Layouts Builder to create and customize header and footer styles for your website. With a flexible page builder interface and custom shortcodes, you can create as many header and footer layouts as you want with ease.', 'smart-casa'), 'smart_casa_kses_content'),
					'link_url' => esc_url('//www.youtube.com/watch?v=pYhdFVLd7y4'),
					'link_caption' => esc_html__('Learn More', 'smart-casa'),
					'duration' => 20
					),
				array(
					'image' => smart_casa_get_file_url('theme-specific/theme-about/images/documentation.png'),
					'title' => esc_html__('Read Full Documentation', 'smart-casa'),
					'content' => wp_kses(__('Need more details? Please check our full online documentation for detailed information on how to use SmartCasa.', 'smart-casa'), 'smart_casa_kses_content'),
					'link_url' => esc_url(smart_casa_storage_get('theme_doc_url')),
					'link_caption' => esc_html__('Online Documentation', 'smart-casa'),
					'duration' => 15
					),
				array(
					'image' => smart_casa_get_file_url('theme-specific/theme-about/images/video-tutorials.png'),
					'title' => esc_html__('Video Tutorials', 'smart-casa'),
					'content' => wp_kses(__('No time for reading documentation? Check out our video tutorials and learn how to customize SmartCasa in detail.', 'smart-casa'), 'smart_casa_kses_content'),
					'link_url' => esc_url(smart_casa_storage_get('theme_video_url')),
					'link_caption' => esc_html__('Video Tutorials', 'smart-casa'),
					'duration' => 15
					),
				array(
					'image' => smart_casa_get_file_url('theme-specific/theme-about/images/studio.png'),
					'title' => esc_html__('Website Customization', 'smart-casa'),
					'content' => wp_kses(__("Need a website fast? Order our custom service, and we'll build a website based on this theme for a very fair price. We can also implement additional functionality such as website translation, setting up WPML, and much more.", 'smart-casa'), 'smart_casa_kses_content'),
					'link_url' => esc_url('//themerex.net/offers/?utm_source=offers&utm_medium=click&utm_campaign=themedash/'),
					'link_caption' => esc_html__('Contact Us', 'smart-casa'),
					'duration' => 25
					)
				);
		}
		return $options;
	}
}



// -----------------------------------------------------------------
// -- Theme options for customizer
// -----------------------------------------------------------------
if (!function_exists('smart_casa_create_theme_options')) {

	function smart_casa_create_theme_options() {

		// Message about options override. 
		// Attention! Not need esc_html() here, because this message put in wp_kses_data() below
		$msg_override = esc_html__('Attention! Some of these options can be overridden in the following sections (Blog, Plugins settings, etc.) or in the settings of individual pages', 'smart-casa');
		
		// Color schemes number: if < 2 - hide fields with selectors
		$hide_schemes = count(smart_casa_storage_get('schemes')) < 2;
		
		smart_casa_storage_set('options', array(
		
			// 'Logo & Site Identity'
			'title_tagline' => array(
				"title" => esc_html__('Logo & Site Identity', 'smart-casa'),
				"desc" => '',
				"priority" => 10,
				"type" => "section"
				),
			'logo_info' => array(
				"title" => esc_html__('Logo in the header', 'smart-casa'),
				"desc" => '',
				"priority" => 20,
				"type" => "info",
				),
			'logo_text' => array(
				"title" => esc_html__('Use Site Name as Logo', 'smart-casa'),
				"desc" => wp_kses_data( __('Use the site title and tagline as a text logo if no image is selected', 'smart-casa') ),
				"class" => "smart_casa_column-1_2 smart_casa_new_row",
				"priority" => 30,
				"std" => 1,
				"type" => SMART_CASA_THEME_FREE ? "hidden" : "checkbox"
				),
			'logo_retina_enabled' => array(
				"title" => esc_html__('Allow retina display logo', 'smart-casa'),
				"desc" => wp_kses_data( __('Show fields to select logo images for Retina display', 'smart-casa') ),
				"class" => "smart_casa_column-1_2",
				"priority" => 40,
				"refresh" => false,
				"std" => 0,
				"type" => SMART_CASA_THEME_FREE ? "hidden" : "checkbox"
				),
			'logo_zoom' => array(
				"title" => esc_html__('Logo zoom', 'smart-casa'),
				"desc" => wp_kses_data( __("Zoom the logo. 1 - original size. Maximum size of logo depends on the actual size of the picture", 'smart-casa') ),
				"std" => 1,
				"min" => 0.2,
				"max" => 2,
				"step" => 0.1,
				"refresh" => false,
				"type" => SMART_CASA_THEME_FREE ? "hidden" : "slider"
				),
			// Parameter 'logo' was replaced with standard WordPress 'custom_logo'
			'logo_retina' => array(
				"title" => esc_html__('Logo for Retina', 'smart-casa'),
				"desc" => wp_kses_data( __('Select or upload site logo used on Retina displays (if empty - use default logo from the field above)', 'smart-casa') ),
				"class" => "smart_casa_column-1_2",
				"priority" => 70,
				"dependency" => array(
					'logo_retina_enabled' => array(1)
				),
				"std" => '',
				"type" => SMART_CASA_THEME_FREE ? "hidden" : "image"
				),
			'logo_mobile_header' => array(
				"title" => esc_html__('Logo for the mobile header', 'smart-casa'),
				"desc" => wp_kses_data( __('Select or upload site logo to display it in the mobile header (if enabled in the section "Header - Header mobile"', 'smart-casa') ),
				"class" => "smart_casa_column-1_2 smart_casa_new_row",
				"std" => '',
				"type" => "image"
				),
			'logo_mobile_header_retina' => array(
				"title" => esc_html__('Logo for the mobile header for Retina', 'smart-casa'),
				"desc" => wp_kses_data( __('Select or upload site logo used on Retina displays (if empty - use default logo from the field above)', 'smart-casa') ),
				"class" => "smart_casa_column-1_2",
				"dependency" => array(
					'logo_retina_enabled' => array(1)
				),
				"std" => '',
				"type" => SMART_CASA_THEME_FREE ? "hidden" : "image"
				),
			'logo_mobile' => array(
				"title" => esc_html__('Logo mobile', 'smart-casa'),
				"desc" => wp_kses_data( __('Select or upload site logo to display it in the mobile menu', 'smart-casa') ),
				"class" => "smart_casa_column-1_2 smart_casa_new_row",
				"std" => '',
				"type" => "image"
				),
			'logo_mobile_retina' => array(
				"title" => esc_html__('Logo mobile for Retina', 'smart-casa'),
				"desc" => wp_kses_data( __('Select or upload site logo used on Retina displays (if empty - use default logo from the field above)', 'smart-casa') ),
				"class" => "smart_casa_column-1_2",
				"dependency" => array(
					'logo_retina_enabled' => array(1)
				),
				"std" => '',
				"type" => SMART_CASA_THEME_FREE ? "hidden" : "image"
				),
			'logo_side' => array(
				"title" => esc_html__('Logo side', 'smart-casa'),
				"desc" => wp_kses_data( __('Select or upload site logo (with vertical orientation) to display it in the side menu', 'smart-casa') ),
				"class" => "smart_casa_column-1_2 smart_casa_new_row",
				"std" => '',
				"type" => "hidden" //image
				),
			'logo_side_retina' => array(
				"title" => esc_html__('Logo side for Retina', 'smart-casa'),
				"desc" => wp_kses_data( __('Select or upload site logo (with vertical orientation) to display it in the side menu on Retina displays (if empty - use default logo from the field above)', 'smart-casa') ),
				"class" => "smart_casa_column-1_2",
				"dependency" => array(
					'logo_retina_enabled' => array(1)
				),
				"std" => '',
				"type" =>  "hidden"
				),
			
		
		
			// 'General settings'
			'general' => array(
				"title" => esc_html__('General Settings', 'smart-casa'),
				"desc" => wp_kses_data( $msg_override ),
				"priority" => 20,
				"type" => "section",
				),

			'general_layout_info' => array(
				"title" => esc_html__('Layout', 'smart-casa'),
				"desc" => '',
				"type" => "info",
				),
			'body_style' => array(
				"title" => esc_html__('Body style', 'smart-casa'),
				"desc" => wp_kses_data( __('Select width of the body content', 'smart-casa') ),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Content', 'smart-casa')
				),
				"refresh" => false,
				"std" => 'wide extra',
				"options" => smart_casa_get_list_body_styles(false),
				"type" => "select"
				),
			'page_width' => array(
				"title" => esc_html__('Page width', 'smart-casa'),
				"desc" => wp_kses_data( __("Total width of the site content and sidebar (in pixels). If empty - use default width", 'smart-casa') ),
				"dependency" => array(
					'body_style' => array('boxed', 'wide')
				),
				"std" => 1170,
				"min" => 1000,
				"max" => 1400,
				"step" => 10,
				"refresh" => false,
				"customizer" => 'page',		// SASS name to preview changes 'on fly'
				"type" => SMART_CASA_THEME_FREE ? "hidden" : "slider"
				),
			'boxed_bg_image' => array(
				"title" => esc_html__('Boxed bg image', 'smart-casa'),
				"desc" => wp_kses_data( __('Select or upload image, used as background in the boxed body', 'smart-casa') ),
				"dependency" => array(
					'body_style' => array('boxed')
				),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Content', 'smart-casa')
				),
				"std" => '',
				"hidden" => true,
				"type" => "image"
				),
			'remove_margins' => array(
				"title" => esc_html__('Remove margins', 'smart-casa'),
				"desc" => wp_kses_data( __('Remove margins above and below the content area', 'smart-casa') ),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Content', 'smart-casa')
				),
				"refresh" => false,
				"std" => 0,
				"type" => "checkbox"
				),

			'general_sidebar_info' => array(
				"title" => esc_html__('Sidebar', 'smart-casa'),
				"desc" => '',
				"type" => "info",
				),
			'sidebar_position' => array(
				"title" => esc_html__('Sidebar position', 'smart-casa'),
				"desc" => wp_kses_data( __('Select position to show sidebar', 'smart-casa') ),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Widgets', 'smart-casa')
				),
				"std" => 'right',
				"options" => array(),
				"type" => "switch"
				),
			'sidebar_widgets' => array(
				"title" => esc_html__('Sidebar widgets', 'smart-casa'),
				"desc" => wp_kses_data( __('Select default widgets to show in the sidebar', 'smart-casa') ),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Widgets', 'smart-casa')
				),
				"dependency" => array(
					'sidebar_position' => array('left', 'right')
				),
				"std" => 'sidebar_widgets',
				"options" => array(),
				"type" => "select"
				),
			'sidebar_width' => array(
				"title" => esc_html__('Sidebar width', 'smart-casa'),
				"desc" => wp_kses_data( __("Width of the sidebar (in pixels). If empty - use default width", 'smart-casa') ),
				"std" => 370,
				"min" => 150,
				"max" => 500,
				"step" => 10,
				"refresh" => false,
				"customizer" => 'sidebar',		// SASS name to preview changes 'on fly'
				"type" => SMART_CASA_THEME_FREE ? "hidden" : "slider"
				),
			'sidebar_gap' => array(
				"title" => esc_html__('Sidebar gap', 'smart-casa'),
				"desc" => wp_kses_data( __("Gap between content and sidebar (in pixels). If empty - use default gap", 'smart-casa') ),
				"std" => 63,
				"min" => 0,
				"max" => 100,
				"step" => 1,
				"refresh" => false,
				"customizer" => 'gap',		// SASS name to preview changes 'on fly'
				"type" => SMART_CASA_THEME_FREE ? "hidden" : "slider"
				),
			'expand_content' => array(
				"title" => esc_html__('Expand content', 'smart-casa'),
				"desc" => wp_kses_data( __('Expand the content width if the sidebar is hidden', 'smart-casa') ),
				"refresh" => false,
				"std" => 1,
				"type" => "checkbox"
				),


			'general_widgets_info' => array(
				"title" => esc_html__('Additional widgets', 'smart-casa'),
				"desc" => '',
				"type" => SMART_CASA_THEME_FREE ? "hidden" : "info",
				),
			'widgets_above_page' => array(
				"title" => esc_html__('Widgets at the top of the page', 'smart-casa'),
				"desc" => wp_kses_data( __('Select widgets to show at the top of the page (above content and sidebar)', 'smart-casa') ),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Widgets', 'smart-casa')
				),
				"std" => 'hide',
				"options" => array(),
				"type" => SMART_CASA_THEME_FREE ? "hidden" : "select"
				),
			'widgets_above_content' => array(
				"title" => esc_html__('Widgets above the content', 'smart-casa'),
				"desc" => wp_kses_data( __('Select widgets to show at the beginning of the content area', 'smart-casa') ),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Widgets', 'smart-casa')
				),
				"std" => 'hide',
				"options" => array(),
				"type" => SMART_CASA_THEME_FREE ? "hidden" : "select"
				),
			'widgets_below_content' => array(
				"title" => esc_html__('Widgets below the content', 'smart-casa'),
				"desc" => wp_kses_data( __('Select widgets to show at the ending of the content area', 'smart-casa') ),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Widgets', 'smart-casa')
				),
				"std" => 'hide',
				"options" => array(),
				"type" => SMART_CASA_THEME_FREE ? "hidden" : "select"
				),
			'widgets_below_page' => array(
				"title" => esc_html__('Widgets at the bottom of the page', 'smart-casa'),
				"desc" => wp_kses_data( __('Select widgets to show at the bottom of the page (below content and sidebar)', 'smart-casa') ),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Widgets', 'smart-casa')
				),
				"std" => 'hide',
				"options" => array(),
				"type" => SMART_CASA_THEME_FREE ? "hidden" : "select"
				),

			'general_effects_info' => array(
				"title" => esc_html__('Design & Effects', 'smart-casa'),
				"desc" => '',
				"type" => "info",
				),
			'border_radius' => array(
				"title" => esc_html__('Border radius', 'smart-casa'),
				"desc" => wp_kses_data( __("Specify the border radius of the form fields and buttons in pixels", 'smart-casa') ),
				"std" => 0,
				"min" => 0,
				"max" => 20,
				"step" => 1,
				"refresh" => false,
				"customizer" => 'rad',		// SASS name to preview changes 'on fly'
				"type" => 'hidden'    
				),

			'general_misc_info' => array(
				"title" => esc_html__('Miscellaneous', 'smart-casa'),
				"desc" => '',
				"type" => SMART_CASA_THEME_FREE ? "hidden" : "info",
				),
			'seo_snippets' => array(
				"title" => esc_html__('SEO snippets', 'smart-casa'),
				"desc" => wp_kses_data( __('Add structured data markup to the single posts and pages', 'smart-casa') ),
				"std" => 0,
				"type" => SMART_CASA_THEME_FREE ? "hidden" : "checkbox"
				),
			'privacy_text' => array(
				"title" => esc_html__("Text with Privacy Policy link", 'smart-casa'),
				"desc"  => wp_kses_data( __("Specify text with Privacy Policy link for the checkbox 'I agree ...'", 'smart-casa') ),
				"std"   => wp_kses( __( 'I agree that my submitted data is being collected and stored.', 'smart-casa'), 'smart_casa_kses_content' ),
				"type"  => "text"
			),

            // Section 'Theme Specific'
            'custom_section' => array(
                "title" => esc_html__('Custom Section', 'smart-casa'),
                "desc" => wp_kses_data( __("Theme specific settings", 'smart-casa') ),
                "type" => "section"
            ),
            'custom_section_info' => array(
                "title" => esc_html__('Custom section', 'smart-casa'),
                "desc" => wp_kses_data( __("Custom section with socials. Socials working with plugin ThemeRex Addons", 'smart-casa') ),
                "type" => "info"
            ),
            'custom_section_socials' => array(
                "title" => esc_html__('Show section with socials', 'smart-casa'),
                "desc" => wp_kses_data( __("Uncheck this field to hide section", 'smart-casa') ),
                "override" => array(
                    'mode' => 'page',
                    'section' => esc_html__('Content', 'smart-casa')
                ),
                "std" => "1",
                "type" => "checkbox"
            ),
            'custom_section_socials_description' => array(
                "title" => esc_html__('Socials Description', 'smart-casa'),
                "desc" => wp_kses_data( __("Some description displayed before socials. If the field is empty then only socials will be displayed.", 'smart-casa') ),
                "std" => '',
                "type" => "text"
            ),

			// 'Header'
			'header' => array(
				"title" => esc_html__('Header', 'smart-casa'),
				"desc" => wp_kses_data( $msg_override ),
				"priority" => 30,
				"type" => "section"
				),

			'header_style_info' => array(
				"title" => esc_html__('Header style', 'smart-casa'),
				"desc" => '',
				"type" => "info"
				),
			'header_type' => array(
				"title" => esc_html__('Header style', 'smart-casa'),
				"desc" => wp_kses_data( __('Choose whether to use the default header or header Layouts (available only if the ThemeREX Addons is activated)', 'smart-casa') ),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Header', 'smart-casa')
				),
				"std" => 'default',
				"options" => smart_casa_get_list_header_footer_types(),
				"type" => SMART_CASA_THEME_FREE || !smart_casa_exists_trx_addons() ? "hidden" : "switch"
				),
			'header_style' => array(
				"title" => esc_html__('Select custom layout', 'smart-casa'),
				"desc" => wp_kses( __("Select custom header from Layouts Builder", 'smart-casa'), 'smart_casa_kses_content' ),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Header', 'smart-casa')
				),
				"dependency" => array(
					'header_type' => array('custom')
				),
				"std" => SMART_CASA_THEME_FREE ? 'header-custom-elementor-header-default' : 'header-custom-header-default',
				"options" => array(),
				"type" => "select"
				),
			'header_position' => array(
				"title" => esc_html__('Header position', 'smart-casa'),
				"desc" => wp_kses_data( __('Select position to display the site header', 'smart-casa') ),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Header', 'smart-casa')
				),
				"std" => 'default',
				"options" => array(),
				"type" => SMART_CASA_THEME_FREE ? "hidden" : "switch"
				),
			'header_fullheight' => array(
				"title" => esc_html__('Header fullheight', 'smart-casa'),
				"desc" => wp_kses_data( __("Enlarge header area to fill whole screen. Used only if header have a background image", 'smart-casa') ),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Header', 'smart-casa')
				),
				"std" => 0,
				"type" => SMART_CASA_THEME_FREE ? "hidden" : "checkbox"
				),
			'header_zoom' => array(
				"title" => esc_html__('Header zoom', 'smart-casa'),
				"desc" => wp_kses_data( __("Zoom the header title. 1 - original size", 'smart-casa') ),
				"std" => 1,
				"min" => 0.3,
				"max" => 2,
				"step" => 0.1,
				"refresh" => false,
				"type" => SMART_CASA_THEME_FREE ? "hidden" : "slider"
				),
			'header_wide' => array(
				"title" => esc_html__('Header fullwidth', 'smart-casa'),
				"desc" => wp_kses_data( __('Do you want to stretch the header widgets area to the entire window width?', 'smart-casa') ),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Header', 'smart-casa')
				),
				"dependency" => array(
					'header_type' => array('default')
				),
				"std" => 1,
				"type" => SMART_CASA_THEME_FREE ? "hidden" : "checkbox"
				),

			'header_widgets_info' => array(
				"title" => esc_html__('Header widgets', 'smart-casa'),
				"desc" => wp_kses_data( __('Here you can place a widget slider, advertising banners, etc.', 'smart-casa') ),
				"type" => "info"
				),
			'header_widgets' => array(
				"title" => esc_html__('Header widgets', 'smart-casa'),
				"desc" => wp_kses_data( __('Select set of widgets to show in the header on each page', 'smart-casa') ),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Header', 'smart-casa'),
					"desc" => wp_kses_data( __('Select set of widgets to show in the header on this page', 'smart-casa') ),
				),
				"std" => 'hide',
				"options" => array(),
				"type" => "select"
				),
			'header_columns' => array(
				"title" => esc_html__('Header columns', 'smart-casa'),
				"desc" => wp_kses_data( __('Select number columns to show widgets in the Header. If 0 - autodetect by the widgets count', 'smart-casa') ),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Header', 'smart-casa')
				),
				"dependency" => array(
					'header_type' => array('default'),
					'header_widgets' => array('^hide')
				),
				"std" => 0,
				"options" => smart_casa_get_list_range(0,6),
				"type" => "select"
				),

			'menu_info' => array(
				"title" => esc_html__('Main menu', 'smart-casa'),
				"desc" => wp_kses_data( __('Select main menu style, position and other parameters', 'smart-casa') ),
				"type" => SMART_CASA_THEME_FREE ? "hidden" : "info"
				),
			'menu_style' => array(
				"title" => esc_html__('Menu position', 'smart-casa'),
				"desc" => wp_kses_data( __('Select position of the main menu', 'smart-casa') ),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Header', 'smart-casa')
				),
				"std" => 'top',
				"options" => array(
					'top'	=> esc_html__('Top',	'smart-casa'),
				),
				"type" => SMART_CASA_THEME_FREE || !smart_casa_exists_trx_addons() ? "hidden" : "switch"
				),
			'menu_side_stretch' => array(
				"title" => esc_html__('Stretch sidemenu', 'smart-casa'),
				"desc" => wp_kses_data( __('Stretch sidemenu to window height (if menu items number >= 5)', 'smart-casa') ),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Header', 'smart-casa')
				),
				"dependency" => array(
					'menu_style' => array('left', 'right')
				),
				"std" => 0,
				"type" => SMART_CASA_THEME_FREE ? "hidden" : "checkbox"
				),
			'menu_side_icons' => array(
				"title" => esc_html__('Iconed sidemenu', 'smart-casa'),
				"desc" => wp_kses_data( __('Get icons from anchors and display it in the sidemenu or mark sidemenu items with simple dots', 'smart-casa') ),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Header', 'smart-casa')
				),
				"dependency" => array(
					'menu_style' => array('left', 'right')
				),
				"std" => 1,
				"type" => SMART_CASA_THEME_FREE ? "hidden" : "checkbox"
				),
			'menu_mobile_fullscreen' => array(
				"title" => esc_html__('Mobile menu fullscreen', 'smart-casa'),
				"desc" => wp_kses_data( __('Display mobile and side menus on full screen (if checked) or slide narrow menu from the left or from the right side (if not checked)', 'smart-casa') ),
				"std" => 1,
				"type" => SMART_CASA_THEME_FREE ? "hidden" : "checkbox"
				),

			'header_image_info' => array(
				"title" => esc_html__('Header image', 'smart-casa'),
				"desc" => '',
				"type" => SMART_CASA_THEME_FREE ? "hidden" : "info"
				),
			'header_image_override' => array(
				"title" => esc_html__('Header image override', 'smart-casa'),
				"desc" => wp_kses_data( __("Allow override the header image with the page's/post's/product's/etc. featured image", 'smart-casa') ),
				"override" => array(
					'mode' => 'page',
					'section' => esc_html__('Header', 'smart-casa')
				),
				"std" => 0,
				"type" => SMART_CASA_THEME_FREE ? "hidden" : "checkbox"
				),

			'header_mobile_info' => array(
				"title" => esc_html__('Mobile header', 'smart-casa'),
				"desc" => wp_kses_data( __("Configure the mobile version of the header", 'smart-casa') ),
				"priority" => 500,
				"dependency" => array(
					'header_type' => array('default')
				),
				"type" => SMART_CASA_THEME_FREE ? "hidden" : "info"
				),
			'header_mobile_enabled' => array(
				"title" => esc_html__('Enable the mobile header', 'smart-casa'),
				"desc" => wp_kses_data( __("Use the mobile version of the header (if checked) or relayout the current header on mobile devices", 'smart-casa') ),
				"dependency" => array(
					'header_type' => array('default')
				),
				"std" => 0,
				"type" => SMART_CASA_THEME_FREE ? "hidden" : "checkbox"
				),
			'header_mobile_additional_info' => array(
				"title" => esc_html__('Additional info', 'smart-casa'),
				"desc" => wp_kses_data( __('Additional info to show at the top of the mobile header', 'smart-casa') ),
				"std" => '',
				"dependency" => array(
					'header_type' => array('default'),
					'header_mobile_enabled' => array(1)
				),
				"refresh" => false,
				"teeny" => false,
				"rows" => 20,
				"type" => SMART_CASA_THEME_FREE ? "hidden" : "text_editor"
				),
			'header_mobile_hide_info' => array(
				"title" => esc_html__('Hide additional info', 'smart-casa'),
				"std" => 0,
				"dependency" => array(
					'header_type' => array('default'),
					'header_mobile_enabled' => array(1)
				),
				"type" => SMART_CASA_THEME_FREE ? "hidden" : "checkbox"
				),
			'header_mobile_hide_logo' => array(
				"title" => esc_html__('Hide logo', 'smart-casa'),
				"std" => 0,
				"dependency" => array(
					'header_type' => array('default'),
					'header_mobile_enabled' => array(1)
				),
				"type" => SMART_CASA_THEME_FREE ? "hidden" : "checkbox"
				),
			'header_mobile_hide_login' => array(
				"title" => esc_html__('Hide login/logout', 'smart-casa'),
				"std" => 0,
				"dependency" => array(
					'header_type' => array('default'),
					'header_mobile_enabled' => array(1)
				),
				"type" => SMART_CASA_THEME_FREE ? "hidden" : "checkbox"
				),
			'header_mobile_hide_search' => array(
				"title" => esc_html__('Hide search', 'smart-casa'),
				"std" => 0,
				"dependency" => array(
					'header_type' => array('default'),
					'header_mobile_enabled' => array(1)
				),
				"type" => SMART_CASA_THEME_FREE ? "hidden" : "checkbox"
				),
			'header_mobile_hide_cart' => array(
				"title" => esc_html__('Hide cart', 'smart-casa'),
				"std" => 0,
				"dependency" => array(
					'header_type' => array('default'),
					'header_mobile_enabled' => array(1)
				),
				"type" => SMART_CASA_THEME_FREE ? "hidden" : "checkbox"
				),


		
			// 'Footer'
			'footer' => array(
				"title" => esc_html__('Footer', 'smart-casa'),
				"desc" => wp_kses_data( $msg_override ),
				"priority" => 50,
				"type" => "section"
				),
			'footer_type' => array(
				"title" => esc_html__('Footer style', 'smart-casa'),
				"desc" => wp_kses_data( __('Choose whether to use the default footer or footer Layouts (available only if the ThemeREX Addons is activated)', 'smart-casa') ),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Footer', 'smart-casa')
				),
				"std" => 'default',
				"options" => smart_casa_get_list_header_footer_types(),
				"type" => SMART_CASA_THEME_FREE || !smart_casa_exists_trx_addons() ? "hidden" : "switch"
				),
			'footer_style' => array(
				"title" => esc_html__('Select custom layout', 'smart-casa'),
				"desc" => wp_kses( __("Select custom footer from Layouts Builder", 'smart-casa'), 'smart_casa_kses_content' ),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Footer', 'smart-casa')
				),
				"dependency" => array(
					'footer_type' => array('custom')
				),
				"std" => SMART_CASA_THEME_FREE ? 'footer-custom-elementor-footer-default' : 'footer-custom-footer-default',
				"options" => array(),
				"type" => "select"
				),
			'footer_widgets' => array(
				"title" => esc_html__('Footer widgets', 'smart-casa'),
				"desc" => wp_kses_data( __('Select set of widgets to show in the footer', 'smart-casa') ),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Footer', 'smart-casa')
				),
				"dependency" => array(
					'footer_type' => array('default')
				),
				"std" => 'footer_widgets',
				"options" => array(),
				"type" => "select"
				),
			'footer_columns' => array(
				"title" => esc_html__('Footer columns', 'smart-casa'),
				"desc" => wp_kses_data( __('Select number columns to show widgets in the footer. If 0 - autodetect by the widgets count', 'smart-casa') ),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Footer', 'smart-casa')
				),
				"dependency" => array(
					'footer_type' => array('default'),
					'footer_widgets' => array('^hide')
				),
				"std" => 0,
				"options" => smart_casa_get_list_range(0,6),
				"type" => "select"
				),
			'footer_wide' => array(
				"title" => esc_html__('Footer fullwidth', 'smart-casa'),
				"desc" => wp_kses_data( __('Do you want to stretch the footer to the entire window width?', 'smart-casa') ),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Footer', 'smart-casa')
				),
				"dependency" => array(
					'footer_type' => array('default')
				),
				"std" => 0,
				"type" => "checkbox"
				),
			'logo_in_footer' => array(
				"title" => esc_html__('Show logo', 'smart-casa'),
				"desc" => wp_kses_data( __('Show logo in the footer', 'smart-casa') ),
				'refresh' => false,
				"dependency" => array(
					'footer_type' => array('default')
				),
				"std" => 0,
				"type" => "checkbox"
				),
			'logo_footer' => array(
				"title" => esc_html__('Logo for footer', 'smart-casa'),
				"desc" => wp_kses_data( __('Select or upload site logo to display it in the footer', 'smart-casa') ),
				"dependency" => array(
					'footer_type' => array('default'),
					'logo_in_footer' => array(1)
				),
				"std" => '',
				"type" => "image"
				),
			'logo_footer_retina' => array(
				"title" => esc_html__('Logo for footer (Retina)', 'smart-casa'),
				"desc" => wp_kses_data( __('Select or upload logo for the footer area used on Retina displays (if empty - use default logo from the field above)', 'smart-casa') ),
				"dependency" => array(
					'footer_type' => array('default'),
					'logo_in_footer' => array(1),
					'logo_retina_enabled' => array(1)
				),
				"std" => '',
				"type" => SMART_CASA_THEME_FREE ? "hidden" : "image"
				),
			'socials_in_footer' => array(
				"title" => esc_html__('Show social icons', 'smart-casa'),
				"desc" => wp_kses_data( __('Show social icons in the footer (under logo or footer widgets)', 'smart-casa') ),
				"dependency" => array(
					'footer_type' => array('default')
				),
				"std" => 0,
				"type" => !smart_casa_exists_trx_addons() ? "hidden" : "checkbox"
				),
			'copyright' => array(
				"title" => esc_html__('Copyright', 'smart-casa'),
				"desc" => wp_kses_data( __('Copyright text in the footer. Use {Y} to insert current year and press "Enter" to create a new line', 'smart-casa') ),
				"translate" => true,
				"std" => esc_html__('Copyright &copy; {Y} by AxiomThemes. All rights reserved.', 'smart-casa'),
				"dependency" => array(
					'footer_type' => array('default')
				),
				"refresh" => false,
				"type" => "textarea"
				),
			
		
		
			// 'Blog'
			'blog' => array(
				"title" => esc_html__('Blog', 'smart-casa'),
				"desc" => wp_kses_data( __('Options of the the blog archive', 'smart-casa') ),
				"priority" => 70,
				"type" => "panel",
				),
		
				// Blog - Posts page
				'blog_general' => array(
					"title" => esc_html__('Posts page', 'smart-casa'),
					"desc" => wp_kses_data( __('Style and components of the blog archive', 'smart-casa') ),
					"type" => "section",
					),
				'blog_general_info' => array(
					"title" => esc_html__('General settings', 'smart-casa'),
					"desc" => '',
					"type" => "info",
					),
				'blog_style' => array(
					"title" => esc_html__('Blog style', 'smart-casa'),
					"desc" => '',
					"override" => array(
						'mode' => 'page',
						'section' => esc_html__('Content', 'smart-casa')
					),
					"dependency" => array(
						'#page_template' => array( 'blog.php' ),
						'.editor-page-attributes__template select' => array( 'blog.php' ),
						'.components-select-control:not(.post-author-selector) select' => array( 'blog.php' ),
					),
					"std" => 'excerpt',
					"options" => array(),
					"type" => "select"
					),
				'first_post_large' => array(
					"title" => esc_html__('First post large', 'smart-casa'),
					"desc" => wp_kses_data( __('Make your first post stand out by making it bigger', 'smart-casa') ),
					"override" => array(
						'mode' => 'page',
						'section' => esc_html__('Content', 'smart-casa')
					),
					"dependency" => array(
						'#page_template' => array( 'blog.php' ),
						'.editor-page-attributes__template select' => array( 'blog.php' ),
						'.components-select-control:not(.post-author-selector) select' => array( 'blog.php' ),
						'blog_style' => array('classic', 'masonry')
					),
					"std" => 0,
					"type" => "checkbox"
					),
				"blog_content" => array( 
					"title" => esc_html__('Posts content', 'smart-casa'),
					"desc" => wp_kses_data( __("Display either post excerpts or the full post content", 'smart-casa') ),
					"std" => "excerpt",
					"dependency" => array(
						'blog_style' => array('excerpt')
					),
					"options" => array(
						'excerpt'	=> esc_html__('Excerpt',	'smart-casa'),
						'fullpost'	=> esc_html__('Full post',	'smart-casa')
					),
					"type" => "switch"
					),
				'excerpt_length' => array(
					"title" => esc_html__('Excerpt length', 'smart-casa'),
					"desc" => wp_kses_data( __("Length (in words) to generate excerpt from the post content. Attention! If the post excerpt is explicitly specified - it appears unchanged", 'smart-casa') ),
					"dependency" => array(
						'blog_style' => array('excerpt'),
						'blog_content' => array('excerpt')
					),
					"std" => 60,
					"type" => "text"
					),
				'blog_columns' => array(
					"title" => esc_html__('Blog columns', 'smart-casa'),
					"desc" => wp_kses_data( __('How many columns should be used in the blog archive (from 2 to 4)?', 'smart-casa') ),
					"std" => 2,
					"options" => smart_casa_get_list_range(2,4),
					"type" => "hidden"
					),
				'post_type' => array(
					"title" => esc_html__('Post type', 'smart-casa'),
					"desc" => wp_kses_data( __('Select post type to show in the blog archive', 'smart-casa') ),
					"override" => array(
						'mode' => 'page',
						'section' => esc_html__('Content', 'smart-casa')
					),
					"dependency" => array(
						'#page_template' => array( 'blog.php' ),
						'.editor-page-attributes__template select' => array( 'blog.php' ),
						'.components-select-control:not(.post-author-selector) select' => array( 'blog.php' ),
					),
					"linked" => 'parent_cat',
					"refresh" => false,
					"hidden" => true,
					"std" => 'post',
					"options" => array(),
					"type" => "select"
					),
				'parent_cat' => array(
					"title" => esc_html__('Category to show', 'smart-casa'),
					"desc" => wp_kses_data( __('Select category to show in the blog archive', 'smart-casa') ),
					"override" => array(
						'mode' => 'page',
						'section' => esc_html__('Content', 'smart-casa')
					),
					"dependency" => array(
						'#page_template' => array( 'blog.php' ),
						'.editor-page-attributes__template select' => array( 'blog.php' ),
					),
					"refresh" => false,
					"hidden" => true,
					"std" => '0',
					"options" => array(),
					"type" => "select"
					),
				'posts_per_page' => array(
					"title" => esc_html__('Posts per page', 'smart-casa'),
					"desc" => wp_kses_data( __('How many posts will be displayed on this page', 'smart-casa') ),
					"override" => array(
						'mode' => 'page',
						'section' => esc_html__('Content', 'smart-casa')
					),
					"dependency" => array(
						'#page_template' => array( 'blog.php' ),
						'.editor-page-attributes__template select' => array( 'blog.php' ),
						'.components-select-control:not(.post-author-selector) select' => array( 'blog.php' ),
					),
					"hidden" => true,
					"std" => '',
					"type" => "text"
					),
				"blog_pagination" => array( 
					"title" => esc_html__('Pagination style', 'smart-casa'),
					"desc" => wp_kses_data( __('Show Older/Newest posts or Page numbers below the posts list', 'smart-casa') ),
					"override" => array(
						'mode' => 'page',
						'section' => esc_html__('Content', 'smart-casa')
					),
					"std" => "pages",
					"dependency" => array(
						'#page_template' => array( 'blog.php' ),
						'.editor-page-attributes__template select' => array( 'blog.php' ),
						'.components-select-control:not(.post-author-selector) select' => array( 'blog.php' ),
					),
					"options" => array(
						'pages'	=> esc_html__("Page numbers", 'smart-casa'),
						'links'	=> esc_html__("Older/Newest", 'smart-casa'),
						'more'	=> esc_html__("Load more", 'smart-casa'),
						'infinite' => esc_html__("Infinite scroll", 'smart-casa')
					),
					"type" => "select"
					),
				'show_filters' => array(
					"title" => esc_html__('Show filters', 'smart-casa'),
					"desc" => wp_kses_data( __('Show categories as tabs to filter posts', 'smart-casa') ),
					"override" => array(
						'mode' => 'page',
						'section' => esc_html__('Content', 'smart-casa')
					),
					"dependency" => array(
						'#page_template' => array( 'blog.php' ),
						'.editor-page-attributes__template select' => array( 'blog.php' ),
						'.components-select-control:not(.post-author-selector) select' => array( 'blog.php' ),
						'blog_style' => array('portfolio', 'gallery')
					),
					"hidden" => true,
					"std" => 0,
					"type" => SMART_CASA_THEME_FREE ? "hidden" : "checkbox"
					),
	
				'blog_sidebar_info' => array(
					"title" => esc_html__('Sidebar', 'smart-casa'),
					"desc" => '',
					"type" => "info",
					),
				'sidebar_position_blog' => array(
					"title" => esc_html__('Sidebar position', 'smart-casa'),
					"desc" => wp_kses_data( __('Select position to show sidebar', 'smart-casa') ),
					"std" => 'right',
					"options" => array(),
					"type" => "switch"
					),
				'sidebar_widgets_blog' => array(
					"title" => esc_html__('Sidebar widgets', 'smart-casa'),
					"desc" => wp_kses_data( __('Select default widgets to show in the sidebar', 'smart-casa') ),
					"dependency" => array(
						'sidebar_position_blog' => array('left', 'right')
					),
					"std" => 'sidebar_widgets',
					"options" => array(),
					"type" => "select"
					),
				'expand_content_blog' => array(
					"title" => esc_html__('Expand content', 'smart-casa'),
					"desc" => wp_kses_data( __('Expand the content width if the sidebar is hidden', 'smart-casa') ),
					"refresh" => false,
					"std" => 1,
					"type" => "checkbox"
					),
	
	
				'blog_widgets_info' => array(
					"title" => esc_html__('Additional widgets', 'smart-casa'),
					"desc" => '',
					"type" => SMART_CASA_THEME_FREE ? "hidden" : "info",
					),
				'widgets_above_page_blog' => array(
					"title" => esc_html__('Widgets at the top of the page', 'smart-casa'),
					"desc" => wp_kses_data( __('Select widgets to show at the top of the page (above content and sidebar)', 'smart-casa') ),
					"std" => 'hide',
					"options" => array(),
					"type" => SMART_CASA_THEME_FREE ? "hidden" : "select"
					),
				'widgets_above_content_blog' => array(
					"title" => esc_html__('Widgets above the content', 'smart-casa'),
					"desc" => wp_kses_data( __('Select widgets to show at the beginning of the content area', 'smart-casa') ),
					"std" => 'hide',
					"options" => array(),
					"type" => SMART_CASA_THEME_FREE ? "hidden" : "select"
					),
				'widgets_below_content_blog' => array(
					"title" => esc_html__('Widgets below the content', 'smart-casa'),
					"desc" => wp_kses_data( __('Select widgets to show at the ending of the content area', 'smart-casa') ),
					"std" => 'hide',
					"options" => array(),
					"type" => SMART_CASA_THEME_FREE ? "hidden" : "select"
					),
				'widgets_below_page_blog' => array(
					"title" => esc_html__('Widgets at the bottom of the page', 'smart-casa'),
					"desc" => wp_kses_data( __('Select widgets to show at the bottom of the page (below content and sidebar)', 'smart-casa') ),
					"std" => 'hide',
					"options" => array(),
					"type" => SMART_CASA_THEME_FREE ? "hidden" : "select"
					),

				'blog_advanced_info' => array(
					"title" => esc_html__('Advanced settings', 'smart-casa'),
					"desc" => '',
					"type" => "info",
					),
				'no_image' => array(
					"title" => esc_html__('Image placeholder', 'smart-casa'),
					"desc" => wp_kses_data( __('Select or upload an image used as placeholder for posts without a featured image', 'smart-casa') ),
					"std" => '',
					"type" => "image"
					),
				'time_diff_before' => array(
					"title" => esc_html__('Easy Readable Date Format', 'smart-casa'),
					"desc" => wp_kses_data( __("For how many days to show the easy-readable date format (e.g. '3 days ago') instead of the standard publication date", 'smart-casa') ),
					"std" => 5,
					"type" => "text"
					),
				'sticky_style' => array(
					"title" => esc_html__('Sticky posts style', 'smart-casa'),
					"desc" => wp_kses_data( __('Select style of the sticky posts output', 'smart-casa') ),
					"std" => 'inherit',
					"options" => array(
						'inherit' => esc_html__('Decorated posts', 'smart-casa'),
						'columns' => esc_html__('Mini-cards',	'smart-casa')
					),
					"type" => SMART_CASA_THEME_FREE ? "hidden" : "select"
					),
				"blog_animation" => array( 
					"title" => esc_html__('Animation for the posts', 'smart-casa'),
					"desc" => wp_kses_data( __('Select animation to show posts in the blog. Attention! Do not use any animation on pages with the "wheel to the anchor" behaviour (like a "Chess 2 columns")!', 'smart-casa') ),
					"override" => array(
						'mode' => 'page',
						'section' => esc_html__('Content', 'smart-casa')
					),
					"dependency" => array(
						'#page_template' => array( 'blog.php' ),
						'.editor-page-attributes__template select' => array( 'blog.php' ),
						'.components-select-control:not(.post-author-selector) select' => array( 'blog.php' ),
					),
					"std" => "none",
					"options" => array(),
					"type" => SMART_CASA_THEME_FREE ? "hidden" : "select"
					),
				'meta_parts' => array(
					"title" => esc_html__('Post meta', 'smart-casa'),
					"desc" => wp_kses_data( __("If your blog page is created using the 'Blog archive' page template, set up the 'Post Meta' settings in the 'Theme Options' section of that page. Post counters and Share Links are available only if plugin ThemeREX Addons is active", 'smart-casa') )
								. '<br>'
								. wp_kses_data( __("<b>Tip:</b> Drag items to change their order.", 'smart-casa') ),
					"override" => array(
						'mode' => 'page',
						'section' => esc_html__('Content', 'smart-casa')
					),
					"dependency" => array(
						'#page_template' => array( 'blog.php' ),
						'.editor-page-attributes__template select' => array( 'blog.php' ),
						'.components-select-control:not(.post-author-selector) select' => array( 'blog.php' ),
					),
					"dir" => 'vertical',
					"sortable" => true,
					"std" => 'categories=1|date=1|counters=0|author=1|share=0|edit=0',
					"options" => array(
						'categories' => esc_html__('Categories', 'smart-casa'),
						'date'		 => esc_html__('Post date', 'smart-casa'),
						'author'	 => esc_html__('Post author', 'smart-casa'),
						'counters'	 => esc_html__('Post counters', 'smart-casa'),
						'share'		 => esc_html__('Share links', 'smart-casa'),
						'edit'		 => esc_html__('Edit link', 'smart-casa')
					),
					"type" => SMART_CASA_THEME_FREE ? "hidden" : "checklist"
				),
				'counters' => array(
					"title" => esc_html__('Post counters', 'smart-casa'),
					"desc" => wp_kses_data( __("Show only selected counters. Attention! Likes and Views are available only if ThemeREX Addons is active", 'smart-casa') ),
					"override" => array(
						'mode' => 'page',
						'section' => esc_html__('Content', 'smart-casa')
					),
					"dependency" => array(
						'#page_template' => array( 'blog.php' ),
						'.editor-page-attributes__template select' => array( 'blog.php' ),
						'.components-select-control:not(.post-author-selector) select' => array( 'blog.php' ),
					),
					"dir" => 'vertical',
					"sortable" => true,
					"std" => 'views=0|likes=0|comments=0',
					"options" => array(
						'views' => esc_html__('Views', 'smart-casa'),
						'likes' => esc_html__('Likes', 'smart-casa'),
						'comments' => esc_html__('Comments', 'smart-casa')
					),
					"type" => SMART_CASA_THEME_FREE || !smart_casa_exists_trx_addons() ? "hidden" : "checklist"
				),

				
				// Blog - Single posts
				'blog_single' => array(
					"title" => esc_html__('Single posts', 'smart-casa'),
					"desc" => wp_kses_data( __('Settings of the single post', 'smart-casa') ),
					"type" => "section",
					),
				'hide_featured_on_single' => array(
					"title" => esc_html__('Hide featured image on the single post', 'smart-casa'),
					"desc" => wp_kses_data( __("Hide featured image on the single post's pages", 'smart-casa') ),
					"override" => array(
						'mode' => 'page,post',
						'section' => esc_html__('Content', 'smart-casa')
					),
					"std" => 0,
					"type" => "checkbox"
					),
				'hide_sidebar_on_single' => array(
					"title" => esc_html__('Hide sidebar on the single post', 'smart-casa'),
					"desc" => wp_kses_data( __("Hide sidebar on the single post's pages", 'smart-casa') ),
					"std" => 0,
					"type" => "checkbox"
					),
				'show_post_meta' => array(
					"title" => esc_html__('Show post meta', 'smart-casa'),
					"desc" => wp_kses_data( __("Display block with post's meta: date, categories, counters, etc.", 'smart-casa') ),
					"std" => 1,
					"type" => "checkbox"
					),
				'meta_parts_post' => array(
					"title" => esc_html__('Post meta', 'smart-casa'),
					"desc" => wp_kses_data( __("Meta parts for single posts. Post counters and Share Links are available only if plugin ThemeREX Addons is active", 'smart-casa') )
								. '<br>'
								. wp_kses_data( __("<b>Tip:</b> Drag items to change their order.", 'smart-casa') ),
					"dependency" => array(
						'show_post_meta' => array(1)
					),
					"dir" => 'vertical',
					"sortable" => true,
					"std" => 'categories=1|date=1|counters=0|author=1|share=0|edit=0',
					"options" => array(
						'categories' => esc_html__('Categories', 'smart-casa'),
						'date'		 => esc_html__('Post date', 'smart-casa'),
						'author'	 => esc_html__('Post author', 'smart-casa'),
						'counters'	 => esc_html__('Post counters', 'smart-casa'),
						'share'		 => esc_html__('Share links', 'smart-casa'),
						'edit'		 => esc_html__('Edit link', 'smart-casa')
					),
					"type" => SMART_CASA_THEME_FREE ? "hidden" : "checklist"
				),
				'counters_post' => array(
					"title" => esc_html__('Post counters', 'smart-casa'),
					"desc" => wp_kses_data( __("Show only selected counters. Attention! Likes and Views are available only if plugin ThemeREX Addons is active", 'smart-casa') ),
					"dependency" => array(
						'show_post_meta' => array(1)
					),
					"dir" => 'vertical',
					"sortable" => true,
					"std" => 'views=0|likes=0|comments=0',
					"options" => array(
						'views' => esc_html__('Views', 'smart-casa'),
						'likes' => esc_html__('Likes', 'smart-casa'),
						'comments' => esc_html__('Comments', 'smart-casa')
					),
					"type" => SMART_CASA_THEME_FREE || !smart_casa_exists_trx_addons() ? "hidden" : "checklist"
				),
				'show_share_links' => array(
					"title" => esc_html__('Show share links', 'smart-casa'),
					"desc" => wp_kses_data( __("Display share links on the single post", 'smart-casa') ),
					"std" => 1,
					"type" => !smart_casa_exists_trx_addons() ? "hidden" : "checkbox"
					),
				'show_author_info' => array(
					"title" => esc_html__('Show author info', 'smart-casa'),
					"desc" => wp_kses_data( __("Display block with information about post's author", 'smart-casa') ),
					"std" => 1,
					"type" => "checkbox"
					),
				'blog_single_related_info' => array(
					"title" => esc_html__('Related posts', 'smart-casa'),
					"desc" => '',
					"type" => "info",
					),
				'show_related_posts' => array(
					"title" => esc_html__('Show related posts', 'smart-casa'),
					"desc" => wp_kses_data( __("Show section 'Related posts' on the single post's pages", 'smart-casa') ),
					"override" => array(
						'mode' => 'page,post',
						'section' => esc_html__('Content', 'smart-casa')
					),
					"std" => 0,
					"type" => "checkbox"
					),
				'related_posts' => array(
					"title" => esc_html__('Related posts', 'smart-casa'),
					"desc" => wp_kses_data( __('How many related posts should be displayed in the single post? If 0 - no related posts are shown.', 'smart-casa') ),
					"dependency" => array(
						'show_related_posts' => array(1)
					),
					"std" => 2,
					"options" => smart_casa_get_list_range(1,9),
					"type" => SMART_CASA_THEME_FREE ? "hidden" : "select"
					),
				'related_columns' => array(
					"title" => esc_html__('Related columns', 'smart-casa'),
					"desc" => wp_kses_data( __('How many columns should be used to output related posts in the single page (from 2 to 4)?', 'smart-casa') ),
					"dependency" => array(
						'show_related_posts' => array(1)
					),
					"std" => 2,
					"options" => smart_casa_get_list_range(1,4),
					"type" => SMART_CASA_THEME_FREE ? "hidden" : "switch"
					),
			'blog_end' => array(
				"type" => "panel_end",
				),
			
		
		
			// 'Colors'
			'panel_colors' => array(
				"title" => esc_html__('Colors', 'smart-casa'),
				"desc" => '',
				"priority" => 300,
				"type" => "section"
				),

			'color_schemes_info' => array(
				"title" => esc_html__('Color schemes', 'smart-casa'),
				"desc" => wp_kses_data( __('Color schemes for various parts of the site. "Inherit" means that this block is used the Site color scheme (the first parameter)', 'smart-casa') ),
				"hidden" => $hide_schemes,
				"type" => "info",
				),
			'color_scheme' => array(
				"title" => esc_html__('Site Color Scheme', 'smart-casa'),
				"desc" => '',
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Colors', 'smart-casa')
				),
				"std" => 'default',
				"options" => array(),
				"refresh" => false,
				"type" => $hide_schemes ? 'hidden' : "switch"
				),
			'header_scheme' => array(
				"title" => esc_html__('Header Color Scheme', 'smart-casa'),
				"desc" => '',
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Colors', 'smart-casa')
				),
				"std" => 'inherit',
				"options" => array(),
				"refresh" => false,
				"type" => $hide_schemes ? 'hidden' : "switch"
				),
			'menu_scheme' => array(
				"title" => esc_html__('Sidemenu Color Scheme', 'smart-casa'),
				"desc" => '',
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Colors', 'smart-casa')
				),
				"std" => 'inherit',
				"options" => array(),
				"refresh" => false,
				"type" => 'hidden' 
				),
			'sidebar_scheme' => array(
				"title" => esc_html__('Sidebar Color Scheme', 'smart-casa'),
				"desc" => '',
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Colors', 'smart-casa')
				),
				"std" => 'default',
				"options" => array(),
				"refresh" => false,
				"type" => $hide_schemes ? 'hidden' : "switch"
				),
			'footer_scheme' => array(
				"title" => esc_html__('Footer Color Scheme', 'smart-casa'),
				"desc" => '',
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Colors', 'smart-casa')
				),
				"std" => 'default',
				"options" => array(),
				"refresh" => false,
				"type" => $hide_schemes ? 'hidden' : "switch"
				),

			'color_scheme_editor_info' => array(
				"title" => esc_html__('Color scheme editor', 'smart-casa'),
				"desc" => wp_kses_data(__('Select color scheme to modify. Attention! Only those sections in the site will be changed which this scheme was assigned to', 'smart-casa') ),
				"type" => "info",
				),
			'scheme_storage' => array(
				"title" => esc_html__('Color scheme editor', 'smart-casa'),
				"desc" => '',
				"std" => '$smart_casa_get_scheme_storage',
				"refresh" => false,
				"colorpicker" => "tiny",
				"type" => "scheme_editor"
				),


			// 'Hidden'
			'media_title' => array(
				"title" => esc_html__('Media title', 'smart-casa'),
				"desc" => wp_kses_data( __('Used as title for the audio and video item in this post', 'smart-casa') ),
				"override" => array(
					'mode' => 'post',
					'section' => esc_html__('Content', 'smart-casa')
				),
				"hidden" => true,
				"std" => '',
				"type" => SMART_CASA_THEME_FREE ? "hidden" : "text"
				),
			'media_author' => array(
				"title" => esc_html__('Media author', 'smart-casa'),
				"desc" => wp_kses_data( __('Used as author name for the audio and video item in this post', 'smart-casa') ),
				"override" => array(
					'mode' => 'post',
					'section' => esc_html__('Content', 'smart-casa')
				),
				"hidden" => true,
				"std" => '',
				"type" => SMART_CASA_THEME_FREE ? "hidden" : "text"
				),


			// Internal options.
			// Attention! Don't change any options in the section below!
			// Use huge priority to call render this elements after all options!
			'reset_options' => array(
				"title" => '',
				"desc" => '',
				"std" => '0',
				"priority" => 10000,
				"type" => "hidden",
				),

			'last_option' => array(		// Need to manually call action to include Tiny MCE scripts
				"title" => '',
				"desc" => '',
				"std" => 1,
				"type" => "hidden",
				),

		));


		// Prepare panel 'Fonts'
		// -------------------------------------------------------------
		$fonts = array(
		
			// 'Fonts'
			'fonts' => array(
				"title" => esc_html__('Typography', 'smart-casa'),
				"desc" => '',
				"priority" => 200,
				"type" => "panel"
				),

			// Fonts - Load_fonts
			'load_fonts' => array(
				"title" => esc_html__('Load fonts', 'smart-casa'),
				"desc" => wp_kses_data( __('Specify fonts to load when theme start. You can use them in the base theme elements: headers, text, menu, links, input fields, etc.', 'smart-casa') )
						. '<br>'
						. wp_kses_data( __('Attention! Press "Refresh" button to reload preview area after the all fonts are changed', 'smart-casa') ),
				"type" => "section"
				),
			'load_fonts_subset' => array(
				"title" => esc_html__('Google fonts subsets', 'smart-casa'),
				"desc" => wp_kses_data( __('Specify comma separated list of the subsets which will be load from Google fonts', 'smart-casa') )
						. '<br>'
						. wp_kses_data( __('Available subsets are: latin,latin-ext,cyrillic,cyrillic-ext,greek,greek-ext,vietnamese', 'smart-casa') ),
				"class" => "smart_casa_column-1_3 smart_casa_new_row",
				"refresh" => false,
				"std" => '$smart_casa_get_load_fonts_subset',
				"type" => "text"
				)
		);

		for ($i=1; $i<=smart_casa_get_theme_setting('max_load_fonts'); $i++) {
			if (smart_casa_get_value_gp('page') != 'theme_options') {
				$fonts["load_fonts-{$i}-info"] = array(
					// Translators: Add font's number - 'Font 1', 'Font 2', etc
					"title" => esc_html(sprintf(esc_html__('Font %s', 'smart-casa'), $i)),
					"desc" => '',
					"type" => "info",
					);
			}
			$fonts["load_fonts-{$i}-name"] = array(
				"title" => esc_html__('Font name', 'smart-casa'),
				"desc" => '',
				"class" => "smart_casa_column-1_3 smart_casa_new_row",
				"refresh" => false,
				"std" => '$smart_casa_get_load_fonts_option',
				"type" => "text"
				);
			$fonts["load_fonts-{$i}-family"] = array(
				"title" => esc_html__('Font family', 'smart-casa'),
				"desc" => $i==1 
							? wp_kses_data( __('Select font family to use it if font above is not available', 'smart-casa') )
							: '',
				"class" => "smart_casa_column-1_3",
				"refresh" => false,
				"std" => '$smart_casa_get_load_fonts_option',
				"options" => array(
					'inherit' => esc_html__("Inherit", 'smart-casa'),
					'serif' => esc_html__('serif', 'smart-casa'),
					'sans-serif' => esc_html__('sans-serif', 'smart-casa'),
					'monospace' => esc_html__('monospace', 'smart-casa'),
					'cursive' => esc_html__('cursive', 'smart-casa'),
					'fantasy' => esc_html__('fantasy', 'smart-casa')
				),
				"type" => "select"
				);
			$fonts["load_fonts-{$i}-styles"] = array(
				"title" => esc_html__('Font styles', 'smart-casa'),
				"desc" => $i==1 
							? wp_kses_data( __('Font styles used only for the Google fonts. This is a comma separated list of the font weight and styles. For example: 400,400italic,700', 'smart-casa') )
								. '<br>'
								. wp_kses_data( __('Attention! Each weight and style increase download size! Specify only used weights and styles.', 'smart-casa') )
							: '',
				"class" => "smart_casa_column-1_3",
				"refresh" => false,
				"std" => '$smart_casa_get_load_fonts_option',
				"type" => "text"
				);
		}
		$fonts['load_fonts_end'] = array(
			"type" => "section_end"
			);

		// Fonts - H1..6, P, Info, Menu, etc.
		$theme_fonts = smart_casa_get_theme_fonts();
		foreach ($theme_fonts as $tag=>$v) {
			$fonts["{$tag}_section"] = array(
				"title" => !empty($v['title']) 
								? $v['title'] 
								// Translators: Add tag's name to make title 'H1 settings', 'P settings', etc.
								: esc_html(sprintf(esc_html__('%s settings', 'smart-casa'), $tag)),
				"desc" => !empty($v['description']) 
								? $v['description'] 
								// Translators: Add tag's name to make description
								: wp_kses( sprintf(__('Font settings of the "%s" tag.', 'smart-casa'), $tag), 'smart_casa_kses_content' ),
				"type" => "section",
				);
	
			foreach ($v as $css_prop=>$css_value) {
				if (in_array($css_prop, array('title', 'description'))) continue;
				$options = '';
				$type = 'text';
				$load_order = 1;
				$title = ucfirst(str_replace('-', ' ', $css_prop));
				if ($css_prop == 'font-family') {
					$type = 'select';
					$options = array();
					$load_order = 2;		// Load this option's value after all options are loaded (use option 'load_fonts' to build fonts list)
				} else if ($css_prop == 'font-weight') {
					$type = 'select';
					$options = array(
						'inherit' => esc_html__("Inherit", 'smart-casa'),
						'100' => esc_html__('100 (Light)', 'smart-casa'), 
						'200' => esc_html__('200 (Light)', 'smart-casa'), 
						'300' => esc_html__('300 (Thin)',  'smart-casa'),
						'400' => esc_html__('400 (Normal)', 'smart-casa'),
						'500' => esc_html__('500 (Semibold)', 'smart-casa'),
						'600' => esc_html__('600 (Semibold)', 'smart-casa'),
						'700' => esc_html__('700 (Bold)', 'smart-casa'),
						'800' => esc_html__('800 (Black)', 'smart-casa'),
						'900' => esc_html__('900 (Black)', 'smart-casa')
					);
				} else if ($css_prop == 'font-style') {
					$type = 'select';
					$options = array(
						'inherit' => esc_html__("Inherit", 'smart-casa'),
						'normal' => esc_html__('Normal', 'smart-casa'), 
						'italic' => esc_html__('Italic', 'smart-casa')
					);
				} else if ($css_prop == 'text-decoration') {
					$type = 'select';
					$options = array(
						'inherit' => esc_html__("Inherit", 'smart-casa'),
						'none' => esc_html__('None', 'smart-casa'), 
						'underline' => esc_html__('Underline', 'smart-casa'),
						'overline' => esc_html__('Overline', 'smart-casa'),
						'line-through' => esc_html__('Line-through', 'smart-casa')
					);
				} else if ($css_prop == 'text-transform') {
					$type = 'select';
					$options = array(
						'inherit' => esc_html__("Inherit", 'smart-casa'),
						'none' => esc_html__('None', 'smart-casa'), 
						'uppercase' => esc_html__('Uppercase', 'smart-casa'),
						'lowercase' => esc_html__('Lowercase', 'smart-casa'),
						'capitalize' => esc_html__('Capitalize', 'smart-casa')
					);
				}
				$fonts["{$tag}_{$css_prop}"] = array(
					"title" => $title,
					"desc" => '',
					"class" => "smart_casa_column-1_5",
					"refresh" => false,
					"load_order" => $load_order,
					"std" => '$smart_casa_get_theme_fonts_option',
					"options" => $options,
					"type" => $type
				);
			}
			
			$fonts["{$tag}_section_end"] = array(
				"type" => "section_end"
				);
		}

		$fonts['fonts_end'] = array(
			"type" => "panel_end"
			);

		// Add fonts parameters to Theme Options
		smart_casa_storage_set_array_before('options', 'panel_colors', $fonts);


		// Add Header Video if WP version < 4.7
		// -----------------------------------------------------
		if (!function_exists('get_header_video_url')) {
			smart_casa_storage_set_array_after('options', 'header_image_override', 'header_video', array(
				"title" => esc_html__('Header video', 'smart-casa'),
				"desc" => wp_kses_data( __("Select video to use it as background for the header", 'smart-casa') ),
				"override" => array(
					'mode' => 'page',
					'section' => esc_html__('Header', 'smart-casa')
				),
				"std" => '',
				"type" => "video"
				)
			);
		}


		// Add option 'logo' if WP version < 4.5
		// or 'custom_logo' if current page is 'Theme Options'
		// ------------------------------------------------------
		if (!function_exists('the_custom_logo') || (isset($_REQUEST['page']) && $_REQUEST['page']=='theme_options')) {
			smart_casa_storage_set_array_before('options', 'logo_retina', function_exists('the_custom_logo') ? 'custom_logo' : 'logo', array(
				"title" => esc_html__('Logo', 'smart-casa'),
				"desc" => wp_kses_data( __('Select or upload the site logo', 'smart-casa') ),
				"class" => "smart_casa_column-1_2 smart_casa_new_row",
				"priority" => 60,
				"std" => '',
				"type" => "image"
				)
			);
		}

	}
}


// Returns a list of options that can be overridden for CPT
if (!function_exists('smart_casa_options_get_list_cpt_options')) {
	function smart_casa_options_get_list_cpt_options($cpt, $title='') {
		if (empty($title)) $title = ucfirst($cpt);
		return array(
					"header_info_{$cpt}" => array(
						"title" => esc_html__('Header', 'smart-casa'),
						"desc" => '',
						"type" => "info",
						),
					"header_type_{$cpt}" => array(
						"title" => esc_html__('Header style', 'smart-casa'),
						"desc" => wp_kses_data( __('Choose whether to use the default header or header Layouts (available only if the ThemeREX Addons is activated)', 'smart-casa') ),
						"std" => 'inherit',
						"options" => smart_casa_get_list_header_footer_types(true),
						"type" => SMART_CASA_THEME_FREE ? "hidden" : "switch"
						),
					"header_style_{$cpt}" => array(
						"title" => esc_html__('Select custom layout', 'smart-casa'),
						// Translators: Add CPT name to the description
						"desc" => wp_kses_data( sprintf(__('Select custom layout to display the site header on the %s pages', 'smart-casa'), $title) ),
						"dependency" => array(
							"header_type_{$cpt}" => array('custom')
						),
						"std" => 'inherit',
						"options" => array(),
						"type" => SMART_CASA_THEME_FREE ? "hidden" : "select"
						),
					"header_position_{$cpt}" => array(
						"title" => esc_html__('Header position', 'smart-casa'),
						// Translators: Add CPT name to the description
						"desc" => wp_kses_data( sprintf(__('Select position to display the site header on the %s pages', 'smart-casa'), $title) ),
						"std" => 'inherit',
						"options" => array(),
						"type" => SMART_CASA_THEME_FREE ? "hidden" : "switch"
						),
					"header_image_override_{$cpt}" => array(
						"title" => esc_html__('Header image override', 'smart-casa'),
						"desc" => wp_kses_data( __("Allow override the header image with the post's featured image", 'smart-casa') ),
						"std" => 'inherit',
						"options" => array(
							'inherit' => esc_html__('Inherit', 'smart-casa'),
							1 => esc_html__('Yes', 'smart-casa'),
							0 => esc_html__('No', 'smart-casa'),
						),
						"type" => SMART_CASA_THEME_FREE ? "hidden" : "switch"
						),
					"header_widgets_{$cpt}" => array(
						"title" => esc_html__('Header widgets', 'smart-casa'),
						// Translators: Add CPT name to the description
						"desc" => wp_kses_data( sprintf(__('Select set of widgets to show in the header on the %s pages', 'smart-casa'), $title) ),
						"std" => 'hide',
						"options" => array(),
						"type" => "select"
						),
						
					"sidebar_info_{$cpt}" => array(
						"title" => esc_html__('Sidebar', 'smart-casa'),
						"desc" => '',
						"type" => "info",
						),
					"sidebar_position_{$cpt}" => array(
						"title" => esc_html__('Sidebar position', 'smart-casa'),
						// Translators: Add CPT name to the description
						"desc" => wp_kses_data( sprintf(__('Select position to show sidebar on the %s pages', 'smart-casa'), $title) ),
						"std" => 'left',
						"options" => array(),
						"type" => "switch"
						),
					"sidebar_widgets_{$cpt}" => array(
						"title" => esc_html__('Sidebar widgets', 'smart-casa'),
						// Translators: Add CPT name to the description
						"desc" => wp_kses_data( sprintf(__('Select sidebar to show on the %s pages', 'smart-casa'), $title) ),
						"dependency" => array(
							"sidebar_position_{$cpt}" => array('left', 'right')
						),
						"std" => 'hide',
						"options" => array(),
						"type" => "select"
						),
					"hide_sidebar_on_single_{$cpt}" => array(
						"title" => esc_html__('Hide sidebar on the single pages', 'smart-casa'),
						"desc" => wp_kses_data( __("Hide sidebar on the single page", 'smart-casa') ),
						"std" => 'inherit',
						"options" => array(
							'inherit' => esc_html__('Inherit', 'smart-casa'),
							1 => esc_html__('Hide', 'smart-casa'),
							0 => esc_html__('Show', 'smart-casa'),
						),
						"type" => "switch"
						),
						
					"footer_info_{$cpt}" => array(
						"title" => esc_html__('Footer', 'smart-casa'),
						"desc" => '',
						"type" => "info",
						),
					"footer_type_{$cpt}" => array(
						"title" => esc_html__('Footer style', 'smart-casa'),
						"desc" => wp_kses_data( __('Choose whether to use the default footer or footer Layouts (available only if the ThemeREX Addons is activated)', 'smart-casa') ),
						"std" => 'inherit',
						"options" => smart_casa_get_list_header_footer_types(true),
						"type" => SMART_CASA_THEME_FREE ? "hidden" : "switch"
						),
					"footer_style_{$cpt}" => array(
						"title" => esc_html__('Select custom layout', 'smart-casa'),
						"desc" => wp_kses_data( __('Select custom layout to display the site footer', 'smart-casa') ),
						"std" => 'inherit',
						"dependency" => array(
							"footer_type_{$cpt}" => array('custom')
						),
						"options" => array(),
						"type" => SMART_CASA_THEME_FREE ? "hidden" : "select"
						),
					"footer_widgets_{$cpt}" => array(
						"title" => esc_html__('Footer widgets', 'smart-casa'),
						"desc" => wp_kses_data( __('Select set of widgets to show in the footer', 'smart-casa') ),
						"dependency" => array(
							"footer_type_{$cpt}" => array('default')
						),
						"std" => 'footer_widgets',
						"options" => array(),
						"type" => "select"
						),
					"footer_columns_{$cpt}" => array(
						"title" => esc_html__('Footer columns', 'smart-casa'),
						"desc" => wp_kses_data( __('Select number columns to show widgets in the footer. If 0 - autodetect by the widgets count', 'smart-casa') ),
						"dependency" => array(
							"footer_type_{$cpt}" => array('default'),
							"footer_widgets_{$cpt}" => array('^hide')
						),
						"std" => 0,
						"options" => smart_casa_get_list_range(0,6),
						"type" => "select"
						),
					"footer_wide_{$cpt}" => array(
						"title" => esc_html__('Footer fullwidth', 'smart-casa'),
						"desc" => wp_kses_data( __('Do you want to stretch the footer to the entire window width?', 'smart-casa') ),
						"dependency" => array(
							"footer_type_{$cpt}" => array('default')
						),
						"std" => 0,
						"type" => "checkbox"
						),
						
					"widgets_info_{$cpt}" => array(
						"title" => esc_html__('Additional panels', 'smart-casa'),
						"desc" => '',
						"type" => SMART_CASA_THEME_FREE ? "hidden" : "info",
						),
					"widgets_above_page_{$cpt}" => array(
						"title" => esc_html__('Widgets at the top of the page', 'smart-casa'),
						"desc" => wp_kses_data( __('Select widgets to show at the top of the page (above content and sidebar)', 'smart-casa') ),
						"std" => 'hide',
						"options" => array(),
						"type" => SMART_CASA_THEME_FREE ? "hidden" : "select"
						),
					"widgets_above_content_{$cpt}" => array(
						"title" => esc_html__('Widgets above the content', 'smart-casa'),
						"desc" => wp_kses_data( __('Select widgets to show at the beginning of the content area', 'smart-casa') ),
						"std" => 'hide',
						"options" => array(),
						"type" => SMART_CASA_THEME_FREE ? "hidden" : "select"
						),
					"widgets_below_content_{$cpt}" => array(
						"title" => esc_html__('Widgets below the content', 'smart-casa'),
						"desc" => wp_kses_data( __('Select widgets to show at the ending of the content area', 'smart-casa') ),
						"std" => 'hide',
						"options" => array(),
						"type" => SMART_CASA_THEME_FREE ? "hidden" : "select"
						),
					"widgets_below_page_{$cpt}" => array(
						"title" => esc_html__('Widgets at the bottom of the page', 'smart-casa'),
						"desc" => wp_kses_data( __('Select widgets to show at the bottom of the page (below content and sidebar)', 'smart-casa') ),
						"std" => 'hide',
						"options" => array(),
						"type" => SMART_CASA_THEME_FREE ? "hidden" : "select"
						)
					);
	}
}


// Return lists with choises when its need in the admin mode
if (!function_exists('smart_casa_options_get_list_choises')) {
	add_filter('smart_casa_filter_options_get_list_choises', 'smart_casa_options_get_list_choises', 10, 2);
	function smart_casa_options_get_list_choises($list, $id) {
		if (is_array($list) && count($list)==0) {
			if (strpos($id, 'header_style')===0)
				$list = smart_casa_get_list_header_styles(strpos($id, 'header_style_')===0);
			else if (strpos($id, 'header_position')===0)
				$list = smart_casa_get_list_header_positions(strpos($id, 'header_position_')===0);
			else if (strpos($id, 'header_widgets')===0)
				$list = smart_casa_get_list_sidebars(strpos($id, 'header_widgets_')===0, true);
			else if (strpos($id, '_scheme') > 0)
				$list = smart_casa_get_list_schemes($id!='color_scheme');
			else if (strpos($id, 'sidebar_widgets')===0)
				$list = smart_casa_get_list_sidebars(strpos($id, 'sidebar_widgets_')===0, true);
			else if (strpos($id, 'sidebar_position')===0)
				$list = smart_casa_get_list_sidebars_positions(strpos($id, 'sidebar_position_')===0);
			else if (strpos($id, 'widgets_above_page')===0)
				$list = smart_casa_get_list_sidebars(strpos($id, 'widgets_above_page_')===0, true);
			else if (strpos($id, 'widgets_above_content')===0)
				$list = smart_casa_get_list_sidebars(strpos($id, 'widgets_above_content_')===0, true);
			else if (strpos($id, 'widgets_below_page')===0)
				$list = smart_casa_get_list_sidebars(strpos($id, 'widgets_below_page_')===0, true);
			else if (strpos($id, 'widgets_below_content')===0)
				$list = smart_casa_get_list_sidebars(strpos($id, 'widgets_below_content_')===0, true);
			else if (strpos($id, 'footer_style')===0)
				$list = smart_casa_get_list_footer_styles(strpos($id, 'footer_style_')===0);
			else if (strpos($id, 'footer_widgets')===0)
				$list = smart_casa_get_list_sidebars(strpos($id, 'footer_widgets_')===0, true);
			else if (strpos($id, 'blog_style')===0)
				$list = smart_casa_get_list_blog_styles(strpos($id, 'blog_style_')===0);
			else if (strpos($id, 'post_type')===0)
				$list = smart_casa_get_list_posts_types();
			else if (strpos($id, 'parent_cat')===0)
				$list = smart_casa_array_merge(array(0 => esc_html__('- Select category -', 'smart-casa')), smart_casa_get_list_categories());
			else if (strpos($id, 'blog_animation')===0)
				$list = smart_casa_get_list_animations_in();
			else if ($id == 'color_scheme_editor')
				$list = smart_casa_get_list_schemes();
			else if (strpos($id, '_font-family') > 0)
				$list = smart_casa_get_list_load_fonts(true);
		}
		return $list;
	}
}
?>