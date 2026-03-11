<?php
/**
 * Template Name: Homepage
 *
 * @package il-panino-theme
 */

get_header(); ?>

<main id="primary" class="site-main homepage-template">
    
    <div class="homepage-content">
        <?php
        // Esempio di utilizzo dei campi ACF
        $hero_title = function_exists('get_field') ? get_field('hero_title') : '';
        $hero_subtitle = function_exists('get_field') ? get_field('hero_subtitle') : '';
        ?>
        
        <section class="hero-section">
            <?php if($hero_title): ?>
                <h1><?php echo esc_html($hero_title); ?></h1>
            <?php else: ?>
                <h1><?php the_title(); ?></h1>
            <?php endif; ?>
            
            <?php if($hero_subtitle): ?>
                <p class="subtitle"><?php echo esc_html($hero_subtitle); ?></p>
            <?php endif; ?>
        </section>
        
        <section class="page-content">
            <?php
            while ( have_posts() ) :
                the_post();
                the_content();
            endwhile;
            ?>
        </section>
    </div>

</main><!-- #main -->

<?php
get_footer();
