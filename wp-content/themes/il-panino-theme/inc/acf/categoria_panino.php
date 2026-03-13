<?php
/**
 * Register ACF fields for Categoria Panino Taxonomy
 */
if( function_exists('acf_add_local_field_group') ):

acf_add_local_field_group(array(
    'key' => 'group_categoria_panino_fields',
    'title' => 'Campi Categoria Panino',
    'fields' => array(
        array(
            'key' => 'field_categoria_panino_colore',
            'label' => 'Colore',
            'name' => 'colore_categoria',
            'type' => 'color_picker',
            'instructions' => 'Scegli il colore esadecimale per questa categoria.',
            'required' => 0,
            'conditional_logic' => 0,
            'wrapper' => array(
                'width' => '50',
                'class' => '',
                'id' => '',
            ),
            'default_value' => '',
            'enable_opacity' => 0,
            'return_format' => 'string',
        ),
        array(
            'key' => 'field_categoria_panino_immagine',
            'label' => 'Immagine',
            'name' => 'immagine_categoria',
            'type' => 'image',
            'instructions' => 'Carica l\'immagine rappresentativa della categoria.',
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
                'param' => 'taxonomy',
                'operator' => '==',
                'value' => 'categoria_panino',
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
