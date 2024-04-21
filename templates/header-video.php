<?php
/**
 * The template to display the background video in the header
 *
 * @package WordPress
 * @subpackage SMART_CASA
 * @since SMART_CASA 1.0.14
 */
$smart_casa_header_video = smart_casa_get_header_video();
$smart_casa_embed_video = '';
if (!empty($smart_casa_header_video) && !smart_casa_is_from_uploads($smart_casa_header_video)) {
	if (smart_casa_is_youtube_url($smart_casa_header_video) && preg_match('/[=\/]([^=\/]*)$/', $smart_casa_header_video, $matches) && !empty($matches[1])) {
		?><div id="background_video" data-youtube-code="<?php echo esc_attr($matches[1]); ?>"></div><?php
	} else {
		global $wp_embed;
		if (false && is_object($wp_embed)) {
			$smart_casa_embed_video = do_shortcode($wp_embed->run_shortcode( '[embed]' . trim($smart_casa_header_video) . '[/embed]' ));
			$smart_casa_embed_video = smart_casa_make_video_autoplay($smart_casa_embed_video);
		} else {
			$smart_casa_header_video = str_replace('/watch?v=', '/embed/', $smart_casa_header_video);
			$smart_casa_header_video = smart_casa_add_to_url($smart_casa_header_video, array(
				'feature' => 'oembed',
				'controls' => 0,
				'autoplay' => 1,
				'showinfo' => 0,
				'modestbranding' => 1,
				'wmode' => 'transparent',
				'enablejsapi' => 1,
				'origin' => home_url(),
				'widgetid' => 1
			));
			$smart_casa_embed_video = '<iframe src="' . esc_url($smart_casa_header_video) . '" width="1170" height="658" allowfullscreen="0" frameborder="0"></iframe>';
		}
		?><div id="background_video"><?php smart_casa_show_layout($smart_casa_embed_video); ?></div><?php
	}
}
?>