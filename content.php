<?php
/**
 * The default template to display the content of the single post, page or attachment
 *
 * Used for index/archive/search.
 *
 * @package WordPress
 * @subpackage SMART_CASA
 * @since SMART_CASA 1.0
 */

$smart_casa_seo = smart_casa_is_on(smart_casa_get_theme_option('seo_snippets'));
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'post_item_single post_type_'.esc_attr(get_post_type())
												. ' post_format_'.esc_attr(str_replace('post-format-', '', get_post_format())) 
												);
		if ($smart_casa_seo) {
			?> itemscope="itemscope" 
			   itemprop="articleBody" 
			   itemtype="//schema.org/<?php echo esc_attr(smart_casa_get_markup_schema()); ?>"
			   itemid="<?php the_permalink(); ?>"
			   content="<?php the_title_attribute(); ?>"<?php
		}
?>><?php

	do_action('smart_casa_action_before_post_data'); 

	// Structured data snippets
	if ($smart_casa_seo)
		get_template_part('templates/seo');

	// Featured image
	if ( smart_casa_is_off(smart_casa_get_theme_option('hide_featured_on_single'))
			&& !smart_casa_sc_layouts_showed('featured') 
			&& strpos(get_the_content(), '[trx_widget_banner]')===false) {
		do_action('smart_casa_action_before_post_featured'); 
		smart_casa_show_post_featured();
		do_action('smart_casa_action_after_post_featured'); 
	} else if (has_post_thumbnail()) {
		?><meta itemprop="image" itemtype="//schema.org/ImageObject" content="<?php echo esc_url(wp_get_attachment_url(get_post_thumbnail_id())); ?>"><?php
	}

	// Title and post meta
	if ( (!smart_casa_sc_layouts_showed('title') || !smart_casa_sc_layouts_showed('postmeta')) && !in_array(get_post_format(), array('link', 'aside', 'status', 'quote')) ) {
		do_action('smart_casa_action_before_post_title');

		?>
		<div class="post_header entry-header">
			<?php
			// Post title
			if (!smart_casa_sc_layouts_showed('title')) {
				the_title( '<h3 class="post_title entry-title"'.($smart_casa_seo ? ' itemprop="headline"' : '').'>', '</h3>' );
			}

            $smart_casa_components = smart_casa_array_get_keys_by_value(smart_casa_get_theme_option('meta_parts'));
            $smart_casa_counters = smart_casa_array_get_keys_by_value(smart_casa_get_theme_option('counters'));
            $res = smart_casa_get_post_meta_array(apply_filters('smart_casa_filter_post_meta_args', array(
                    'components' => $smart_casa_components,
                    'counters' => $smart_casa_counters,
                    'seo' => false,
                    'echo' => false
                ), 'excerpt', 1)
            );

            if (!smart_casa_sc_layouts_showed('postmeta') && smart_casa_is_on(smart_casa_get_theme_option('show_post_meta'))) {?>
                <div class="post_meta_wrapper">
                    <?php
                    if (!empty($res['categories'])) { ?>
                        <div class="post_meta_left"><?php
                        // Post meta categories (before title)
                        if (!empty($res['categories'])) {
                            smart_casa_show_layout($res['categories']);
                        }?>
                        </div><?php
                    }

                    // Post meta
                    smart_casa_show_post_meta(apply_filters('smart_casa_filter_post_meta_args', array(
                            'components' => $smart_casa_components,
                            'counters' => $smart_casa_counters,
                            'seo' => $smart_casa_seo
                        ), 'single', 1)
                    );

                ?></div><?php
            }

			?>
		</div><!-- .post_header -->
		<?php
		do_action('smart_casa_action_after_post_title'); 
	}

	do_action('smart_casa_action_before_post_content'); 

	// Post content
	?>
	<div class="post_content entry-content" itemprop="mainEntityOfPage">
		<?php
		the_content( );

		do_action('smart_casa_action_before_post_pagination'); 

		wp_link_pages( array(
			'before'      => '<div class="page_links"><span class="page_links_title">' . esc_html__( 'Pages:', 'smart-casa' ) . '</span>',
			'after'       => '</div>',
			'link_before' => '<span>',
			'link_after'  => '</span>',
			'pagelink'    => '<span class="screen-reader-text">' . esc_html__( 'Page', 'smart-casa' ) . ' </span>%',
			'separator'   => '<span class="screen-reader-text">, </span>',
		) );

		// Taxonomies and share
		if ( is_single() && !is_attachment() ) {
			
			do_action('smart_casa_action_before_post_meta'); 

			?><div class="post_meta post_meta_single"><?php
				
				// Post taxonomies
				the_tags( '<span class="post_meta_item post_tags"><span class="post_meta_label">'.esc_html__('Tags:', 'smart-casa').'</span> ', ', ', '</span>' );

				// Share
				if (smart_casa_is_on(smart_casa_get_theme_option('show_share_links'))) {
					smart_casa_show_share_links(array(
							'type' => 'block',
							'caption' => '',
							'before' => '<span class="post_meta_item post_share"><span class="post_meta_share_label">'. esc_html__('Share:', 'smart-casa') .'</span>',
							'after' => '</span>'
						));
				}
			?></div><?php

			do_action('smart_casa_action_after_post_meta'); 
		}
		?>
	</div><!-- .entry-content -->
	

	<?php
	do_action('smart_casa_action_after_post_content'); 

	// Author bio.
	if ( smart_casa_get_theme_option('show_author_info')==1 && is_single() && !is_attachment() && get_the_author_meta( 'description' ) ) {
		do_action('smart_casa_action_before_post_author'); 
		get_template_part( 'templates/author-bio' );
		do_action('smart_casa_action_after_post_author'); 
	}

	do_action('smart_casa_action_after_post_data'); 
	?>
</article>
