<?php
/**
 * The template for homepage posts with "Portfolio" style
 *
 * @package WordPress
 * @subpackage SMART_CASA
 * @since SMART_CASA 1.0
 */

smart_casa_storage_set('blog_archive', true);

get_header(); 

if (have_posts()) {

	smart_casa_show_layout(get_query_var('blog_archive_start'));

	$smart_casa_stickies = is_home() ? get_option( 'sticky_posts' ) : false;
	$smart_casa_sticky_out = smart_casa_get_theme_option('sticky_style')=='columns' 
							&& is_array($smart_casa_stickies) && count($smart_casa_stickies) > 0 && get_query_var( 'paged' ) < 1;
	
	// Show filters
	$smart_casa_cat = smart_casa_get_theme_option('parent_cat');
	$smart_casa_post_type = smart_casa_get_theme_option('post_type');
	$smart_casa_taxonomy = smart_casa_get_post_type_taxonomy($smart_casa_post_type);
	$smart_casa_show_filters = smart_casa_get_theme_option('show_filters');
	$smart_casa_tabs = array();
	if (!smart_casa_is_off($smart_casa_show_filters)) {
		$smart_casa_args = array(
			'type'			=> $smart_casa_post_type,
			'child_of'		=> $smart_casa_cat,
			'orderby'		=> 'name',
			'order'			=> 'ASC',
			'hide_empty'	=> 1,
			'hierarchical'	=> 0,
			'taxonomy'		=> $smart_casa_taxonomy,
			'pad_counts'	=> false
		);
		$smart_casa_portfolio_list = get_terms($smart_casa_args);
		if (is_array($smart_casa_portfolio_list) && count($smart_casa_portfolio_list) > 0) {
			$smart_casa_tabs[$smart_casa_cat] = esc_html__('All', 'smart-casa');
			foreach ($smart_casa_portfolio_list as $smart_casa_term) {
				if (isset($smart_casa_term->term_id)) $smart_casa_tabs[$smart_casa_term->term_id] = $smart_casa_term->name;
			}
		}
	}
	if (count($smart_casa_tabs) > 0) {
		$smart_casa_portfolio_filters_ajax = true;
		$smart_casa_portfolio_filters_active = $smart_casa_cat;
		$smart_casa_portfolio_filters_id = 'portfolio_filters';
		?>
		<div class="portfolio_filters smart_casa_tabs smart_casa_tabs_ajax">
			<ul class="portfolio_titles smart_casa_tabs_titles">
				<?php
				foreach ($smart_casa_tabs as $smart_casa_id=>$smart_casa_title) {
					?><li><a href="<?php echo esc_url(smart_casa_get_hash_link(sprintf('#%s_%s_content', $smart_casa_portfolio_filters_id, $smart_casa_id))); ?>" data-tab="<?php echo esc_attr($smart_casa_id); ?>"><?php echo esc_html($smart_casa_title); ?></a></li><?php
				}
				?>
			</ul>
			<?php
			$smart_casa_ppp = smart_casa_get_theme_option('posts_per_page');
			if (smart_casa_is_inherit($smart_casa_ppp)) $smart_casa_ppp = '';
			foreach ($smart_casa_tabs as $smart_casa_id=>$smart_casa_title) {
				$smart_casa_portfolio_need_content = $smart_casa_id==$smart_casa_portfolio_filters_active || !$smart_casa_portfolio_filters_ajax;
				?>
				<div id="<?php echo esc_attr(sprintf('%s_%s_content', $smart_casa_portfolio_filters_id, $smart_casa_id)); ?>"
					class="portfolio_content smart_casa_tabs_content"
					data-blog-template="<?php echo esc_attr(smart_casa_storage_get('blog_template')); ?>"
					data-blog-style="<?php echo esc_attr(smart_casa_get_theme_option('blog_style')); ?>"
					data-posts-per-page="<?php echo esc_attr($smart_casa_ppp); ?>"
					data-post-type="<?php echo esc_attr($smart_casa_post_type); ?>"
					data-taxonomy="<?php echo esc_attr($smart_casa_taxonomy); ?>"
					data-cat="<?php echo esc_attr($smart_casa_id); ?>"
					data-parent-cat="<?php echo esc_attr($smart_casa_cat); ?>"
					data-need-content="<?php echo (false===$smart_casa_portfolio_need_content ? 'true' : 'false'); ?>"
				>
					<?php
					if ($smart_casa_portfolio_need_content) 
						smart_casa_show_portfolio_posts(array(
							'cat' => $smart_casa_id,
							'parent_cat' => $smart_casa_cat,
							'taxonomy' => $smart_casa_taxonomy,
							'post_type' => $smart_casa_post_type,
							'page' => 1,
							'sticky' => $smart_casa_sticky_out
							)
						);
					?>
				</div>
				<?php
			}
			?>
		</div>
		<?php
	} else {
		smart_casa_show_portfolio_posts(array(
			'cat' => $smart_casa_cat,
			'parent_cat' => $smart_casa_cat,
			'taxonomy' => $smart_casa_taxonomy,
			'post_type' => $smart_casa_post_type,
			'page' => 1,
			'sticky' => $smart_casa_sticky_out
			)
		);
	}

	smart_casa_show_layout(get_query_var('blog_archive_end'));

} else {

	if ( is_search() )
		get_template_part( 'content', 'none-search' );
	else
		get_template_part( 'content', 'none-archive' );

}

get_footer();
?>