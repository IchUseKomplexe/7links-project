<?php
/**
 * The Header: Logo and main menu
 *
 * @package WordPress
 * @subpackage SMART_CASA
 * @since SMART_CASA 1.0
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js scheme_<?php
										 // Class scheme_xxx need in the <html> as context for the <body>!
										 echo esc_attr(smart_casa_get_theme_option('color_scheme'));
										 ?>">
<head>
	<?php wp_head(); ?>
</head>

<body <?php	body_class(); ?>>
    <?php wp_body_open(); ?>

	<?php do_action( 'smart_casa_action_before_body' ); ?>

	<div class="body_wrap">

		<div class="page_wrap"><?php
			// Desktop header
			$smart_casa_header_type = smart_casa_get_theme_option("header_type");
			if ($smart_casa_header_type == 'custom' && !smart_casa_is_layouts_available())
				$smart_casa_header_type = 'default';
			get_template_part( "templates/header-{$smart_casa_header_type}");

			// Side menu
			if (in_array(smart_casa_get_theme_option('menu_style'), array('left', 'right'))) {
				get_template_part( 'templates/header-navi-side' );
			}
			
			// Mobile menu
			get_template_part( 'templates/header-navi-mobile');
			?>

			<div class="page_content_wrap">

				<?php if (smart_casa_get_theme_option('body_style') != 'fullscreen') { ?>
				<div class="content_wrap">
				<?php } ?>

					<?php
					// Widgets area above page content
					smart_casa_create_widgets_area('widgets_above_page');
					?>				

					<div class="content">
						<?php
						// Widgets area inside page content
						smart_casa_create_widgets_area('widgets_above_content');
						?>				
