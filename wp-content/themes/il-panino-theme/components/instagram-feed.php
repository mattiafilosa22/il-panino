<?php
/**
 * Component: Instagram Feed
 * Renderizza uno shortcode (es. Spotlight Social Photo Feeds) configurabile da ACF.
 */

$titolo      = get_field('instagram_feed_titolo');
$sottotitolo = get_field('instagram_feed_sottotitolo');
$shortcode   = get_field('instagram_feed_shortcode');
$spacing     = il_panino_get_spacing_classes('instagram_feed');

if ( ! $shortcode && ! $titolo && ! $sottotitolo ) return;
?>

<section class="c-instagram-feed js-reveal <?php echo esc_attr($spacing); ?>">
    <div class="container">

        <?php if ($titolo) : ?>
            <h2 class="c-instagram-feed__title"><?php echo esc_html($titolo); ?></h2>
        <?php endif; ?>

        <?php if ($sottotitolo) : ?>
            <p class="c-instagram-feed__subtitle"><?php echo wp_kses_post($sottotitolo); ?></p>
        <?php endif; ?>

        <?php if ($shortcode) : ?>
            <div class="c-instagram-feed__embed">
                <?php echo do_shortcode($shortcode); ?>
            </div>
        <?php endif; ?>

    </div>
</section>
