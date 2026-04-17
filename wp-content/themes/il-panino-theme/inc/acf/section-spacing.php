<?php
/**
 * Register ACF fields for Section Spacing (reusable across all components)
 *
 * Adds margin and padding (top/bottom) select fields to every section component.
 * Values map to Bootstrap spacing classes (mt-0 to mt-5, pt-0 to pt-5, etc.).
 */
if ( ! function_exists('acf_add_local_field_group') ) return;

$spacing_choices = array(
    ''   => 'Default',
    '0'  => '0 - Nessuno',
    '1'  => '1 - Piccolo (0.25rem)',
    '2'  => '2 - Medio (0.5rem)',
    '3'  => '3 - Normal (1rem)',
    '4'  => '4 - Grande (1.5rem)',
    '5'  => '5 - Extra (3rem)',
);

// List of page templates where spacing fields should appear
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

// One field group per component section
$sections = array(
    'hero_banner'    => 'Hero Banner',
    'product_slider' => 'Slider Prodotti',
    'cross_slider'   => 'Cross Slider',
    'heading'        => 'Heading',
    'social_reels'   => 'Social Reels',
    'menu_core'      => 'Menu Core',
);

foreach ( $sections as $key => $label ) {
    acf_add_local_field_group(array(
        'key'    => 'group_spacing_' . $key,
        'title'  => 'Spaziatura - ' . $label,
        'fields' => array(
            array(
                'key'           => 'field_' . $key . '_margin_top',
                'label'         => 'Margin Top',
                'name'          => $key . '_margin_top',
                'type'          => 'select',
                'choices'       => $spacing_choices,
                'default_value' => '',
                'allow_null'    => 0,
                'wrapper'       => array('width' => '50'),
            ),
            array(
                'key'           => 'field_' . $key . '_margin_bottom',
                'label'         => 'Margin Bottom',
                'name'          => $key . '_margin_bottom',
                'type'          => 'select',
                'choices'       => $spacing_choices,
                'default_value' => '',
                'allow_null'    => 0,
                'wrapper'       => array('width' => '50'),
            ),
            array(
                'key'           => 'field_' . $key . '_padding_top',
                'label'         => 'Padding Top',
                'name'          => $key . '_padding_top',
                'type'          => 'select',
                'choices'       => $spacing_choices,
                'default_value' => '',
                'allow_null'    => 0,
                'wrapper'       => array('width' => '50'),
            ),
            array(
                'key'           => 'field_' . $key . '_padding_bottom',
                'label'         => 'Padding Bottom',
                'name'          => $key . '_padding_bottom',
                'type'          => 'select',
                'choices'       => $spacing_choices,
                'default_value' => '',
                'allow_null'    => 0,
                'wrapper'       => array('width' => '50'),
            ),
        ),
        'location'    => $locations,
        'menu_order'  => 100,
        'position'    => 'side',
        'style'       => 'default',
        'active'      => true,
    ));
}
