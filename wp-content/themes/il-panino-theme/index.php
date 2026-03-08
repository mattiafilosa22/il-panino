<?php
/**
 * Main template file.
 *
 * @package il-panino-theme
 */

get_header(); ?>

<main id="primary" class="site-main">
    <?php
    if ( have_posts() ) :
        while ( have_posts() ) :
            the_post();
            the_content();
        endwhile;
    else :
        echo '<p>Nessun contenuto trovato.</p>';
    endif;
    ?>
</main><!-- #main -->

<?php
get_footer();
