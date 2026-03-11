<?php
/**
 * Theme functions and definitions.
 *
 * @package il-panino-theme
 */

if ( ! function_exists( 'il_panino_theme_setup' ) ) :
    function il_panino_theme_setup() {
        // Aggiunge supporto ai tag title
        add_theme_support( 'title-tag' );

        // Aggiunge supporto alle immagini in evidenza
        add_theme_support( 'post-thumbnails' );

        // Registra eventuali menu
        register_nav_menus( array(
            'menu-1' => esc_html__( 'Primary', 'il-panino-theme' ),
        ) );
    }
endif;
add_action( 'after_setup_theme', 'il_panino_theme_setup' );

/**
 * Enqueue scripts and styles.
 */
function il_panino_theme_scripts() {
    // Caricamento Fonts: Bebas Neue, Quicksand, Nunito
    wp_enqueue_style( 'google-fonts', 'https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Nunito:wght@400;600;700&family=Quicksand:wght@400;600;700&display=swap', array(), null );

    // Cache busting automatico usando l'ultima modifica del file style.css
    $theme_version = file_exists( get_stylesheet_directory() . '/style.css' ) ? filemtime( get_stylesheet_directory() . '/style.css' ) : '1.0.0';
    wp_enqueue_style( 'il-panino-style', get_stylesheet_uri(), array(), $theme_version );
    
    // Caricamento JS Custom
    wp_enqueue_script( 'il-panino-navigation', get_template_directory_uri() . '/js/main.js', array(), '1.0.0', true );
}
add_action( 'wp_enqueue_scripts', 'il_panino_theme_scripts' );

/**
 * Registrazione campi ACF per Homepage
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

/**
 * Customizer: Bottoni Header (Seguici e Recensiscici)
 */
function il_panino_customize_register( $wp_customize ) {
    $wp_customize->add_section( 'il_panino_header_buttons', array(
        'title'    => 'Bottoni Header',
        'priority' => 30,
    ) );

    // Seguici - Testo
    $wp_customize->add_setting( 'seguici_text', array(
        'default'           => 'SEGUICI',
        'sanitize_callback' => 'sanitize_text_field',
    ) );
    $wp_customize->add_control( 'seguici_text', array(
        'label'   => 'Seguici - Testo',
        'section' => 'il_panino_header_buttons',
        'type'    => 'text',
    ) );

    // Seguici - Link
    $wp_customize->add_setting( 'seguici_link', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
    ) );
    $wp_customize->add_control( 'seguici_link', array(
        'label'   => 'Seguici - Link',
        'section' => 'il_panino_header_buttons',
        'type'    => 'url',
        'description' => 'URL della pagina social (es. Instagram)',
    ) );

    // Recensiscici - Testo
    $wp_customize->add_setting( 'recensiscici_text', array(
        'default'           => 'RECENSISCICI',
        'sanitize_callback' => 'sanitize_text_field',
    ) );
    $wp_customize->add_control( 'recensiscici_text', array(
        'label'   => 'Recensiscici - Testo',
        'section' => 'il_panino_header_buttons',
        'type'    => 'text',
    ) );

    // Recensiscici - Link
    $wp_customize->add_setting( 'recensiscici_link', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
    ) );
    $wp_customize->add_control( 'recensiscici_link', array(
        'label'   => 'Recensiscici - Link',
        'section' => 'il_panino_header_buttons',
        'type'    => 'url',
        'description' => 'URL della pagina recensioni (es. Google, TripAdvisor)',
    ) );
}
add_action( 'customize_register', 'il_panino_customize_register' );
