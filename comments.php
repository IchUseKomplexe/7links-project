<?php
/**
 * The template to display the Comments.
 *
 * The area of the page that contains both current comments
 * and the comment form. 
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if ( post_password_required() )
	return;



// Callback for output single comment layout
if (!function_exists('smart_casa_output_single_comment')) {
	function smart_casa_output_single_comment( $comment, $args, $depth ) {
		switch ( $comment->comment_type ) {
			case 'pingback' :
				?>
				<li class="trackback"><?php esc_html_e( 'Trackback:', 'smart-casa' ); ?> <?php comment_author_link(); ?><?php edit_comment_link( esc_html__( 'Edit', 'smart-casa' ), '<span class="edit-link">', '<span>' ); ?>
				<?php
				break;
			case 'trackback' :
				?>
				<li class="pingback"><?php esc_html_e( 'Pingback:', 'smart-casa' ); ?> <?php comment_author_link(); ?><?php edit_comment_link( esc_html__( 'Edit', 'smart-casa' ), '<span class="edit-link">', '<span>' ); ?>
				<?php
				break;
			default :
				$author_id = $comment->user_id;
				$author_link = !empty($author_id) ? get_author_posts_url( $author_id ) : '';
				$mult = smart_casa_get_retina_multiplier();
				?>
				<li id="comment-<?php comment_ID(); ?>" <?php comment_class('comment_item'); ?>>
					<div id="comment_body-<?php comment_ID(); ?>" class="comment_body">
						<div class="comment_author_avatar"><?php echo get_avatar( $comment, 90*$mult ); ?></div>
						<div class="comment_content">
							<div class="comment_info">
                                <div class="comment_posted">
                                    <span class="comment_posted_label"><?php esc_html_e('Posted', 'smart-casa'); ?></span>
                                    <span class="comment_date"><?php
                                        echo esc_html(get_comment_date(get_option('date_format')));
                                        ?></span>
                                    <span class="comment_time"><?php
                                        echo esc_html(get_comment_date(get_option('time_format')));
                                        ?></span>
                                    <?php if ( $comment->comment_approved == 1 ) { ?>
                                        <span class="comment_counters"><?php smart_casa_show_comment_counters(); ?></span>
                                    <?php } ?>
                                </div>
								<h6 class="comment_author"><?php

									echo (!empty($author_link) ? '<a href="'.esc_url($author_link).'">' : '')
                                            . esc_html__('by', 'smart-casa') . ' '
											. esc_html(get_comment_author())
											. (!empty($author_link) ? '</a>' : '');
								?></h6>
							</div>
							<div class="comment_text_wrap">
								<?php if ( $comment->comment_approved == 0 ) { ?>
								<div class="comment_not_approved"><?php esc_html_e( 'Your comment is awaiting moderation.', 'smart-casa' ); ?></div>
								<?php } ?>
								<div class="comment_text"><?php comment_text(); ?></div>
							</div>
							<?php
							if ($depth < $args['max_depth']) {
								?><div class="reply comment_reply"><?php 
									comment_reply_link( array_merge( $args, array(
																				'add_below' => 'comment_body',
																				'depth' => $depth, 
																				'max_depth' => $args['max_depth']
																				)
																	)
														);
								?></div><?php
							}
							?>
						</div>
					</div>
				<?php
				break;
		}
	}
}


// Return template for the single field in the comments
if (!function_exists('smart_casa_single_comments_field')) {
	function smart_casa_single_comments_field($args) {
		$path_height = $args['form_style'] == 'path' 
							? ($args['field_type'] == 'text' ? 75 : 190)
							: 0;
		return '<div class="comments_field comments_'.esc_attr($args['field_name']).'">'
					. ($args['form_style'] == 'default' 
						? '<label for="comment" class="'.esc_attr($args['field_req'] ? 'required' : 'optional') . '">' . esc_html($args['field_title']) . '</label>'
						: ''
						)
					. '<span class="sc_form_field_wrap">'
						. ($args['field_type']=='text'
							? '<input id="'.esc_attr($args['field_name']).'" name="'.esc_attr($args['field_name']).'" type="text"' . ($args['form_style']=='default' ? ' placeholder="'.esc_attr($args['field_placeholder']) . ($args['field_req'] ? ' *' : '') . '"' : '') . ' value="' . esc_attr($args['field_value']) . '"' . ( $args['field_req'] ? ' aria-required="true"' : '' ) . ' />'
							: '<textarea id="'.esc_attr($args['field_name']).'" name="'.esc_attr($args['field_name']).'"' . ($args['form_style']=='default' ? ' placeholder="'.esc_attr($args['field_placeholder']) . ($args['field_req'] ? ' *' : '') . '"' : '') . ( $args['field_req'] ? ' aria-required="true"' : '' ) . '></textarea>'
							)
						. ($args['form_style']!='default'
							? '<span class="sc_form_field_hover">'
									. ($args['form_style'] == 'path'
										? '<svg class="sc_form_field_graphic" preserveAspectRatio="none" viewBox="0 0 520 ' . intval($path_height) . '" height="100%" width="100%"><path d="m0,0l520,0l0,'.intval($path_height).'l-520,0l0,-'.intval($path_height).'z"></svg>'
										: ''
										)
									. ($args['form_style'] == 'iconed'
										? '<i class="sc_form_field_icon '.esc_attr($args['field_icon']).'"></i>'
										: ''
										)
									. '<span class="sc_form_field_content" data-content="'.esc_attr($args['field_title']).'">'.esc_html($args['field_title']).'</span>'
								. '</span>'
							: ''
							)
					. '</span>'
				. '</div>';
	}
}


// Output comments list
if ( have_comments() || comments_open() ) {
	?>
	<section class="comments_wrap">
	<?php
	if ( have_comments() ) {
	?>
		<div id="comments" class="comments_list_wrap">
			<h3 class="section_title comments_list_title"><?php $smart_casa_post_comments = get_comments_number(); echo esc_html($smart_casa_post_comments); ?> <?php echo esc_html(($smart_casa_post_comments === 1) ? esc_html__('Comment', 'smart-casa') :  esc_html__('Comments', 'smart-casa')); ?></h3>
			<ul class="comments_list">
				<?php
				wp_list_comments( array('callback'=>'smart_casa_output_single_comment') );
				?>
			</ul><!-- .comments_list -->
			<?php if ( !comments_open() && get_comments_number()!=0 && post_type_supports( get_post_type(), 'comments' ) ) { ?>
				<p class="comments_closed"><?php esc_html_e( 'Comments are closed.', 'smart-casa' ); ?></p>
			<?php }	?>
			<div class="comments_pagination"><?php paginate_comments_links(); ?></div>
		</div><!-- .comments_list_wrap -->
	<?php 
	}

	if ( comments_open() ) {
		?>
		<div class="comments_form_wrap">
			<div class="comments_form">
				<?php
				$smart_casa_form_style = esc_attr(smart_casa_get_theme_option('input_hover'));
				if (empty($smart_casa_form_style) || smart_casa_is_inherit($smart_casa_form_style)) $smart_casa_form_style = 'default';
				$smart_casa_commenter = wp_get_current_commenter();
				$smart_casa_req = get_option( 'require_name_email' );
				$smart_casa_comments_args = apply_filters( 'smart_casa_filter_comment_form_args', array(
						// class of the 'form' tag
						'class_form' => 'comment-form ' . ($smart_casa_form_style != 'default' ? 'sc_input_hover_' . esc_attr($smart_casa_form_style) : ''),
						// change the id of send button 
						'id_submit' => 'send_comment',
						// change the title of send button 
						'label_submit' => esc_html__('Leave a comment', 'smart-casa'),
						// change the title of the reply section
						'title_reply' => esc_html__('Leave a comment', 'smart-casa'),
						'title_reply_before' => '<h3 id="reply-title" class="section_title comments_form_title">',
						'title_reply_after' => '</h3>',
						// remove "Logged in as"
						'logged_in_as' => '',
						// remove text before textarea
						'comment_notes_before' => '',
						// remove text after textarea
						'comment_notes_after' => '',
						'fields' => array(
							'author' => smart_casa_single_comments_field(array(
												'form_style' => $smart_casa_form_style,
												'field_type' => 'text',
												'field_req' => $smart_casa_req,
												'field_icon' => 'icon-user',
												'field_value' => isset($smart_casa_commenter['comment_author']) ? $smart_casa_commenter['comment_author'] : '',
												'field_name' => 'author',
												'field_title' => esc_attr__('Name', 'smart-casa'),
												'field_placeholder' => esc_attr__( 'Your Name', 'smart-casa' )
											)),
							'email' => smart_casa_single_comments_field(array(
												'form_style' => $smart_casa_form_style,
												'field_type' => 'text',
												'field_req' => $smart_casa_req,
												'field_icon' => 'icon-mail',
												'field_value' => isset($smart_casa_commenter['comment_author_email']) ? $smart_casa_commenter['comment_author_email'] : '',
												'field_name' => 'email',
												'field_title' => esc_attr__('E-mail', 'smart-casa'),
												'field_placeholder' => esc_attr__( 'Your E-mail', 'smart-casa' )
											))
						),
						// redefine your own textarea (the comment body)
						'comment_field' => smart_casa_single_comments_field(array(
												'form_style' => $smart_casa_form_style,
												'field_type' => 'textarea',
												'field_req' => true,
												'field_icon' => 'icon-feather',
												'field_value' => '',
												'field_name' => 'comment',
												'field_title' => esc_attr__('Comment', 'smart-casa'),
												'field_placeholder' => esc_attr__( 'Your comment', 'smart-casa' )
											)),
				));
			
				comment_form($smart_casa_comments_args);
				?>
			</div>
		</div><!-- /.comments_form_wrap -->
		<?php 
	}
	?>
	</section><!-- /.comments_wrap -->
<?php 
}
?>