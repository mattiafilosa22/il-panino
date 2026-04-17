<?php
/**
 * Component: Menu Core
 * Grid di prodotti con filtro per categoria.
 *
 * Ordinamento categorie: via term_meta 'menu_order' (numerico crescente),
 * fallback alfabetico se il meta non è valorizzato.
 */

$categorie = get_terms(array(
    'taxonomy'   => 'categoria_panino',
    'hide_empty' => true,
    'meta_key'   => 'menu_order',
    'orderby'    => 'meta_value_num',
    'order'      => 'ASC',
));

$panini_query = new WP_Query(array(
    'post_type'      => 'panino',
    'posts_per_page' => -1,
    'orderby'        => 'title',
    'order'          => 'ASC',
));

if ( ! $panini_query->have_posts() ) return;

$fmt_price = static function ($value) {
    return number_format((float) $value, 2, ',', '.');
};
?>

<?php $spacing = il_panino_get_spacing_classes('menu_core'); ?>
<section class="c-menu-core <?php echo esc_attr($spacing); ?>">
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

                $img_senza_sfondo = get_field('immagine_panino_senza_sfondo');
                $prezzo_medium    = get_field('prezzo_medium');
                $prezzo_large     = get_field('prezzo_large');
                $prezzo_xxl       = get_field('prezzo_xxl');
                $ingredienti      = get_field('ingredienti');
                $allergeni        = get_field('allergeni');

                $img_url = $img_senza_sfondo ? $img_senza_sfondo['url'] : get_the_post_thumbnail_url(get_the_ID(), 'large');
                $img_alt = $img_senza_sfondo ? $img_senza_sfondo['alt'] : get_the_title();

                $has_sizes = ! empty($prezzo_large) && ! empty($prezzo_xxl);

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
                        <h3 class="c-menu-card__name"><?php the_title(); ?></h3>

                        <?php if ($prezzo_medium !== '' && $prezzo_medium !== null) : ?>
                            <div class="c-menu-card__sizes">
                                <?php if ($has_sizes) : ?>
                                    <div class="c-menu-card__size-row">
                                        <span class="c-menu-card__size-label">Medium</span>
                                        <span class="c-menu-card__size-price">&euro;&nbsp;<?php echo esc_html($fmt_price($prezzo_medium)); ?></span>
                                    </div>
                                    <div class="c-menu-card__size-row">
                                        <span class="c-menu-card__size-label">Large</span>
                                        <span class="c-menu-card__size-price">&euro;&nbsp;<?php echo esc_html($fmt_price($prezzo_large)); ?></span>
                                    </div>
                                    <div class="c-menu-card__size-row">
                                        <span class="c-menu-card__size-label">XXL</span>
                                        <span class="c-menu-card__size-price">&euro;&nbsp;<?php echo esc_html($fmt_price($prezzo_xxl)); ?></span>
                                    </div>
                                <?php else : ?>
                                    <div class="c-menu-card__size-row c-menu-card__size-row--flat">
                                        <span class="c-menu-card__size-price">&euro;&nbsp;<?php echo esc_html($fmt_price($prezzo_medium)); ?></span>
                                    </div>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>

                        <hr class="c-menu-card__divider" />

                        <?php if ($ingredienti) : ?>
                            <p class="c-menu-card__ingredienti"><?php echo esc_html($ingredienti); ?></p>
                        <?php endif; ?>

                        <?php if ($allergeni) : ?>
                            <p class="c-menu-card__allergeni">Allergeni: <?php echo esc_html($allergeni); ?></p>
                        <?php endif; ?>
                    </div>

                </article>
            <?php endwhile; ?>
        </div>

    </div>
</section>
<?php wp_reset_postdata(); ?>
