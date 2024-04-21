<?php
/**
 * The Classic template to display the content
 *
 * Used for index/archive/search.
 *
 * @package WordPress
 * @subpackage SMART_CASA
 * @since SMART_CASA 1.0
 */

$smart_casa_blog_style = explode('_', smart_casa_get_theme_option('blog_style'));
$smart_casa_columns = empty($smart_casa_blog_style[1]) ? 2 : max(2, $smart_casa_blog_style[1]);
$smart_casa_expanded = !smart_casa_sidebar_present() && smart_casa_is_on(smart_casa_get_theme_option('expand_content'));
$smart_casa_post_format = get_post_format();
$smart_casa_post_format = empty($smart_casa_post_format) ? 'standard' : str_replace('post-format-', '', $smart_casa_post_format);
$smart_casa_animation = smart_casa_get_theme_option('blog_animation');
$smart_casa_components = smart_casa_array_get_keys_by_value(smart_casa_get_theme_option('meta_parts'));
$smart_casa_counters = smart_casa_array_get_keys_by_value(smart_casa_get_theme_option('counters'));

?><div class="<?php echo 'classic' == $smart_casa_blog_style[0] ? 'column' : 'masonry_item masonry_item'; ?>-1_<?php echo esc_attr($smart_casa_columns); ?>"><article id="post-<?php the_ID(); ?>" 
	<?php post_class( 'post_item post_format_'.esc_attr($smart_casa_post_format)
					. ' post_layout_classic post_layout_classic_'.esc_attr($smart_casa_columns)
					. ' post_layout_'.esc_attr($smart_casa_blog_style[0]) 
					. ' post_layout_'.esc_attr($smart_casa_blog_style[0]).'_'.esc_attr($smart_casa_columns)
					); ?>
	<?php echo (!smart_casa_is_off($smart_casa_animation) ? ' data-animation="'.esc_attr(smart_casa_get_animation_classes($smart_casa_animation)).'"' : ''); ?>>
	<?php

	// Sticky label
	if ( is_sticky() && !is_paged() ) {
		?><span class="post_label label_sticky"></span><?php
	}

	// Featured image
	smart_casa_show_post_featured( array( 'thumb_size' => smart_casa_get_thumb_size($smart_casa_blog_style[0] == 'classic'
													? (strpos(smart_casa_get_theme_option('body_style'), 'full')!==false 
															? ( $smart_casa_columns > 2 ? 'big' : 'huge' )
															: (	$smart_casa_columns > 2
																? ($smart_casa_expanded ? 'med' : 'small')
																: ($smart_casa_expanded ? 'big' : 'med')
																)
														)
													: (strpos(smart_casa_get_theme_option('body_style'), 'full')!==false 
															? ( $smart_casa_columns > 2 ? 'masonry-big' : 'full' )
															: (	$smart_casa_columns <= 2 && $smart_casa_expanded ? 'masonry-big' : 'masonry')
														)
								) ) );

	if ( !in_array($smart_casa_post_format, array('link', 'aside', 'status', 'quote')) ) {
		?>
		<div class="post_header entry-header">
			<?php 
			do_action('smart_casa_action_before_post_title'); 

			// Post title
			the_title( sprintf( '<h4 class="post_title entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h4>' );

			do_action('smart_casa_action_before_post_meta'); 

			// Post meta
			if (!empty($smart_casa_components))
				smart_casa_show_post_meta(apply_filters('smart_casa_filter_post_meta_args', array(
					'components' => $smart_casa_components,
					'counters' => $smart_casa_counters,
					'seo' => false
					), $smart_casa_blog_style[0], $smart_casa_columns)
				);

			do_action('smart_casa_action_after_post_meta'); 
			?>
		</div><!-- .entry-header -->
		<?php
	}		
	?>

	<div class="post_content entry-content">
		<div class="post_content_inner">
			<?php
			$smart_casa_show_learn_more = false;
			if (has_excerpt()) {
				the_excerpt();
			} else if (strpos(get_the_content('!--more'), '!--more')!==false) {
				the_content( '' );
			} else if (in_array($smart_casa_post_format, array('link', 'aside', 'status'))) {
				the_content();
			} else if ($smart_casa_post_format == 'quote') {
				if (($quote = smart_casa_get_tag(get_the_content(), '<blockquote>', '</blockquote>'))!='')
					smart_casa_show_layout(wpautop($quote));
				else
					the_excerpt();
			} else if (substr(get_the_content(), 0, 4)!='[vc_') {
				the_excerpt();
			}
			?>
		</div>
		<?php
		// Post meta
		if (in_array($smart_casa_post_format, array('link', 'aside', 'status', 'quote'))) {
			if (!empty($smart_casa_components))
				smart_casa_show_post_meta(apply_filters('smart_casa_filter_post_meta_args', array(
					'components' => $smart_casa_components,
					'counters' => $smart_casa_counters
					), $smart_casa_blog_style[0], $smart_casa_columns)
				);
		}
		// More button
		if ( $smart_casa_show_learn_more ) {
			?><p><a class="more-link" href="<?php the_permalink(); ?>"><?php esc_html_e('More', 'smart-casa'); ?></a></p><?php
		}
		?>
	</div><!-- .entry-content -->

</article></div>