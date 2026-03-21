<?php
/**
 * ACF: Cross Slider (Fasce Marquee Diagonali)
 */

if( function_exists('acf_add_local_field_group') ) {
    acf_add_local_field_group(array(
        'key' => 'group_cross_slider',
        'title' => 'Cross Slider (Fasce Animate)',
        'fields' => array(
            array(
                'key' => 'field_cross_slider_testo_1',
                'label' => 'Testo Fascia 1',
                'name' => 'cross_slider_testo_1',
                'type' => 'text',
                'instructions' => 'Testo della prima fascia (scorre verso sinistra).',
                'required' => 1,
                'wrapper' => array( 'width' => '33' ),
            ),
            array(
                'key' => 'field_cross_slider_testo_2',
                'label' => 'Testo Fascia 2',
                'name' => 'cross_slider_testo_2',
                'type' => 'text',
                'instructions' => 'Testo della seconda fascia (scorre verso destra).',
                'required' => 1,
                'wrapper' => array( 'width' => '33' ),
            ),
            array(
                'key' => 'field_cross_slider_testo_3',
                'label' => 'Testo Fascia 3',
                'name' => 'cross_slider_testo_3',
                'type' => 'text',
                'instructions' => 'Testo della terza fascia (scorre verso sinistra).',
                'required' => 1,
                'wrapper' => array( 'width' => '33' ),
            ),
            array(
                'key' => 'field_cross_slider_icona_1',
                'label' => 'Icona 1',
                'name' => 'cross_slider_icona_1',
                'type' => 'image',
                'instructions' => 'Prima icona che appare tra le parole del testo.',
                'return_format' => 'url',
                'mime_types' => 'png,webp,svg',
                'wrapper' => array( 'width' => '25' ),
            ),
            array(
                'key' => 'field_cross_slider_icona_2',
                'label' => 'Icona 2',
                'name' => 'cross_slider_icona_2',
                'type' => 'image',
                'instructions' => 'Seconda icona che appare tra le parole del testo.',
                'return_format' => 'url',
                'mime_types' => 'png,webp,svg',
                'wrapper' => array( 'width' => '25' ),
            ),
            array(
                'key' => 'field_cross_slider_icona_3',
                'label' => 'Icona 3',
                'name' => 'cross_slider_icona_3',
                'type' => 'image',
                'instructions' => 'Terza icona che appare tra le parole del testo.',
                'return_format' => 'url',
                'mime_types' => 'png,webp,svg',
                'wrapper' => array( 'width' => '25' ),
            ),
            array(
                'key' => 'field_cross_slider_icona_4',
                'label' => 'Icona 4',
                'name' => 'cross_slider_icona_4',
                'type' => 'image',
                'instructions' => 'Quarta icona che appare tra le parole del testo.',
                'return_format' => 'url',
                'mime_types' => 'png,webp,svg',
                'wrapper' => array( 'width' => '25' ),
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
        'menu_order' => 15,
        'position' => 'normal',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
        'active' => true,
        'show_in_rest' => 1,
    ));
}
