<?php
/**
 * The Footer: widgets area, logo, footer menu and socials
 *
 * @package WordPress
 * @subpackage SMART_CASA
 * @since SMART_CASA 1.0
 */

						// Widgets area inside page content
						smart_casa_create_widgets_area('widgets_below_content');
						?>				
					</div><!-- </.content> -->

					<?php
					// Show main sidebar
					get_sidebar();

					// Widgets area below page content
					smart_casa_create_widgets_area('widgets_below_page');

					$smart_casa_body_style = smart_casa_get_theme_option('body_style');
					if ($smart_casa_body_style != 'fullscreen') {
						?></div><!-- </.content_wrap> --><?php
					}
					?>
			</div><!-- </.page_content_wrap> -->

			<?php
			// Footer
			$smart_casa_footer_type = smart_casa_get_theme_option("footer_type");
			if ($smart_casa_footer_type == 'custom' && !smart_casa_is_layouts_available())
				$smart_casa_footer_type = 'default';
			get_template_part( "templates/footer-{$smart_casa_footer_type}");
			?>

		</div><!-- /.page_wrap -->

	</div><!-- /.body_wrap -->

    <?php
    $socials_description = smart_casa_get_theme_option('custom_section_socials_description');

    if (smart_casa_exists_trx_addons() && smart_casa_is_on(smart_casa_get_theme_option('custom_section_socials'))) { ?>
        <div class="custom_section">
            <div class="custom_section_container"><?php
                    if (!empty($socials_description))  { ?>
                        <span class="socials_description"><?php smart_casa_show_layout($socials_description); ?></span>
                    <?php } ?>
                    <div class="custom_section_socials socials_wrap">
                        <?php smart_casa_show_layout(smart_casa_get_socials_links())?>
                    </div>
            </div>
        </div>
    <?php } ?>

	<?php if (false && smart_casa_is_on(smart_casa_get_theme_option('debug_mode')) && smart_casa_get_file_dir('images/makeup.jpg')!='') { ?>
		<img src="<?php echo esc_url(smart_casa_get_file_url('images/makeup.jpg')); ?>" id="makeup">
	<?php } ?>

	<?php wp_footer(); ?>

</body>
</html>