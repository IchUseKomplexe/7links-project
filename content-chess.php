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
$smart_casa_columns = empty($smart_casa_blog_style[1]) ? 1 : max(1, $smart_casa_blog_style[1]);
$smart_casa_expanded = !smart_casa_sidebar_present() && smart_casa_is_on(smart_casa_get_theme_option('expand_content'));
$smart_casa_post_format = get_post_format();
$smart_casa_post_format = empty($smart_casa_post_format) ? 'standard' : str_replace('post-format-', '', $smart_casa_post_format);
$smart_casa_animation = smart_casa_get_theme_option('blog_animation');

?><article id="post-<?php the_ID(); ?>" 
	<?php post_class( 'post_item post_layout_chess post_layout_chess_'.esc_attr($smart_casa_columns).' post_format_'.esc_attr($smart_casa_post_format) ); ?>
	<?php echo (!smart_casa_is_off($smart_casa_animation) ? ' data-animation="'.esc_attr(smart_casa_get_animation_classes($smart_casa_animation)).'"' : ''); ?>>

	<?php
	// Add anchor
	if ($smart_casa_columns == 1 && shortcode_exists('trx_sc_anchor')) {
		echo do_shortcode('[trx_sc_anchor id="post_'.esc_attr(get_the_ID()).'" title="'.the_title_attribute( array( 'echo' => false ) ).'" icon="'.esc_attr(smart_casa_get_post_icon()).'"]');
	}

	// Sticky label
	if ( is_sticky() && !is_paged() ) {
		?><span class="post_label label_sticky"></span><?php
	}

	// Featured image
	smart_casa_show_post_featured( array(
											'class' => $smart_casa_columns == 1 ? 'smart_casa-full-height' : '',
											'show_no_image' => true,
											'thumb_bg' => true,
											'thumb_size' => smart_casa_get_thumb_size(
																	strpos(smart_casa_get_theme_option('body_style'), 'full')!==false
																		? ( $smart_casa_columns > 1 ? 'huge' : 'original' )
																		: (	$smart_casa_columns > 2 ? 'big' : 'huge')
																	)
											) 
										);

	?><div class="post_inner"><div class="post_inner_content"><?php 

		?><div class="post_header entry-header"><?php 
			do_action('smart_casa_action_before_post_title'); 

			// Post title
			the_title( sprintf( '<h3 class="post_title entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h3>' );
			
			do_action('smart_casa_action_before_post_meta'); 

			// Post meta
			$smart_casa_components = smart_casa_array_get_keys_by_value(smart_casa_get_theme_option('meta_parts'));
			$smart_casa_counters = smart_casa_array_get_keys_by_value(smart_casa_get_theme_option('counters'));
			$smart_casa_post_meta = empty($smart_casa_components) 
										? '' 
										: smart_casa_show_post_meta(apply_filters('smart_casa_filter_post_meta_args', array(
												'components' => $smart_casa_components,
												'counters' => $smart_casa_counters,
												'seo' => false,
												'echo' => false
												), $smart_casa_blog_style[0], $smart_casa_columns)
											);
			smart_casa_show_layout($smart_casa_post_meta);
		?></div><!-- .entry-header -->
	
		<div class="post_content entry-content">
			<div class="post_content_inner">
				<?php
				$smart_casa_show_learn_more = !in_array($smart_casa_post_format, array('link', 'aside', 'status', 'quote'));
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
				smart_casa_show_layout($smart_casa_post_meta);
			}
			// More button
			if ( $smart_casa_show_learn_more ) {
				?><p><a class="more-link" href="<?php the_permalink(); ?>"><?php esc_html_e('More', 'smart-casa'); ?></a></p><?php
			}
			?>
		</div><!-- .entry-content -->

	</div></div><!-- .post_inner -->

</article>