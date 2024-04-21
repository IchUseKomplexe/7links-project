<?php
/**
 * The Gallery template to display posts
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
$smart_casa_image = wp_get_attachment_image_src( get_post_thumbnail_id(get_the_ID()), 'full' );

?><article id="post-<?php the_ID(); ?>" 
	<?php post_class( 'post_item post_layout_portfolio post_layout_gallery post_layout_gallery_'.esc_attr($smart_casa_columns).' post_format_'.esc_attr($smart_casa_post_format) ); ?>
	<?php echo (!smart_casa_is_off($smart_casa_animation) ? ' data-animation="'.esc_attr(smart_casa_get_animation_classes($smart_casa_animation)).'"' : ''); ?>
	data-size="<?php if (!empty($smart_casa_image[1]) && !empty($smart_casa_image[2])) echo intval($smart_casa_image[1]) .'x' . intval($smart_casa_image[2]); ?>"
	data-src="<?php if (!empty($smart_casa_image[0])) echo esc_url($smart_casa_image[0]); ?>"
	>

	<?php

	// Sticky label
	if ( is_sticky() && !is_paged() ) {
		?><span class="post_label label_sticky"></span><?php
	}

	// Featured image
	$smart_casa_image_hover = 'icon';
	if (in_array($smart_casa_image_hover, array('icons', 'zoom'))) $smart_casa_image_hover = 'dots';
	$smart_casa_components = smart_casa_array_get_keys_by_value(smart_casa_get_theme_option('meta_parts'));
	$smart_casa_counters = smart_casa_array_get_keys_by_value(smart_casa_get_theme_option('counters'));
	smart_casa_show_post_featured(array(
		'hover' => $smart_casa_image_hover,
		'thumb_size' => smart_casa_get_thumb_size( strpos(smart_casa_get_theme_option('body_style'), 'full')!==false || $smart_casa_columns < 3 ? 'masonry-big' : 'masonry' ),
		'thumb_only' => true,
		'show_no_image' => true,
		'post_info' => '<div class="post_details">'
							. '<h2 class="post_title"><a href="'.esc_url(get_permalink()).'">'. esc_html(get_the_title()) . '</a></h2>'
							. '<div class="post_description">'
								. (!empty($smart_casa_components)
										? smart_casa_show_post_meta(apply_filters('smart_casa_filter_post_meta_args', array(
											'components' => $smart_casa_components,
											'counters' => $smart_casa_counters,
											'seo' => false,
											'echo' => false
											), $smart_casa_blog_style[0], $smart_casa_columns))
										: '')
								. '<div class="post_description_content">'
									. get_the_excerpt()
								. '</div>'
								. '<a href="'.esc_url(get_permalink()).'" class="theme_button post_readmore"><span class="post_readmore_label">' . esc_html__('Learn more', 'smart-casa') . '</span></a>'
							. '</div>'
						. '</div>'
	));
	?>
</article>