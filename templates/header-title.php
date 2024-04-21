<?php
/**
 * The template to display the page title and breadcrumbs
 *
 * @package WordPress
 * @subpackage SMART_CASA
 * @since SMART_CASA 1.0
 */

// Page (category, tag, archive, author) title

if ( smart_casa_need_page_title() ) {
	smart_casa_sc_layouts_showed('title', true);
	smart_casa_sc_layouts_showed('postmeta', true);
	?>
	<div class="top_panel_title sc_layouts_row sc_layouts_row_type_normal">
		<div class="content_wrap">
			<div class="sc_layouts_column sc_layouts_column_align_center">
				<div class="sc_layouts_item">
					<div class="sc_layouts_title sc_align_center">
						<?php
						// Post meta on the single post
						if ( is_single() )  {
							?><div class="sc_layouts_title_meta"><?php
								smart_casa_show_post_meta(apply_filters('smart_casa_filter_post_meta_args', array(
									'components' => smart_casa_array_get_keys_by_value(smart_casa_get_theme_option('meta_parts')),
									'counters' => smart_casa_array_get_keys_by_value(smart_casa_get_theme_option('counters')),
									'seo' => smart_casa_is_on(smart_casa_get_theme_option('seo_snippets'))
									), 'header', 1)
								);
							?></div><?php
						}
						
						// Blog/Post title
						?><div class="sc_layouts_title_title"><?php
							$smart_casa_blog_title = smart_casa_get_blog_title();
							$smart_casa_blog_title_text = $smart_casa_blog_title_class = $smart_casa_blog_title_link = $smart_casa_blog_title_link_text = '';
							if (is_array($smart_casa_blog_title)) {
								$smart_casa_blog_title_text = $smart_casa_blog_title['text'];
								$smart_casa_blog_title_class = !empty($smart_casa_blog_title['class']) ? ' '.$smart_casa_blog_title['class'] : '';
								$smart_casa_blog_title_link = !empty($smart_casa_blog_title['link']) ? $smart_casa_blog_title['link'] : '';
								$smart_casa_blog_title_link_text = !empty($smart_casa_blog_title['link_text']) ? $smart_casa_blog_title['link_text'] : '';
							} else
								$smart_casa_blog_title_text = $smart_casa_blog_title;
							?>
                            <h1 itemprop="headline" class="sc_layouts_title_caption<?php echo esc_attr($smart_casa_blog_title_class); ?>"><?php
                                $smart_casa_top_icon = smart_casa_get_category_icon();
                                if (!empty($smart_casa_top_icon)) {
                                    $smart_casa_attr = smart_casa_getimagesize($smart_casa_top_icon);
                                    ?><img src="<?php echo esc_url($smart_casa_top_icon); ?>" alt="<?php esc_attr_e('Site icon', 'smart-casa'); ?>" <?php if (!empty($smart_casa_attr[3])) smart_casa_show_layout($smart_casa_attr[3]);?>><?php
                                }
                                echo wp_kses($smart_casa_blog_title_text, 'smart_casa_kses_content');
                                ?></h1>
							<?php
							if (!empty($smart_casa_blog_title_link) && !empty($smart_casa_blog_title_link_text)) {
								?><a href="<?php echo esc_url($smart_casa_blog_title_link); ?>" class="theme_button theme_button_small sc_layouts_title_link"><?php echo esc_html($smart_casa_blog_title_link_text); ?></a><?php
							}
							
							// Category/Tag description
							if ( is_category() || is_tag() || is_tax() ) 
								the_archive_description( '<div class="sc_layouts_title_description">', '</div>' );
		
						?></div><?php
	
						// Breadcrumbs
                        if (smart_casa_exists_trx_addons()) {
                            ?><div class="sc_layouts_title_breadcrumbs"><?php
                                do_action( 'smart_casa_action_breadcrumbs');
                            ?></div><?php
                        }?>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php
}
?>