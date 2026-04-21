<?php
/**
 * Template Name: Menù
 *
 * @package il-panino-theme
 */

get_header(); ?>

<main id="primary" class="site-main menu-template" style="background-color: var(--color-bg-header);">
    <div class="menu-content">
        <?php get_template_part('components/heading'); ?>
        <?php get_template_part('components/menu-core'); ?>
    </div>
</main>

<?php
get_footer();
