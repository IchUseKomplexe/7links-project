<?php
/**
 * The default template to display the content
 *
 * Used for index/archive/search.
 *
 * @package WordPress
 * @subpackage SMART_CASA
 * @since SMART_CASA 1.0
 */

$smart_casa_post_format = get_post_format();
$smart_casa_post_format = empty($smart_casa_post_format) ? 'standard' : str_replace('post-format-', '', $smart_casa_post_format);
$smart_casa_animation = smart_casa_get_theme_option('blog_animation');

?><article id="post-<?php the_ID(); ?>" 
	<?php post_class( 'post_item post_layout_excerpt post_format_'.esc_attr($smart_casa_post_format) ); ?>
	<?php echo (!smart_casa_is_off($smart_casa_animation) ? ' data-animation="'.esc_attr(smart_casa_get_animation_classes($smart_casa_animation)).'"' : ''); ?>
	><?php

	// Sticky label

	if ( is_sticky() && !is_paged() ) {
		?><div class="post_sticky_wrap"><span class="post_label label_sticky"><?php echo esc_html__('Sticky Post', 'smart-casa')?></span><?php
	}

	// Featured image
	smart_casa_show_post_featured(array( 'thumb_size' => smart_casa_get_thumb_size( strpos(smart_casa_get_theme_option('body_style'), 'full')!==false ? 'full' : 'big' ) ));


    do_action('smart_casa_action_before_post_meta');

    // Post meta
    $smart_casa_components = smart_casa_array_get_keys_by_value(smart_casa_get_theme_option('meta_parts'));
    $smart_casa_counters = smart_casa_array_get_keys_by_value(smart_casa_get_theme_option('counters'));
    $res = smart_casa_get_post_meta_array(apply_filters('smart_casa_filter_post_meta_args', array(
            'components' => $smart_casa_components,
            'counters' => $smart_casa_counters,
            'seo' => false,
            'echo' => false
        ), 'excerpt', 1)
    );
    ?>

    <div class="post_meta_wrapper">
        <?php
        if (!empty($res['categories']) && !is_sticky()) { ?>
        <div class="post_meta_left"><?php
            // Post meta categories (before title)
            if (!empty($res['categories'])) {
                smart_casa_show_layout($res['categories']);
            }?>
        </div><?php
        }

       // Post meta
        if (!empty($smart_casa_components))
            smart_casa_show_post_meta(apply_filters('smart_casa_filter_post_meta_args', array(
                    'components' => $smart_casa_components,
                    'counters' => $smart_casa_counters,
                    'seo' => false
                ), 'excerpt', 1)
            );?>
    </div><?php


	// Title and post meta
	if (get_the_title() != '') {
		?>
		<div class="post_header entry-header">
			<?php
			do_action('smart_casa_action_before_post_title'); 

			// Post title
			the_title( sprintf( '<h2 class="post_title entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' );

			?>
		</div><!-- .post_header --><?php
	}
	
	// Post content
	?><div class="post_content entry-content"><?php
		if (smart_casa_get_theme_option('blog_content') == 'fullpost') {
			// Post content area
			?><div class="post_content_inner"><?php
				the_content( '' );
			?></div><?php
			// Inner pages
			wp_link_pages( array(
				'before'      => '<div class="page_links"><span class="page_links_title">' . esc_html__( 'Pages:', 'smart-casa' ) . '</span>',
				'after'       => '</div>',
				'link_before' => '<span>',
				'link_after'  => '</span>',
				'pagelink'    => '<span class="screen-reader-text">' . esc_html__( 'Page', 'smart-casa' ) . ' </span>%',
				'separator'   => '<span class="screen-reader-text">, </span>',
			) );

		} else {

			$smart_casa_show_learn_more = !in_array($smart_casa_post_format, array('link', 'aside', 'status', 'quote'));

			// Post content area
			?><div class="post_content_inner"><?php
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
			?></div><?php
			// More button
			if ($smart_casa_show_learn_more && !is_sticky()) {
				?><p><a class="more-link" href="<?php the_permalink(); ?>"><?php esc_html_e('More', 'smart-casa'); ?></a></p><?php
			}

            // Post taxonomies
            the_tags( '<span class="post_meta_item post_tags"><span class="post_meta_label">'.esc_html__('Tags:', 'smart-casa').'</span> ', ', ', '</span>' );

		}
	?></div><!-- .entry-content -->
    <?php if ( is_sticky() && !is_paged() ) {?>
    </div>
   <?php } ?>
</article>