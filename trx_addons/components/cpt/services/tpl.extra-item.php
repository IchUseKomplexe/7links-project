<?php
/**
 * The style "extra" of the Services item
 *
 * @package WordPress
 * @subpackage ThemeREX Addons
 * @since v1.6.13
 */

$args = get_query_var('trx_addons_args_sc_services');
$number = get_query_var('trx_addons_args_item_number');

$meta = get_post_meta(get_the_ID(), 'trx_addons_options', true);
$link = get_permalink();
$svg_present = false;
$image = '';
if ( has_post_thumbnail() ) {
    $image = trx_addons_get_attachment_url( get_post_thumbnail_id( get_the_ID() ), trx_addons_get_thumb_size('square') );
}
if (empty($args['id'])) $args['id'] = 'sc_services_'.str_replace('.', '', mt_rand());
if (empty($args['featured'])) $args['featured'] = 'icon';
if (empty($args['hide_bg_image'])) $args['hide_bg_image'] = 0;

if (!empty($args['slider'])) {
    ?><div class="slider-slide swiper-slide"><?php
} else if ((int)$args['columns'] > 1) {
    ?><div class="<?php echo esc_attr(trx_addons_get_column_class(1, $args['columns'])); ?> "><?php
}
?>
    <div class="sc_services_item<?php echo !empty($image) ? ' with_image' : ''; ?>"<?php
    if (!empty($args['popup'])) {
        ?> data-post_id="<?php echo esc_attr(get_the_ID()); ?>"<?php
        ?> data-post_type="<?php echo esc_attr(TRX_ADDONS_CPT_SERVICES_PT); ?>"<?php
    }
    ?>>
        <div class="sc_services_item_header"<?php if (!empty($image)) echo ' style="background-image: url('.esc_url($image).');"'; ?>>
            <div class="sc_services_item_header_inner">
                <h6 class="sc_services_item_title"><?php
                    if (!empty($link)) {
                    ?><a href="<?php echo esc_url($link); ?>"><?php
                        }
                        the_title();
                        if (!empty($link)) {
                        ?></a><?php
                }
                ?></h6><?php
                if (!empty($meta['price'])) {
                    ?><div class="sc_services_item_price"><?php echo esc_html($meta['price']); ?></div><?php
                }
            ?></div><?php
            if (!empty($link)) {
                ?><a class="sc_services_item_link" href="<?php echo esc_url($link); ?>"></a><?php
            }
            ?>
        </div>
    </div>
<?php
if (!empty($args['slider']) || (int)$args['columns'] > 1) {
    ?></div><?php
}
if (trx_addons_is_on(trx_addons_get_option('debug_mode')) && $svg_present) {
    wp_enqueue_script( 'vivus', trx_addons_get_file_url(TRX_ADDONS_PLUGIN_SHORTCODES . 'icons/vivus.js'), array('jquery'), null, true );
    wp_enqueue_script( 'trx-addons-sc-icons', trx_addons_get_file_url(TRX_ADDONS_PLUGIN_SHORTCODES . 'icons/icons.js'), array('jquery'), null, true );
}
?>