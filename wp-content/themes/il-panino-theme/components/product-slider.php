<?php
/**
 * Component: Product Slider (Homepage)
 */

$titolo = get_field('slider_prodotti_titolo');
$sottotitolo = get_field('slider_prodotti_sottotitolo');
$cta = get_field('slider_prodotti_cta');

// Background images (Torri Desktop)
$sfondo_sinistra = get_field('slider_sfondo_sinistra');
$sfondo_destra = get_field('slider_sfondo_destra');

// Set up WP Query for panini featured only
$args = array(
    'post_type'      => 'panino',
    'posts_per_page' => -1,
    'meta_query'     => array(
        array(
            'key'   => 'panino_featured',
            'value' => '1',
        ),
    ),
);
$panini_query = new WP_Query($args);

// Classe per la posizione della label (sempre in basso a destra)
$label_class = 'c-product-label--bottom-right';

if ($panini_query->have_posts()) :
    $spacing = il_panino_get_spacing_classes('product_slider');
?>
    <section class="c-product-slider js-reveal position-relative py-5 <?php echo esc_attr($spacing); ?>">

        <?php if ($sfondo_sinistra) : ?>
            <div class="c-product-slider__bg-fixed c-product-slider__bg-fixed--left position-absolute top-50 start-0" style="z-index: 1;">
                <img src="<?php echo esc_url($sfondo_sinistra); ?>" alt="">
            </div>
        <?php endif; ?>

        <?php if ($sfondo_destra) : ?>
            <div class="c-product-slider__bg-fixed c-product-slider__bg-fixed--right position-absolute top-25 end-0" style="z-index: 1;">
                <img src="<?php echo esc_url($sfondo_destra); ?>" alt="">
            </div>
        <?php endif; ?>

        <div class="container position-relative" style="z-index: 2;">
            <header class="c-product-slider__header row mb-5 text-center">
                <div class="col-12">
                    <?php if ($titolo) : ?>
                        <h2 class="c-product-slider__title display-4 fw-bold mb-3"><?php echo esc_html($titolo); ?></h2>
                    <?php endif; ?>

                    <?php if ($sottotitolo) : ?>
                        <p class="c-product-slider__subtitle lead mb-4"><?php echo esc_html($sottotitolo); ?></p>
                    <?php endif; ?>

                    <?php if ($cta) : ?>
                        <a href="<?php echo esc_url($cta['url']); ?>" class="c-btn c-btn--primary c-btn--cta" target="<?php echo esc_attr($cta['target'] ?: '_self'); ?>">
                            <?php echo esc_html($cta['title']); ?>
                        </a>
                    <?php endif; ?>
                </div>
            </header>
        </div>

        <div class="c-product-slider__fullwidth position-relative" style="z-index: 2;">
            <div class="c-product-slider__carousel splide js-product-slider" id="homepage-product-slider">
                <div class="splide__track">
                    <ul class="splide__list">
                        <?php while ($panini_query->have_posts()) : $panini_query->the_post();
                            $img_senza_sfondo = get_field('immagine_panino_senza_sfondo');
                            $logo = get_field('logo_panino');
                            $descrizione = get_field('descrizione') ? get_field('descrizione') : get_the_content();

                            // Fallback to post thumbnail if no isolated image
                            $img_url = $img_senza_sfondo ? $img_senza_sfondo['url'] : get_the_post_thumbnail_url(get_the_ID(), 'large');
                            $logo_url = $logo ? $logo['url'] : '';
                        ?>
                            <li class="splide__slide text-center p-3">
                                <div class="c-product-card">
                                    <?php if ($logo_url) : ?>
                                        <div class="c-product-card__bg-logo"></div>
                                    <?php endif; ?>

                                    <figure class="c-product-card__figure position-relative d-inline-block">
                                        <?php if ($img_url) : ?>
                                            <img src="<?php echo esc_url($img_url); ?>" alt="<?php echo esc_attr(get_the_title()); ?>" class="c-product-card__image img-fluid">
                                        <?php endif; ?>

                                        <div class="c-product-label <?php echo esc_attr($label_class); ?> position-absolute z-3">
                                            <span class="c-product-label__text d-inline-block px-3 py-1 fw-bold text-white rounded">
                                                <?php the_title(); ?>
                                            </span>
                                        </div>
                                    </figure>

                                    <?php if ($descrizione) : ?>
                                        <div class="c-product-card__description mt-4 mx-auto" style="max-width: 600px;">
                                            <p><?php echo wp_kses_post($descrizione); ?></p>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </li>
                        <?php endwhile; ?>
                    </ul>
                </div>
            </div>
        </div>
    </section>
    <?php wp_reset_postdata(); ?>
<?php endif; ?>
