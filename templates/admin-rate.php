<?php
/**
 * The template to display Admin notices
 *
 * @package WordPress
 * @subpackage SMART_CASA
 * @since SMART_CASA 1.0.1
 */
 
$smart_casa_theme_obj = wp_get_theme();

?>
<div class="smart_casa_admin_notice smart_casa_rate_notice update-nag"><?php
    // Theme image
    if ( ($smart_casa_theme_img = smart_casa_get_file_url('screenshot.jpg')) != '') {
        ?><div class="smart_casa_notice_image"><img src="<?php echo esc_url($smart_casa_theme_img); ?>" alt="<?php esc_attr_e('Theme screenshot', 'smart-casa'); ?>"></div><?php
    }

	// Title
	?><h3 class="smart_casa_notice_title"><a href="<?php echo esc_url(smart_casa_storage_get('theme_download_url')); ?>" target="_blank"><?php
		// Translators: Add theme name and version to the 'Welcome' message
		echo esc_html(sprintf(esc_html__('Rate our theme "%s", please', 'smart-casa'),
				$smart_casa_theme_obj->name . (SMART_CASA_THEME_FREE ? ' ' . esc_html__('Free', 'smart-casa') : '')
				));
	?></a></h3><?php
	
	// Description
	?><div class="smart_casa_notice_text">
		<p><?php echo wp_kses_data(__('We are glad you chose our WP theme for your website. You’ve done well customizing your website and we hope that you’ve enjoyed working with our theme.', 'smart-casa')); ?></p>
		<p><?php echo wp_kses_data(__('It would be just awesome if you spend just a minute of your time to rate our theme or the customer service you’ve received from us.', 'smart-casa')); ?></p>
		<p class="smart_casa_notice_text_info"><?php echo wp_kses_data(__('* We love receiving your reviews! Every time you leave a review, our CEO Henry Rise gives $5 to homeless dog shelter! Save the planet with us!', 'smart-casa')); ?></p>
	</div><?php

	// Buttons
	?><div class="smart_casa_notice_buttons"><?php
		// Link to the theme download page
		?><a href="<?php echo esc_url(smart_casa_storage_get('theme_download_url')); ?>" class="button button-primary" target="_blank"><i class="dashicons dashicons-star-filled"></i> <?php
			// Translators: Add theme name
			echo esc_html(sprintf(esc_html__('Rate theme %s', 'smart-casa'), $smart_casa_theme_obj->name));
		?></a><?php
		// Link to the theme support
		?><a href="<?php echo esc_url(smart_casa_storage_get('theme_support_url')); ?>" class="button" target="_blank"><i class="dashicons dashicons-sos"></i> <?php
			esc_html_e('Support', 'smart-casa');
		?></a><?php
		// Link to the theme documentation
		?><a href="<?php echo esc_url(smart_casa_storage_get('theme_doc_url')); ?>" class="button" target="_blank"><i class="dashicons dashicons-book"></i> <?php
			esc_html_e('Documentation', 'smart-casa');
		?></a><?php
		// Dismiss
		?><a href="#" class="smart_casa_hide_notice"><i class="dashicons dashicons-dismiss"></i> <span class="smart_casa_hide_notice_text"><?php esc_html_e('Dismiss', 'smart-casa'); ?></span></a>
	</div>
</div>