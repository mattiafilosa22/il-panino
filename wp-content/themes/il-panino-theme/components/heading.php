<?php
/**
 * Component: Heading (Pagina Menù)
 * Titolo grande, sottotitolo e CTA delivery.
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
);
?>

<section class="c-heading">
    <div class="container">

        <?php if ($titolo) : ?>
            <h1 class="c-heading__title"><?php echo esc_html($titolo); ?></h1>
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
