<?php
/**
 * Template Name: Menù
 *
 * @package il-panino-theme
 */

get_header(); ?>

<main id="primary" class="site-main menu-template" style="background-color: var(--color-bg-header);">
    <div class="menu-content">
        <?php if ( ! il_panino_is_section_hidden('heading') ) : ?>
            <?php get_template_part('components/heading'); ?>
        <?php endif; ?>
        <?php if ( ! il_panino_is_section_hidden('menu_core') ) : ?>
            <?php get_template_part('components/menu-core'); ?>
        <?php endif; ?>
    </div>
</main>

<?php
get_footer();
