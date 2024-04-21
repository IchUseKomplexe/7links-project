<?php
/**
 * The Portfolio template to display the content
 *
 * Used for index/archive/search.
 *
 * @package WordPress
 * @subpackage SMART_CASA
 * @since SMART_CASA 1.0
 */

$smart_casa_blog_style = explode('_', smart_casa_get_theme_option('blog_style'));
$smart_casa_columns = empty($smart_casa_blog_style[1]) ? 2 : max(2, $smart_casa_blog_style[1]);
$smart_casa_post_format = get_post_format();
$smart_casa_post_format = empty($smart_casa_post_format) ? 'standard' : str_replace('post-format-', '', $smart_casa_post_format);
$smart_casa_animation = smart_casa_get_theme_option('blog_animation');

?><article id="post-<?php the_ID(); ?>" 
	<?php post_class( 'post_item post_layout_portfolio post_layout_portfolio_'.esc_attr($smart_casa_columns).' post_format_'.esc_attr($smart_casa_post_format).(is_sticky() && !is_paged() ? ' sticky' : '') ); ?>
	<?php echo (!smart_casa_is_off($smart_casa_animation) ? ' data-animation="'.esc_attr(smart_casa_get_animation_classes($smart_casa_animation)).'"' : ''); ?>>
	<?php

	// Sticky label
	if ( is_sticky() && !is_paged() ) {
		?><span class="post_label label_sticky"></span><?php
	}

	$smart_casa_image_hover = smart_casa_get_theme_option('image_hover');
	// Featured image
	smart_casa_show_post_featured(array(
		'thumb_size' => smart_casa_get_thumb_size(strpos(smart_casa_get_theme_option('body_style'), 'full')!==false || $smart_casa_columns < 3 
								? 'masonry-big' 
								: 'masonry'),
		'show_no_image' => true,
		'class' => $smart_casa_image_hover == 'dots' ? 'hover_with_info' : '',
		'post_info' => $smart_casa_image_hover == 'dots' ? '<div class="post_info">'.esc_html(get_the_title()).'</div>' : ''
	));
	?>
</article>