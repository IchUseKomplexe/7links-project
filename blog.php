<?php
/**
 * The template to display blog archive
 *
 * @package WordPress
 * @subpackage SMART_CASA
 * @since SMART_CASA 1.0
 */

/*
Template Name: Blog archive
*/

/**
 * Make page with this template and put it into menu
 * to display posts as blog archive
 * You can setup output parameters (blog style, posts per page, parent category, etc.)
 * in the Theme Options section (under the page content)
 * You can build this page in the WordPress editor or any Page Builder to make custom page layout:
 * just insert %%CONTENT%% in the desired place of content
 */

// Get template page's content
$smart_casa_content = '';
$smart_casa_blog_archive_mask = '%%CONTENT%%';
$smart_casa_blog_archive_subst = sprintf('<div class="blog_archive">%s</div>', $smart_casa_blog_archive_mask);
if ( have_posts() ) {
	the_post();
	if (($smart_casa_content = apply_filters('the_content', get_the_content())) != '') {
		if (($smart_casa_pos = strpos($smart_casa_content, $smart_casa_blog_archive_mask)) !== false) {
			$smart_casa_content = preg_replace('/(\<p\>\s*)?'.$smart_casa_blog_archive_mask.'(\s*\<\/p\>)/i', $smart_casa_blog_archive_subst, $smart_casa_content);
		} else
			$smart_casa_content .= $smart_casa_blog_archive_subst;
		$smart_casa_content = explode($smart_casa_blog_archive_mask, $smart_casa_content);
		// Add VC custom styles to the inline CSS
		$vc_custom_css = get_post_meta( get_the_ID(), '_wpb_shortcodes_custom_css', true );
		if ( !empty( $vc_custom_css ) ) smart_casa_add_inline_css(strip_tags($vc_custom_css));
	}
}

// Prepare args for a new query
$smart_casa_args = array(
	'post_status' => current_user_can('read_private_pages') && current_user_can('read_private_posts') ? array('publish', 'private') : 'publish'
);
$smart_casa_args = smart_casa_query_add_posts_and_cats($smart_casa_args, '', smart_casa_get_theme_option('post_type'), smart_casa_get_theme_option('parent_cat'));
$smart_casa_page_number = get_query_var('paged') ? get_query_var('paged') : (get_query_var('page') ? get_query_var('page') : 1);
if ($smart_casa_page_number > 1) {
	$smart_casa_args['paged'] = $smart_casa_page_number;
	$smart_casa_args['ignore_sticky_posts'] = true;
}
$smart_casa_ppp = smart_casa_get_theme_option('posts_per_page');
if ((int) $smart_casa_ppp != 0)
	$smart_casa_args['posts_per_page'] = (int) $smart_casa_ppp;
// Make a new main query
$GLOBALS['wp_the_query']->query($smart_casa_args);


// Add internal query vars in the new query!
if (is_array($smart_casa_content) && count($smart_casa_content) == 2) {
	set_query_var('blog_archive_start', $smart_casa_content[0]);
	set_query_var('blog_archive_end', $smart_casa_content[1]);
}

get_template_part('index');
?>