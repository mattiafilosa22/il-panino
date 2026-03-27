<?php
/**
 * Component: Menu Core
 * Grid di prodotti con filtro per categoria.
 */

// Recupera tutte le categorie della tassonomia
$categorie = get_terms(array(
    'taxonomy'   => 'categoria_panino',
    'hide_empty' => true,
    'orderby'    => 'name',
    'order'      => 'ASC',
));

// Query tutti i panini
$panini_query = new WP_Query(array(
    'post_type'      => 'panino',
    'posts_per_page' => -1,
    'orderby'        => 'title',
    'order'          => 'ASC',
));

if ( ! $panini_query->have_posts() ) return;
?>

<section class="c-menu-core">
    <div class="container">

        <?php if ( ! empty($categorie) && ! is_wp_error($categorie) ) : ?>
            <div class="c-menu-core__filters" role="tablist" aria-label="Filtra per categoria">
                <button class="c-menu-core__filter is-active js-menu-filter" data-category="all" role="tab" aria-selected="true">
                    Tutti
                </button>
                <?php foreach ($categorie as $cat) : ?>
                    <button class="c-menu-core__filter js-menu-filter" data-category="<?php echo esc_attr($cat->slug); ?>" role="tab" aria-selected="false">
                        <?php echo esc_html($cat->name); ?>
                    </button>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <div class="c-menu-core__grid js-menu-grid">
            <?php while ($panini_query->have_posts()) : $panini_query->the_post();

                // Campi ACF
                $img_senza_sfondo = get_field('immagine_panino_senza_sfondo');
                $prezzo           = get_field('prezzo');
                $prezzo_menu      = get_field('prezzo_menu');
                $ingredienti      = get_field('ingredienti');
                $allergeni        = get_field('allergeni');
                $descrizione_menu = get_field('descrizione_menu');

                // Immagine: priorità alla scontornata, fallback alla featured
                $img_url = $img_senza_sfondo ? $img_senza_sfondo['url'] : get_the_post_thumbnail_url(get_the_ID(), 'large');
                $img_alt = $img_senza_sfondo ? $img_senza_sfondo['alt'] : get_the_title();

                // Categorie del panino (per data-attribute filtro)
                $terms = get_the_terms(get_the_ID(), 'categoria_panino');
                $cat_slugs = '';
                if ($terms && ! is_wp_error($terms)) {
                    $cat_slugs = implode(' ', wp_list_pluck($terms, 'slug'));
                }
            ?>
                <article class="c-menu-card js-menu-card" data-categories="<?php echo esc_attr($cat_slugs); ?>">

                    <?php if ($img_url) : ?>
                        <div class="c-menu-card__image-wrap">
                            <img src="<?php echo esc_url($img_url); ?>"
                                 alt="<?php echo esc_attr($img_alt); ?>"
                                 class="c-menu-card__image"
                                 loading="lazy">
                        </div>
                    <?php endif; ?>

                    <div class="c-menu-card__body">
                        <div class="c-menu-card__header">
                            <div class="c-menu-card__row">
                                <h3 class="c-menu-card__name"><?php the_title(); ?></h3>
                                <?php if ($prezzo) : ?>
                                    <span class="c-menu-card__price">&euro;<?php echo esc_html(number_format((float)$prezzo, 2, ',', '.')); ?></span>
                                <?php endif; ?>
                            </div>
                            <?php if ($prezzo_menu) : ?>
                                <div class="c-menu-card__row">
                                    <span class="c-menu-card__name c-menu-card__name--menu">Men&ugrave;</span>
                                    <span class="c-menu-card__price">&euro;<?php echo esc_html(number_format((float)$prezzo_menu, 2, ',', '.')); ?></span>
                                </div>
                            <?php endif; ?>
                        </div>

                        <?php if ($ingredienti) : ?>
                            <p class="c-menu-card__ingredienti"><?php echo esc_html($ingredienti); ?></p>
                        <?php endif; ?>

                        <?php if ($allergeni) : ?>
                            <p class="c-menu-card__allergeni">Allergeni: <?php echo esc_html($allergeni); ?></p>
                        <?php endif; ?>

                        <?php if ($descrizione_menu) : ?>
                            <div class="c-menu-card__menu-info">
                                <p class="c-menu-card__menu-info-label">
                                    <span class="c-menu-card__menu-info-icon">&#9432;</span> Men&ugrave;:
                                </p>
                                <ul class="c-menu-card__menu-info-list">
                                    <li>Men&ugrave; comprende: <?php echo esc_html($descrizione_menu); ?></li>
                                </ul>
                            </div>
                        <?php endif; ?>
                    </div>

                </article>
            <?php endwhile; ?>
        </div>

    </div>
</section>
<?php wp_reset_postdata(); ?>
