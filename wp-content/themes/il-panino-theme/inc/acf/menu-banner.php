<?php
/**
 * Register ACF fields for Menu Banner ("Completa il tuo menu") section.
 *
 * Invites users on the menu page to complete their order with sides and drinks.
 * Appears on pages using template-menu.php.
 */
if ( ! function_exists( 'acf_add_local_field_group' ) ) {
    return;
}

acf_add_local_field_group( array(
    'key'    => 'group_menu_banner',
    'title'  => 'Banner "Completa il tuo menu"',
    'fields' => array(
        array(
            'key'           => 'field_menu_banner_visible',
            'label'         => 'Mostra banner',
            'name'          => 'menu_banner_visible',
            'type'          => 'true_false',
            'instructions'  => 'Attiva o disattiva il banner "Completa il tuo menu" sulla pagina menù.',
            'default_value' => 1,
            'ui'            => 1,
        ),
        array(
            'key'               => 'field_menu_banner_title',
            'label'             => 'Titolo',
            'name'              => 'menu_banner_title',
            'type'              => 'text',
            'instructions'      => 'Titolo principale del banner (es. COMPLETA IL TUO MENU).',
            'required'          => 0,
            'default_value'     => 'COMPLETA IL TUO MENU',
            'placeholder'       => 'COMPLETA IL TUO MENU',
            'conditional_logic' => array(
                array(
                    array(
                        'field'    => 'field_menu_banner_visible',
                        'operator' => '==',
                        'value'    => '1',
                    ),
                ),
            ),
        ),
        array(
            'key'               => 'field_menu_banner_subtitle',
            'label'             => 'Sottotitolo',
            'name'              => 'menu_banner_subtitle',
            'type'              => 'textarea',
            'instructions'      => 'Testo descrittivo che invita ad aggiungere frittini e bevanda.',
            'required'          => 0,
            'default_value'     => "Aggiungi frittini e una bevanda ghiacciata al tuo panino per un'esperienza completa.",
            'rows'              => 3,
            'new_lines'         => 'br',
            'conditional_logic' => array(
                array(
                    array(
                        'field'    => 'field_menu_banner_visible',
                        'operator' => '==',
                        'value'    => '1',
                    ),
                ),
            ),
        ),
        array(
            'key'               => 'field_menu_banner_cta_text',
            'label'             => 'Testo CTA',
            'name'              => 'menu_banner_cta_text',
            'type'              => 'text',
            'instructions'      => 'Etichetta del pulsante di invito all\'azione.',
            'required'          => 0,
            'default_value'     => 'SCOPRI LE COMBO',
            'placeholder'       => 'SCOPRI LE COMBO',
            'wrapper'           => array( 'width' => '40' ),
            'conditional_logic' => array(
                array(
                    array(
                        'field'    => 'field_menu_banner_visible',
                        'operator' => '==',
                        'value'    => '1',
                    ),
                ),
            ),
        ),
        array(
            'key'               => 'field_menu_banner_cta_link',
            'label'             => 'Link CTA',
            'name'              => 'menu_banner_cta_link',
            'type'              => 'url',
            'instructions'      => 'URL di destinazione del pulsante. Se vuoto, il pulsante sarà disabilitato.',
            'required'          => 0,
            'default_value'     => '',
            'wrapper'           => array( 'width' => '60' ),
            'conditional_logic' => array(
                array(
                    array(
                        'field'    => 'field_menu_banner_visible',
                        'operator' => '==',
                        'value'    => '1',
                    ),
                ),
            ),
        ),
    ),
    'location' => array(
        array(
            array(
                'param'    => 'page_template',
                'operator' => '==',
                'value'    => 'template-menu.php',
            ),
        ),
    ),
    'menu_order'            => 5,
    'position'              => 'normal',
    'style'                 => 'default',
    'label_placement'       => 'top',
    'instruction_placement' => 'label',
    'active'                => true,
    'description'           => 'Banner promozionale per invitare a completare il menù con frittini e bevanda.',
    'show_in_rest'          => 1,
) );
