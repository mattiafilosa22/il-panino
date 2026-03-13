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

// Set up WP Query for panini
$args = array(
    'post_type' => 'panino',
    'posts_per_page' => -1, // Get all
);
$panini_query = new WP_Query($args);

// Array di classi per le posizioni della label
$label_positions_map = array(
    'top-left' => 'c-product-label--top-left',
    'top-right' => 'c-product-label--top-right',
    'bottom-left' => 'c-product-label--bottom-left',
    'bottom-right' => 'c-product-label--bottom-right',
);

if ($panini_query->have_posts()) : ?>
    <section class="c-product-slider position-relative overflow-hidden py-5">
        
        <?php if ($sfondo_sinistra) : ?>
            <div class="c-product-slider__bg-fixed c-product-slider__bg-fixed--left position-absolute bottom-0 start-0 h-100 d-none d-lg-block" style="z-index: 1;">
                <img src="<?php echo esc_url($sfondo_sinistra); ?>" alt="" class="h-100 w-auto object-fit-contain object-position-bottom">
            </div>
        <?php endif; ?>

        <?php if ($sfondo_destra) : ?>
            <div class="c-product-slider__bg-fixed c-product-slider__bg-fixed--right position-absolute bottom-0 end-0 h-100 d-none d-lg-block" style="z-index: 1;">
                <img src="<?php echo esc_url($sfondo_destra); ?>" alt="" class="h-100 w-auto object-fit-contain object-position-bottom">
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

            <div class="row">
                <div class="col-12">
                    <div class="c-product-slider__carousel splide js-product-slider" id="homepage-product-slider">
                        <div class="splide__track">
                            <ul class="splide__list">
                                <?php while ($panini_query->have_posts()) : $panini_query->the_post(); 
                                    $img_senza_sfondo = get_field('immagine_panino_senza_sfondo');
                                    $logo = get_field('logo_panino');
                                    $descrizione = get_field('descrizione') ? get_field('descrizione') : get_the_content();
                                    $label_pos = get_field('posizione_label_nome');
                                    $label_class = isset($label_positions_map[$label_pos]) ? $label_positions_map[$label_pos] : 'c-product-label--bottom-left';
                                    
                                    // Fallback to post thumbnail if no isolated image
                                    $img_url = $img_senza_sfondo ? $img_senza_sfondo['url'] : get_the_post_thumbnail_url(get_the_ID(), 'large');
                                    $logo_url = $logo ? $logo['url'] : '';
                                ?>
                                    <li class="splide__slide c-product-card text-center p-3">
                                        
                                        <?php if ($logo_url) : ?>
                                            <div class="c-product-card__bg-logo" style="background-image: url('<?php echo esc_url($logo_url); ?>');"></div>
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
                                    </li>
                                <?php endwhile; ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <?php wp_reset_postdata(); ?>
<?php endif; ?>
