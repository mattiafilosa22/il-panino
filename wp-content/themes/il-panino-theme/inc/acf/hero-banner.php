<?php
/**
 * ACF: Hero Banner
 */

if( function_exists('acf_add_local_field_group') ) {
    acf_add_local_field_group(array(
        'key' => 'group_homepage',
        'title' => 'Homepage - Hero Section',
        'fields' => array(
            array(
                'key' => 'field_hero_title',
                'label' => 'Hero Title',
                'name' => 'hero_title',
                'type' => 'text',
                'instructions' => 'Titolo principale della hero section',
            ),
            array(
                'key' => 'field_hero_subtitle',
                'label' => 'Hero Subtitle',
                'name' => 'hero_subtitle',
                'type' => 'textarea',
                'instructions' => 'Sottotitolo della hero section',
                'rows' => 3,
            ),
            array(
                'key' => 'field_hero_background-image',
                'label' => 'Hero background image',
                'name' => 'hero_bg_image',
                'type' => 'image',
                'instructions' => 'Immagine di background per la hero section',
                'return_format' => 'url',
                'preview_size' => 'medium',
                'library' => 'all',
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
        'position' => 'normal',
        'style' => 'default',
    ));
}
