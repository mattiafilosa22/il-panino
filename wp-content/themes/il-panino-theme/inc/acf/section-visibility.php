<?php
/**
 * Register ACF fields for Section Visibility (reusable across selected components)
 *
 * Adds a single `true_false` toggle to every section component listed below.
 * When the toggle is active, the matching section is hidden on the frontend
 * (see il_panino_is_section_hidden() in functions.php).
 *
 * Field naming convention: `<section_key>_hidden`
 * Field group key convention: `group_visibility_<section_key>`
 */
if ( ! function_exists('acf_add_local_field_group') ) return;

// List of page templates where visibility fields should appear
$locations = array(
    array(
        array(
            'param' => 'page_template',
            'operator' => '==',
            'value' => 'template-homepage.php',
        ),
    ),
    array(
        array(
            'param' => 'page_template',
            'operator' => '==',
            'value' => 'template-menu.php',
        ),
    ),
);

// One field group per component section (must match keys in section-spacing.php).
// Limited to the 6 components actually wired into the two templates.
$sections = array(
    'hero_banner'    => 'Hero Banner',
    'product_slider' => 'Slider Prodotti',
    'cross_slider'   => 'Cross Slider',
    'heading'        => 'Heading',
    'instagram_feed' => 'Instagram Feed',
    'menu_core'      => 'Menu Core',
);

foreach ( $sections as $key => $label ) {
    acf_add_local_field_group(array(
        'key'    => 'group_visibility_' . $key,
        'title'  => 'Visibilità - ' . $label,
        'fields' => array(
            array(
                'key'           => 'field_' . $key . '_hidden',
                'label'         => 'Nascondi sezione',
                'name'          => $key . '_hidden',
                'type'          => 'true_false',
                'instructions'  => 'Se attivo, questa sezione non sarà visibile a frontend.',
                'ui'            => 1,
                'default_value' => 0,
            ),
        ),
        'location'    => $locations,
        'menu_order'  => 90,
        'position'    => 'side',
        'style'       => 'default',
        'active'      => true,
    ));
}
