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
            // Maps URL wraps the address block so the whole address becomes a clickable deep link to Google Maps.
            array(
                'key' => 'field_footer_indirizzo_maps_url',
                'label' => 'URL Google Maps',
                'name' => 'footer_indirizzo_maps_url',
                'type' => 'url',
                'instructions' => 'Link cliccabile sull\'indirizzo, apre Google Maps in una nuova tab.',
                'wrapper' => array( 'width' => '50' ),
            ),
            // Phone is split into display text + href so the number can point anywhere (wa.me, tel:, etc.) without touching the markup.
            array(
                'key' => 'field_footer_telefono_numero',
                'label' => 'Telefono - Numero (testo)',
                'name' => 'footer_telefono_numero',
                'type' => 'text',
                'instructions' => 'Testo mostrato del numero, es. 393409677143.',
                'wrapper' => array( 'width' => '50' ),
            ),
            array(
                'key' => 'field_footer_telefono_url',
                'label' => 'Telefono - Link (URL)',
                'name' => 'footer_telefono_url',
                'type' => 'url',
                'instructions' => 'URL di destinazione, es. https://wa.me/393409677143.',
                'wrapper' => array( 'width' => '50' ),
            ),
            // Opening hours
            array(
                'key' => 'field_footer_orari_titolo',
                'label' => 'Orari - Titolo',
                'name' => 'footer_orari_titolo',
                'type' => 'text',
                'default_value' => 'Aperto tutti i giorni:',
                'wrapper' => array( 'width' => '50' ),
            ),
            array(
                'key' => 'field_footer_orari_fascia_1',
                'label' => 'Orari - Fascia 1',
                'name' => 'footer_orari_fascia_1',
                'type' => 'text',
                'instructions' => 'Es. 11:30 - 15:30',
                'wrapper' => array( 'width' => '25' ),
            ),
            array(
                'key' => 'field_footer_orari_fascia_2',
                'label' => 'Orari - Fascia 2',
                'name' => 'footer_orari_fascia_2',
                'type' => 'text',
                'instructions' => 'Es. 18:30 - 21:00',
                'wrapper' => array( 'width' => '25' ),
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
