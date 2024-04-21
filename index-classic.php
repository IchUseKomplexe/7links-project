<?php
/**
 * The template for homepage posts with "Classic" style
 *
 * @package WordPress
 * @subpackage SMART_CASA
 * @since SMART_CASA 1.0
 */

smart_casa_storage_set('blog_archive', true);

get_header(); 

if (have_posts()) {

	smart_casa_show_layout(get_query_var('blog_archive_start'));

	$smart_casa_classes = 'posts_container '
						. (substr(smart_casa_get_theme_option('blog_style'), 0, 7) == 'classic' ? 'columns_wrap columns_padding_bottom' : 'masonry_wrap');
	$smart_casa_stickies = is_home() ? get_option( 'sticky_posts' ) : false;
	$smart_casa_sticky_out = smart_casa_get_theme_option('sticky_style')=='columns' 
							&& is_array($smart_casa_stickies) && count($smart_casa_stickies) > 0 && get_query_var( 'paged' ) < 1;
	if ($smart_casa_sticky_out) {
		?><div class="sticky_wrap columns_wrap"><?php	
	}
	if (!$smart_casa_sticky_out) {
		if (smart_casa_get_theme_option('first_post_large') && !is_paged() && !in_array(smart_casa_get_theme_option('body_style'), array('fullwide', 'fullscreen'))) {
			the_post();
			get_template_part( 'content', 'excerpt' );
		}
		
		?><div class="<?php echo esc_attr($smart_casa_classes); ?>"><?php
	}
	while ( have_posts() ) { the_post(); 
		if ($smart_casa_sticky_out && !is_sticky()) {
			$smart_casa_sticky_out = false;
			?></div><div class="<?php echo esc_attr($smart_casa_classes); ?>"><?php
		}
		get_template_part( 'content', $smart_casa_sticky_out && is_sticky() ? 'sticky' : 'classic' );
	}
	
	?></div><?php

	smart_casa_show_pagination();

	smart_casa_show_layout(get_query_var('blog_archive_end'));

} else {

	if ( is_search() )
		get_template_part( 'content', 'none-search' );
	else
		get_template_part( 'content', 'none-archive' );

}

get_footer();
?>