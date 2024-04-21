<?php
/**
 * The template to display the Author bio
 *
 * @package WordPress
 * @subpackage SMART_CASA
 * @since SMART_CASA 1.0
 */
?>

<div class="author_info scheme_default author vcard" itemprop="author" itemscope itemtype="//schema.org/Person">

    <div class="author_avatar" itemprop="image">
        <?php
        $smart_casa_mult = smart_casa_get_retina_multiplier();
        echo get_avatar( get_the_author_meta( 'user_email' ), 200*$smart_casa_mult );
        ?>
    </div><!-- .author_avatar -->

    <div class="author_description">
        <span class="about_author"><?php echo esc_html__('About Author', 'smart-casa' )?></span>
        <a class="author_link" href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" rel="author">
            <h5 class="author_title" itemprop="name"><?php
                echo get_the_author();
            ?></h5>
        </a>
        <div class="author_bio" itemprop="description">
            <?php echo wp_kses(wpautop(get_the_author_meta( 'description' )), 'smart_casa_kses_content'); ?>
            <?php do_action('smart_casa_action_user_meta'); ?>
        </div><!-- .author_bio -->

    </div><!-- .author_description -->

</div><!-- .author_info -->

