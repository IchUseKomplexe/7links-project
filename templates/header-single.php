<?php
/**
 * The template to display the featured image in the single post
 *
 * @package WordPress
 * @subpackage SMART_CASA
 * @since SMART_CASA 1.0
 */

if ( get_query_var('smart_casa_header_image')=='' && is_singular() && has_post_thumbnail() && in_array(get_post_type(), array('post', 'page')) )  {
	$smart_casa_src = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'full' );
	if (!empty($smart_casa_src[0])) {
		smart_casa_sc_layouts_showed('featured', true);
		?><div class="sc_layouts_featured with_image without_content <?php echo esc_attr(smart_casa_add_inline_css_class('background-image:url('.esc_url($smart_casa_src[0]).');')); ?>"></div><?php
	}
}
?>