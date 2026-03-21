<?php
/**
 * ACF: Footer
 */

if( function_exists('acf_add_local_field_group') ) {
    acf_add_local_field_group(array(
        'key' => 'group_footer',
        'title' => 'Footer',
        'fields' => array(
            // Sitemap
            array(
                'key' => 'field_footer_sitemap_titolo',
                'label' => 'Titolo Sitemap',
                'name' => 'footer_sitemap_titolo',
                'type' => 'text',
                'default_value' => 'Sitemap',
                'wrapper' => array( 'width' => '50' ),
            ),
            // Contatti
            array(
                'key' => 'field_footer_contatti_titolo',
                'label' => 'Titolo Contatti',
                'name' => 'footer_contatti_titolo',
                'type' => 'text',
                'default_value' => 'Contatti',
                'wrapper' => array( 'width' => '50' ),
            ),
            // Indirizzo
            array(
                'key' => 'field_footer_indirizzo_1',
                'label' => 'Indirizzo - Riga 1',
                'name' => 'footer_indirizzo_1',
                'type' => 'text',
                'instructions' => 'Es. "Via del Pratello 29/a"',
                'wrapper' => array( 'width' => '50' ),
            ),
            array(
                'key' => 'field_footer_indirizzo_2',
                'label' => 'Indirizzo - Riga 2',
                'name' => 'footer_indirizzo_2',
                'type' => 'text',
                'instructions' => 'Es. "40122 Bologna (BO)"',
                'wrapper' => array( 'width' => '50' ),
            ),
            // Email
            array(
                'key' => 'field_footer_email',
                'label' => 'Email',
                'name' => 'footer_email',
                'type' => 'email',
                'wrapper' => array( 'width' => '50' ),
            ),
            // Bottoni
            array(
                'key' => 'field_footer_btn_seguici',
                'label' => 'Link Seguici',
                'name' => 'footer_btn_seguici',
                'type' => 'url',
                'wrapper' => array( 'width' => '25' ),
            ),
            array(
                'key' => 'field_footer_btn_trovaci',
                'label' => 'Link Trovaci',
                'name' => 'footer_btn_trovaci',
                'type' => 'url',
                'wrapper' => array( 'width' => '25' ),
            ),
            // Copyright
            array(
                'key' => 'field_footer_copyright',
                'label' => 'Testo Copyright',
                'name' => 'footer_copyright',
                'type' => 'text',
                'default_value' => 'Il Panino Bologna. Tutti i Diritti Riservati.',
                'wrapper' => array( 'width' => '50' ),
            ),
            // Credits
            array(
                'key' => 'field_footer_credits_nome',
                'label' => 'Credits - Nome',
                'name' => 'footer_credits_nome',
                'type' => 'text',
                'default_value' => 'Mattia Filosa',
                'wrapper' => array( 'width' => '25' ),
            ),
            array(
                'key' => 'field_footer_credits_url',
                'label' => 'Credits - URL',
                'name' => 'footer_credits_url',
                'type' => 'url',
                'wrapper' => array( 'width' => '25' ),
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'options_page',
                    'operator' => '==',
                    'value' => 'acf-options',
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
        'menu_order' => 50,
        'position' => 'normal',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
        'active' => true,
        'show_in_rest' => 1,
    ));
}
