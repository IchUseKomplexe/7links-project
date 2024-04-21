<?php
/**
 * The template to display the site logo in the footer
 *
 * @package WordPress
 * @subpackage SMART_CASA
 * @since SMART_CASA 1.0.10
 */

// Logo
if (smart_casa_is_on(smart_casa_get_theme_option('logo_in_footer'))) {
	$smart_casa_logo_image = smart_casa_get_logo_image('footer');
	$smart_casa_logo_text  = get_bloginfo( 'name' );
	if (!empty($smart_casa_logo_image) || !empty($smart_casa_logo_text)) {
		?>
        <div class="footer_logo_wrap">
        <div class="footer_logo_inner">
            <?php
            if (!empty($smart_casa_logo_image)) {
                $smart_casa_attr = smart_casa_getimagesize($smart_casa_logo_image);
                echo '<a href="'.esc_url(home_url('/')).'">'
                    . '<img src="'.esc_url($smart_casa_logo_image).'"'
                    . ' class="logo_footer_image"'
                    . ' alt="'.esc_attr__('Site logo', 'smart-casa').'"'
                    . (!empty($smart_casa_attr[3]) ? ' ' . wp_kses_data($smart_casa_attr[3]) : '')
                    .'>'
                    . '</a>' ;
            } else if (!empty($smart_casa_logo_text)) {
                echo '<h1 class="logo_footer_text">'
                    . '<a href="'.esc_url(home_url('/')).'">'
                    . esc_html($smart_casa_logo_text)
                    . '</a>'
                    . '</h1>';
            }
            ?>
        </div>
		<?php
	}
}
?>