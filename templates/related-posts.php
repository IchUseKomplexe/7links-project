<?php
/**
 * The template 'Style 1' to displaying related posts
 *
 * @package WordPress
 * @subpackage SMART_CASA
 * @since SMART_CASA 1.0
 */

$smart_casa_link = get_permalink();
$smart_casa_post_format = get_post_format();
$smart_casa_post_format = empty($smart_casa_post_format) ? 'standard' : str_replace('post-format-', '', $smart_casa_post_format);
?><div id="post-<?php the_ID(); ?>" 
	<?php post_class( 'related_item related_item_style_1 post_format_'.esc_attr($smart_casa_post_format) ); ?>><?php
	smart_casa_show_post_featured(array(
            'thumb_size' => apply_filters('smart_casa_filter_related_thumb_size', smart_casa_get_thumb_size( (int) smart_casa_get_theme_option('related_posts') == 1 ? 'huge' : 'extra' )),
            'show_no_image' => smart_casa_get_theme_setting('allow_no_image'),
            'slides_ratio' => '1.46:1',
            'singular' => false
		)
	);
    ?><div class="post_header entry-header"><?php
        if ( in_array(get_post_type(), array( 'post', 'attachment' ) ) ) {
            ?><span class="post_date"><a href="<?php echo esc_url($smart_casa_link); ?>"><?php echo wp_kses_data(smart_casa_get_date()); ?></a></span><?php
        }
        ?>
        <h6 class="post_title entry-title"><a href="<?php echo esc_url($smart_casa_link); ?>"><?php echo wp_kses_data(get_the_title()); ?></a></h6>
    </div>
</div>