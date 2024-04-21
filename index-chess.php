<?php
/**
 * The template for homepage posts with "Chess" style
 *
 * @package WordPress
 * @subpackage SMART_CASA
 * @since SMART_CASA 1.0
 */

smart_casa_storage_set('blog_archive', true);

get_header(); 

if (have_posts()) {

	smart_casa_show_layout(get_query_var('blog_archive_start'));

	$smart_casa_stickies = is_home() ? get_option( 'sticky_posts' ) : false;
	$smart_casa_sticky_out = smart_casa_get_theme_option('sticky_style')=='columns' 
							&& is_array($smart_casa_stickies) && count($smart_casa_stickies) > 0 && get_query_var( 'paged' ) < 1;
	if ($smart_casa_sticky_out) {
		?><div class="sticky_wrap columns_wrap"><?php	
	}
	if (!$smart_casa_sticky_out) {
		?><div class="chess_wrap posts_container"><?php
	}
	while ( have_posts() ) { the_post(); 
		if ($smart_casa_sticky_out && !is_sticky()) {
			$smart_casa_sticky_out = false;
			?></div><div class="chess_wrap posts_container"><?php
		}
		get_template_part( 'content', $smart_casa_sticky_out && is_sticky() ? 'sticky' :'chess' );
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