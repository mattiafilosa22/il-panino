<?php
/**
 * Register ACF fields for Panino CPT
 */
if( function_exists('acf_add_local_field_group') ):

acf_add_local_field_group(array(
    'key' => 'group_panino_fields',
    'title' => 'Dettagli Panino',
    'fields' => array(
        array(
            'key' => 'field_panino_immagine_senza_sfondo',
            'label' => 'Immagine Panino Senza Sfondo',
            'name' => 'immagine_panino_senza_sfondo',
            'type' => 'image',
            'instructions' => 'Carica l\'immagine del panino scontornata (senza sfondo).',
            'required' => 0,
            'conditional_logic' => 0,
            'wrapper' => array(
                'width' => '50',
                'class' => '',
                'id' => '',
            ),
            'return_format' => 'array',
            'preview_size' => 'medium',
            'library' => 'all',
            'min_width' => '',
            'min_height' => '',
            'min_size' => '',
            'max_width' => '',
            'max_height' => '',
            'max_size' => '',
            'mime_types' => 'png,webp',
        ),
        array(
            'key' => 'field_panino_logo',
            'label' => 'Logo Panino',
            'name' => 'logo_panino',
            'type' => 'image',
            'instructions' => 'Carica il logo del panino. Questo sarà mostrato nello slider prodotti.',
            'required' => 0,
            'conditional_logic' => 0,
            'wrapper' => array(
                'width' => '50',
                'class' => '',
                'id' => '',
            ),
            'return_format' => 'array',
            'preview_size' => 'medium',
            'library' => 'all',
            'min_width' => '',
            'min_height' => '',
            'min_size' => '',
            'max_width' => '',
            'max_height' => '',
            'max_size' => '',
            'mime_types' => 'png,webp,svg,jpg,jpeg',
        ),
    ),
    'location' => array(
        array(
            array(
                'param' => 'post_type',
                'operator' => '==',
                'value' => 'panino',
            ),
        ),
    ),
    'menu_order' => 0,
    'position' => 'normal',
    'style' => 'default',
    'label_placement' => 'top',
    'instruction_placement' => 'label',
    'hide_on_screen' => '',
    'active' => true,
    'description' => '',
    'show_in_rest' => 1,
));

endif;
