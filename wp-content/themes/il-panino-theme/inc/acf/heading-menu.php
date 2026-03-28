<?php
/**
 * Register ACF fields for Menu Heading section
 */
if( function_exists('acf_add_local_field_group') ):

acf_add_local_field_group(array(
    'key' => 'group_heading_menu',
    'title' => 'Scopri il nostro menu - Heading',
    'fields' => array(
        array(
            'key' => 'field_heading_titolo',
            'label' => 'Titolo',
            'name' => 'heading_titolo',
            'type' => 'text',
            'instructions' => 'Titolo grande della sezione (es. SCOPRI IL NOSTRO MENU)',
            'required' => 0,
            'default_value' => 'SCOPRI IL NOSTRO MENU',
            'placeholder' => 'SCOPRI IL NOSTRO MENU',
        ),
        array(
            'key' => 'field_heading_sottotitolo',
            'label' => 'Sottotitolo',
            'name' => 'heading_sottotitolo',
            'type' => 'textarea',
            'instructions' => 'Testo descrittivo sotto il titolo.',
            'required' => 0,
            'rows' => 3,
            'new_lines' => 'br',
        ),
        // Glovo
        array(
            'key' => 'field_heading_glovo_visibile',
            'label' => 'Mostra pulsante Glovo',
            'name' => 'heading_glovo_visibile',
            'type' => 'true_false',
            'default_value' => 1,
            'ui' => 1,
            'wrapper' => array('width' => '33'),
        ),
        array(
            'key' => 'field_heading_glovo_link',
            'label' => 'Link Glovo',
            'name' => 'heading_glovo_link',
            'type' => 'url',
            'instructions' => 'URL della pagina Glovo. Se vuoto il pulsante sarà disabilitato.',
            'required' => 0,
            'conditional_logic' => array(
                array(
                    array(
                        'field' => 'field_heading_glovo_visibile',
                        'operator' => '==',
                        'value' => '1',
                    ),
                ),
            ),
            'wrapper' => array('width' => '67'),
        ),
        // Deliveroo
        array(
            'key' => 'field_heading_deliveroo_visibile',
            'label' => 'Mostra pulsante Deliveroo',
            'name' => 'heading_deliveroo_visibile',
            'type' => 'true_false',
            'default_value' => 1,
            'ui' => 1,
            'wrapper' => array('width' => '33'),
        ),
        array(
            'key' => 'field_heading_deliveroo_link',
            'label' => 'Link Deliveroo',
            'name' => 'heading_deliveroo_link',
            'type' => 'url',
            'instructions' => 'URL della pagina Deliveroo. Se vuoto il pulsante sarà disabilitato.',
            'required' => 0,
            'conditional_logic' => array(
                array(
                    array(
                        'field' => 'field_heading_deliveroo_visibile',
                        'operator' => '==',
                        'value' => '1',
                    ),
                ),
            ),
            'wrapper' => array('width' => '67'),
        ),
        // Just Eat
        array(
            'key' => 'field_heading_justeat_visibile',
            'label' => 'Mostra pulsante Just Eat',
            'name' => 'heading_justeat_visibile',
            'type' => 'true_false',
            'default_value' => 1,
            'ui' => 1,
            'wrapper' => array('width' => '33'),
        ),
        array(
            'key' => 'field_heading_justeat_link',
            'label' => 'Link Just Eat',
            'name' => 'heading_justeat_link',
            'type' => 'url',
            'instructions' => 'URL della pagina Just Eat. Se vuoto il pulsante sarà disabilitato.',
            'required' => 0,
            'conditional_logic' => array(
                array(
                    array(
                        'field' => 'field_heading_justeat_visibile',
                        'operator' => '==',
                        'value' => '1',
                    ),
                ),
            ),
            'wrapper' => array('width' => '67'),
        ),
    ),
    'location' => array(
        array(
            array(
                'param' => 'page_template',
                'operator' => '==',
                'value' => 'template-menu.php',
            ),
        ),
        array(
            array(
                'param' => 'page_template',
                'operator' => '==',
                'value' => 'template-homepage.php',
            ),
        ),
    ),
    'menu_order' => 0,
    'position' => 'normal',
    'style' => 'default',
    'label_placement' => 'top',
    'instruction_placement' => 'label',
    'active' => true,
    'description' => 'Campi per la sezione heading della pagina menù.',
    'show_in_rest' => 1,
));

endif;
