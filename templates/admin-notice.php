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
<div class="smart_casa_admin_notice smart_casa_welcome_notice update-nag"><?php
	// Theme image
    if ( ($smart_casa_theme_img = smart_casa_get_file_url('screenshot.jpg')) != '') {
        ?><div class="smart_casa_notice_image"><img src="<?php echo esc_url($smart_casa_theme_img); ?>" alt="<?php esc_attr_e('Theme screenshot', 'smart-casa'); ?>"></div><?php
    }

	// Title
	?><h3 class="smart_casa_notice_title"><?php
		// Translators: Add theme name and version to the 'Welcome' message
		echo esc_html(sprintf(esc_html__('Welcome to %1$s v.%2$s', 'smart-casa'),
				$smart_casa_theme_obj->name . (SMART_CASA_THEME_FREE ? ' ' . esc_html__('Free', 'smart-casa') : ''),
				$smart_casa_theme_obj->version
				));
	?></h3><?php

	// Description
	?><div class="smart_casa_notice_text"><?php
		echo str_replace('. ', '.<br>', wp_kses_data($smart_casa_theme_obj->description));
		if (!smart_casa_exists_trx_addons()) {
			echo (!empty($smart_casa_theme_obj->description) ? '<br><br>' : '')
					. wp_kses_data(__('Attention! Plugin "ThemeREX Addons" is required! Please, install and activate it!', 'smart-casa'));
		}
	?></div><?php

	// Buttons
	?><div class="smart_casa_notice_buttons"><?php
		// Link to the page 'About Theme'
		?><a href="<?php echo esc_url(admin_url().'themes.php?page=smart_casa_about'); ?>" class="button button-primary"><i class="dashicons dashicons-nametag"></i> <?php
			// Translators: Add theme name
			echo esc_html(sprintf(esc_html__('About %s', 'smart-casa'), $smart_casa_theme_obj->name));
		?></a><?php
		// Link to the page 'Install plugins'
		if (smart_casa_get_value_gp('page')!='tgmpa-install-plugins') {
			?>
			<a href="<?php echo esc_url(admin_url().'themes.php?page=tgmpa-install-plugins'); ?>" class="button button-primary"><i class="dashicons dashicons-admin-plugins"></i> <?php esc_html_e('Install plugins', 'smart-casa'); ?></a>
			<?php
		}
		// Link to the 'One-click demo import'
		if (function_exists('smart_casa_exists_trx_addons') && smart_casa_exists_trx_addons() && class_exists('trx_addons_demo_data_importer')) {
			?>
			<a href="<?php echo esc_url(admin_url().'themes.php?page=trx_importer'); ?>" class="button button-primary"><i class="dashicons dashicons-download"></i> <?php esc_html_e('One Click Demo Data', 'smart-casa'); ?></a>
			<?php
		}
		// Link to the Customizer
		?><a href="<?php echo esc_url(admin_url().'customize.php'); ?>" class="button"><i class="dashicons dashicons-admin-appearance"></i> <?php esc_html_e('Theme Customizer', 'smart-casa'); ?></a><?php
		// Link to the Theme Options
		if (!SMART_CASA_THEME_FREE) {
			?><span> <?php esc_html_e('or', 'smart-casa'); ?> </span>
        	<a href="<?php echo esc_url(admin_url().'themes.php?page=theme_options'); ?>" class="button"><i class="dashicons dashicons-admin-appearance"></i> <?php esc_html_e('Theme Options', 'smart-casa'); ?></a><?php
        }
        // Dismiss this notice
        ?><a href="#" class="smart_casa_hide_notice"><i class="dashicons dashicons-dismiss"></i> <span class="smart_casa_hide_notice_text"><?php esc_html_e('Dismiss', 'smart-casa'); ?></span></a>
	</div>
</div>