<?php
/**
 * Component: Menu Core
 * Grid di prodotti con filtro per categoria.
 *
 * Ordinamento categorie: via term_meta 'menu_order' (numerico crescente),
 * fallback alfabetico se il meta non è valorizzato.
 */

// NOTA orderby: usiamo solo 'meta_value_num' (non 'meta_value_num name').
// get_terms() non supporta un secondo campo nello stesso orderby: WP ignora
// il token successivo e produce un ORDER BY singolo. Per un tie-break
// alfabetico servirebbe una seconda query o un usort PHP; non utile qui
// perché i menu_order delle categorie sono tutti distinti (10/20/30/40/50).
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

// Avoid ! empty(): it would discard a legitimate 0 (free item).
$has_value = static function ($value) {
    return $value !== '' && $value !== null && $value !== false;
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

        <?php get_template_part('components/menu-banner'); ?>

        <div class="c-menu-core__grid js-menu-grid">
            <?php while ($panini_query->have_posts()) : $panini_query->the_post();

                $img_senza_sfondo = get_field('immagine_panino_senza_sfondo');
                $prezzo_medium    = get_field('prezzo_medium');
                $prezzo_large     = get_field('prezzo_large');
                $prezzo_xxl       = get_field('prezzo_xxl');
                $ingredienti      = get_field('ingredienti');
                $allergeni        = get_field('allergeni');
                $is_vegan         = (bool) get_field('panino_vegan');
                $whatsapp_enabled = (bool) get_field('panino_whatsapp_enabled');

                $img_url = $img_senza_sfondo ? $img_senza_sfondo['url'] : get_the_post_thumbnail_url(get_the_ID(), 'large');
                $img_alt = $img_senza_sfondo ? $img_senza_sfondo['alt'] : get_the_title();

                $has_medium = $has_value($prezzo_medium);
                $has_large  = $has_value($prezzo_large);
                $has_xxl    = $has_value($prezzo_xxl);
                $has_sizes  = $has_large || $has_xxl;

                $terms = get_the_terms(get_the_ID(), 'categoria_panino');
                $term_slugs = ($terms && ! is_wp_error($terms)) ? wp_list_pluck($terms, 'slug') : array();
                $cat_slugs = ! empty($term_slugs) ? implode(' ', $term_slugs) : '';

                $whatsapp_url = '';
                if ($whatsapp_enabled) {
                    $whatsapp_url = il_panino_get_whatsapp_order_url(
                        get_the_ID(),
                        get_the_title(),
                        $term_slugs
                    );
                }

                $card_classes = array('c-menu-card', 'js-menu-card');
                if ($is_vegan) {
                    $card_classes[] = 'c-menu-card--vegan';
                }
            ?>
                <article class="<?php echo esc_attr(implode(' ', $card_classes)); ?>" data-categories="<?php echo esc_attr($cat_slugs); ?>">

                    <?php if ($img_url) : ?>
                        <div class="c-menu-card__image-wrap">
                            <img src="<?php echo esc_url($img_url); ?>"
                                 alt="<?php echo esc_attr($img_alt); ?>"
                                 class="c-menu-card__image"
                                 loading="lazy">
                        </div>
                    <?php endif; ?>

                    <div class="c-menu-card__body">
                        <?php if ($is_vegan) : ?>
                            <span class="c-menu-card__badge c-menu-card__badge--vegan" aria-label="<?php echo esc_attr__('Alternativa vegana', 'il-panino-theme'); ?>">VEG</span>
                        <?php endif; ?>

                        <h3 class="c-menu-card__name"><?php the_title(); ?></h3>

                        <?php if ($has_medium) : ?>
                            <div class="c-menu-card__sizes">
                                <?php if ($has_sizes) : ?>
                                    <div class="c-menu-card__size-row">
                                        <span class="c-menu-card__size-label">Medium</span>
                                        <span class="c-menu-card__size-price">&euro;&nbsp;<?php echo esc_html($fmt_price($prezzo_medium)); ?></span>
                                    </div>
                                    <?php if ($has_large) : ?>
                                        <div class="c-menu-card__size-row">
                                            <span class="c-menu-card__size-label">Large</span>
                                            <span class="c-menu-card__size-price">&euro;&nbsp;<?php echo esc_html($fmt_price($prezzo_large)); ?></span>
                                        </div>
                                    <?php endif; ?>
                                    <?php if ($has_xxl) : ?>
                                        <div class="c-menu-card__size-row">
                                            <span class="c-menu-card__size-label">XXL</span>
                                            <span class="c-menu-card__size-price">&euro;&nbsp;<?php echo esc_html($fmt_price($prezzo_xxl)); ?></span>
                                        </div>
                                    <?php endif; ?>
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

                        <?php if ($whatsapp_enabled && $whatsapp_url) : ?>
                            <a class="c-menu-card__cta c-menu-card__cta--whatsapp"
                               href="<?php echo esc_url($whatsapp_url); ?>"
                               target="_blank"
                               rel="noopener noreferrer"
                               aria-label="<?php echo esc_attr__('Ordina su WhatsApp', 'il-panino-theme'); ?>">
                                <span><?php echo esc_html__('Ordina su', 'il-panino-theme'); ?></span>
                                <img src="https://cdn.simpleicons.org/whatsapp/white"
                                     alt="WhatsApp"
                                     class="c-menu-card__cta-icon">
                            </a>
                            <p class="c-menu-card__delivery-note"><em><?php echo esc_html__('La consegna costa 1€ in più rispetto al prezzo mostrato.', 'il-panino-theme'); ?></em></p>
                        <?php endif; ?>
                    </div>

                </article>
            <?php endwhile; ?>
        </div>

    </div>
</section>
<?php wp_reset_postdata(); ?>
