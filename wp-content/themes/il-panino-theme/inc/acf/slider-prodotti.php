<?php
/**
 * ACF: Slider Prodotti Homepage
 */

if( function_exists('acf_add_local_field_group') ) {
    acf_add_local_field_group(array(
        'key' => 'group_slider_prodotti',
        'title' => 'Slider Prodotti Homepage',
        'fields' => array(
            array(
                'key' => 'field_slider_prodotti_titolo',
                'label' => 'Titolo',
                'name' => 'slider_prodotti_titolo',
                'type' => 'text',
                'instructions' => 'Inserisci il titolo della sezione slider prodotti.',
            ),
            array(
                'key' => 'field_slider_prodotti_sottotitolo',
                'label' => 'Sottotitolo',
                'name' => 'slider_prodotti_sottotitolo',
                'type' => 'textarea',
                'instructions' => 'Inserisci il sottotitolo della sezione slider prodotti.',
                'rows' => 4,
            ),
            array(
                'key' => 'field_slider_prodotti_cta',
                'label' => 'CTA (Call to Action)',
                'name' => 'slider_prodotti_cta',
                'type' => 'link',
                'instructions' => 'Seleziona il link e il testo per il pulsante CTA dello slider.',
                'return_format' => 'array',
            ),
            array(
                'key' => 'field_slider_sfondo_sinistra',
                'label' => 'Immagine Sfondo Sinistra (Desktop)',
                'name' => 'slider_sfondo_sinistra',
                'type' => 'image',
                'instructions' => 'Inserisci l\'immagine decorativa (es. Torri di Bologna) che apparirà a sinistra nello sfondo.',
                'return_format' => 'url',
            ),
            array(
                'key' => 'field_slider_sfondo_destra',
                'label' => 'Immagine Sfondo Destra (Desktop)',
                'name' => 'slider_sfondo_destra',
                'type' => 'image',
                'instructions' => 'Inserisci l\'immagine decorativa (es. Torri di Bologna) che apparirà a destra nello sfondo.',
                'return_format' => 'url',
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'page_template',
                    'operator' => '==',
                    'value' => 'template-homepage.php',
                ),
            ),
        ),
        'menu_order' => 10,
        'position' => 'normal',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
        'hide_on_screen' => '',
        'active' => true,
        'description' => '',
        'show_in_rest' => 1,
    ));
}
