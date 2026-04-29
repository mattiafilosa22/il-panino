<?php
/**
 * Template Name: Homepage
 *
 * @package il-panino-theme
 */

get_header(); ?>

<main id="primary" class="site-main homepage-template">

    <div class="homepage-content">

        <?php if ( ! il_panino_is_section_hidden('hero_banner') ) : ?>
            <?php get_template_part('components/hero-banner'); ?>
        <?php endif; ?>

        <?php if ( ! il_panino_is_section_hidden('product_slider') ) : ?>
            <?php get_template_part('components/product-slider'); ?>
        <?php endif; ?>

        <?php if ( ! il_panino_is_section_hidden('cross_slider') ) : ?>
            <?php get_template_part('components/cross-slider'); ?>
        <?php endif; ?>

        <?php if ( ! il_panino_is_section_hidden('heading') ) : ?>
            <?php get_template_part('components/heading'); ?>
        <?php endif; ?>

        <?php if ( ! il_panino_is_section_hidden('instagram_feed') ) : ?>
            <?php get_template_part('components/instagram-feed'); ?>
        <?php endif; ?>

    </div>

</main><!-- #main -->

<?php
get_footer();
