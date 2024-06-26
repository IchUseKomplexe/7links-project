<?php
/**
 * The Sticky template to display the sticky posts
 *
 * Used for index/archive
 *
 * @package WordPress
 * @subpackage SMART_CASA
 * @since SMART_CASA 1.0
 */

$smart_casa_columns = max(1, min(3, count(get_option( 'sticky_posts' ))));
$smart_casa_post_format = get_post_format();
$smart_casa_post_format = empty($smart_casa_post_format) ? 'standard' : str_replace('post-format-', '', $smart_casa_post_format);
$smart_casa_animation = smart_casa_get_theme_option('blog_animation');

?><div class="column-1_<?php echo esc_attr($smart_casa_columns); ?>"><article id="post-<?php the_ID(); ?>" 
	<?php post_class( 'post_item post_layout_sticky post_format_'.esc_attr($smart_casa_post_format) ); ?>
	<?php echo (!smart_casa_is_off($smart_casa_animation) ? ' data-animation="'.esc_attr(smart_casa_get_animation_classes($smart_casa_animation)).'"' : ''); ?>
	>

	<?php
	if ( is_sticky() && is_home() && !is_paged() ) {
		?><span class="post_label label_sticky"></span><?php
	}

	// Featured image
	smart_casa_show_post_featured(array(
		'thumb_size' => smart_casa_get_thumb_size($smart_casa_columns==1 ? 'big' : ($smart_casa_columns==2 ? 'med' : 'avatar'))
	));

	if ( !in_array($smart_casa_post_format, array('link', 'aside', 'status', 'quote')) ) {
		?>
		<div class="post_header entry-header">
			<?php
			// Post title
			the_title( sprintf( '<h6 class="post_title entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h6>' );
			// Post meta
			smart_casa_show_post_meta(apply_filters('smart_casa_filter_post_meta_args', array(), 'sticky', $smart_casa_columns));
			?>
		</div><!-- .entry-header -->
		<?php
	}
	?>
</article></div>