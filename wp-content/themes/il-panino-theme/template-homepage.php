<?php
/**
 * Template Name: Homepage
 *
 * @package il-panino-theme
 */

get_header(); ?>

<main id="primary" class="site-main homepage-template">
    
    <div class="homepage-content">

        <?php get_template_part('components/hero-banner'); ?>

        <?php get_template_part('components/product-slider'); ?>

        <?php get_template_part('components/cross-slider'); ?>

    </div>

</main><!-- #main -->

<?php
get_footer();
