<?php
/**
 * Register ACF fields for Panino CPT - Menu Page Fields
 */
if( function_exists('acf_add_local_field_group') ):

acf_add_local_field_group(array(
    'key' => 'group_panino_menu_fields',
    'title' => 'Dettagli Menù Panino',
    'fields' => array(
        array(
            'key' => 'field_panino_prezzo',
            'label' => 'Prezzo',
            'name' => 'prezzo',
            'type' => 'number',
            'instructions' => 'Prezzo singolo del panino (es. 11.90)',
            'required' => 0,
            'wrapper' => array(
                'width' => '50',
            ),
            'default_value' => '',
            'placeholder' => '11.90',
            'prepend' => '€',
            'append' => '',
            'min' => 0,
            'max' => '',
            'step' => '0.10',
        ),
        array(
            'key' => 'field_panino_prezzo_menu',
            'label' => 'Prezzo Menù',
            'name' => 'prezzo_menu',
            'type' => 'number',
            'instructions' => 'Prezzo del menù completo (es. 15.90)',
            'required' => 0,
            'wrapper' => array(
                'width' => '50',
            ),
            'default_value' => '',
            'placeholder' => '15.90',
            'prepend' => '€',
            'append' => '',
            'min' => 0,
            'max' => '',
            'step' => '0.10',
        ),
        array(
            'key' => 'field_panino_ingredienti',
            'label' => 'Ingredienti',
            'name' => 'ingredienti',
            'type' => 'textarea',
            'instructions' => 'Lista degli ingredienti (es. Patty, Cheddar, Onion, Pickels, Honeymustard sauce)',
            'required' => 0,
            'wrapper' => array(
                'width' => '100',
            ),
            'default_value' => '',
            'placeholder' => 'Patty, Cheddar, Onion, Pickels, Honeymustard sauce',
            'rows' => 2,
            'new_lines' => 'br',
        ),
        array(
            'key' => 'field_panino_allergeni',
            'label' => 'Allergeni',
            'name' => 'allergeni',
            'type' => 'textarea',
            'instructions' => 'Lista degli allergeni (es. Glutine (grano), Latte, Senape, Solfiti)',
            'required' => 0,
            'wrapper' => array(
                'width' => '100',
            ),
            'default_value' => '',
            'placeholder' => 'Glutine (grano), Latte, Senape',
            'rows' => 2,
            'new_lines' => 'br',
        ),
        array(
            'key' => 'field_panino_descrizione_menu',
            'label' => 'Descrizione Menù',
            'name' => 'descrizione_menu',
            'type' => 'textarea',
            'instructions' => 'Cosa comprende il menù (es. Fries classiche + bibita a scelta)',
            'required' => 0,
            'wrapper' => array(
                'width' => '100',
            ),
            'default_value' => '',
            'placeholder' => 'Fries classiche + bibita a scelta',
            'rows' => 2,
            'new_lines' => 'br',
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
    'menu_order' => 1,
    'position' => 'normal',
    'style' => 'default',
    'label_placement' => 'top',
    'instruction_placement' => 'label',
    'hide_on_screen' => '',
    'active' => true,
    'description' => 'Campi aggiuntivi per la pagina menù.',
    'show_in_rest' => 1,
));

endif;
