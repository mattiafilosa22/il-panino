<?php
/**
 * Register ACF fields for Instagram Feed section
 */
if ( ! function_exists('acf_add_local_field_group') ) return;

acf_add_local_field_group(array(
    'key'    => 'group_instagram_feed',
    'title'  => 'Instagram Feed',
    'fields' => array(
        array(
            'key'          => 'field_instagram_feed_titolo',
            'label'        => 'Titolo',
            'name'         => 'instagram_feed_titolo',
            'type'         => 'text',
            'instructions' => 'Titolo opzionale della sezione.',
        ),
        array(
            'key'          => 'field_instagram_feed_sottotitolo',
            'label'        => 'Sottotitolo',
            'name'         => 'instagram_feed_sottotitolo',
            'type'         => 'textarea',
            'instructions' => 'Testo descrittivo opzionale sotto il titolo.',
            'rows'         => 2,
            'new_lines'    => 'br',
        ),
        array(
            'key'          => 'field_instagram_feed_shortcode',
            'label'        => 'Shortcode',
            'name'         => 'instagram_feed_shortcode',
            'type'         => 'text',
            'instructions' => 'Inserisci lo shortcode del feed (es. [instagram feed="113"]).',
            'placeholder'  => '[instagram feed="113"]',
        ),
    ),
    'location' => array(
        array(
            array(
                'param'    => 'page_template',
                'operator' => '==',
                'value'    => 'template-homepage.php',
            ),
        ),
    ),
    'menu_order' => 20,
    'position'   => 'normal',
    'style'      => 'default',
    'active'     => true,
));
