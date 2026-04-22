<?php
/**
 * Component: Heading (Pagina Menù)
 * Titolo grande, sottotitolo e CTA delivery.
 *
 * The title renders as an <a class="c-heading__title-link"> to the menu page
 * when the page exists, we are not already on it, and it is published.
 */

$titolo      = get_field('heading_titolo');
$sottotitolo = get_field('heading_sottotitolo');

// Delivery buttons config
$delivery_buttons = array(
    array(
        'name'    => 'Glovo',
        'visible' => get_field('heading_glovo_visibile'),
        'link'    => get_field('heading_glovo_link'),
        'class'   => 'c-heading__cta--glovo',
        'icon'    => 'https://cdn.simpleicons.org/glovo/white',
    ),
    array(
        'name'    => 'Deliveroo',
        'visible' => get_field('heading_deliveroo_visibile'),
        'link'    => get_field('heading_deliveroo_link'),
        'class'   => 'c-heading__cta--deliveroo',
        'icon'    => 'https://cdn.simpleicons.org/deliveroo/white',
    ),
    array(
        'name'    => 'Just Eat',
        'visible' => get_field('heading_justeat_visibile'),
        'link'    => get_field('heading_justeat_link'),
        'class'   => 'c-heading__cta--justeat',
        'icon'    => 'https://cdn.simpleicons.org/justeat/white',
    ),
    array(
        'name'    => 'WhatsApp',
        'visible' => get_field('heading_whatsapp_visibile'),
        'link'    => get_field('heading_whatsapp_link'),
        'class'   => 'c-heading__cta--whatsapp',
        'icon'    => 'https://cdn.simpleicons.org/whatsapp/white',
    ),
);
?>

<?php $spacing = il_panino_get_spacing_classes('heading'); ?>
<section class="c-heading <?php echo esc_attr($spacing); ?>">
    <div class="container">

        <?php if ($titolo) : ?>
            <?php
            // Link the title to the menu page only when it adds value:
            // the page exists, is published, and we are not already on it (avoid self-linking).
            $menu_page     = get_page_by_path('menu', OBJECT, 'page');
            $menu_link_url = '';
            if ($menu_page && $menu_page->post_status === 'publish' && ! is_page($menu_page->ID)) {
                $menu_link_url = get_permalink($menu_page->ID);
            }
            ?>
            <h1 class="c-heading__title">
                <?php if ($menu_link_url) : ?>
                    <a href="<?php echo esc_url($menu_link_url); ?>" class="c-heading__title-link"><?php echo esc_html($titolo); ?></a>
                <?php else : ?>
                    <?php echo esc_html($titolo); ?>
                <?php endif; ?>
            </h1>
        <?php endif; ?>

        <?php if ($sottotitolo) : ?>
            <p class="c-heading__subtitle"><?php echo wp_kses_post($sottotitolo); ?></p>
        <?php endif; ?>

        <?php
        // Controlla se almeno un pulsante è visibile
        $has_visible = false;
        foreach ($delivery_buttons as $btn) {
            if ($btn['visible']) { $has_visible = true; break; }
        }
        ?>

        <?php if ($has_visible) : ?>
            <div class="c-heading__cta-group">
                <?php foreach ($delivery_buttons as $btn) :
                    if ( ! $btn['visible'] ) continue;

                    $has_link   = ! empty($btn['link']);
                    $tag        = $has_link ? 'a' : 'span';
                    $href       = $has_link ? ' href="' . esc_url($btn['link']) . '" target="_blank" rel="noopener noreferrer"' : '';
                    $disabled   = ! $has_link ? ' aria-disabled="true"' : '';
                    $cls_disabled = ! $has_link ? ' is-disabled' : '';
                ?>
                    <<?php echo $tag; ?> class="c-heading__cta <?php echo esc_attr($btn['class'] . $cls_disabled); ?>"<?php echo $href . $disabled; ?>>
                        Ordina su <img src="<?php echo esc_url($btn['icon']); ?>" alt="<?php echo esc_attr($btn['name']); ?>" class="c-heading__cta-icon">
                    </<?php echo $tag; ?>>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

    </div>
</section>
