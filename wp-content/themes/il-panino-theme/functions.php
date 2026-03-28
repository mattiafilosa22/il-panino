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

    // Bootstrap 5 CSS
    wp_enqueue_style( 'bootstrap-css', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css', array(), '5.3.3' );

    // Cache busting automatico usando l'ultima modifica del file style.css
    $theme_version = file_exists( get_stylesheet_directory() . '/style.css' ) ? filemtime( get_stylesheet_directory() . '/style.css' ) : '1.0.0';
    wp_enqueue_style( 'il-panino-style', get_stylesheet_uri(), array(), $theme_version );
    
    // Splide.js CSS & JS
    wp_enqueue_style( 'splide-css', get_template_directory_uri() . '/assets/vendor/splide/splide.min.css', array(), '4.1.4' );
    wp_enqueue_script( 'splide-js', get_template_directory_uri() . '/assets/vendor/splide/splide.min.js', array(), '4.1.4', true );

    // Caricamento JS Custom (Modulare)
    $main_js_version = file_exists( get_template_directory() . '/js/main.js' ) ? filemtime( get_template_directory() . '/js/main.js' ) : '1.0.0';
    wp_enqueue_script( 'il-panino-main', get_template_directory_uri() . '/js/main.js', array('splide-js'), $main_js_version, true );
}
add_action( 'wp_enqueue_scripts', 'il_panino_theme_scripts' );

// Aggiunge type="module" allo script custom per permettere l'utilizzo di ES6 Modules
function il_panino_add_type_attribute( $tag, $handle, $src ) {
    if ( 'il-panino-main' !== $handle ) {
        return $tag;
    }
    return '<script type="module" src="' . esc_url( $src ) . '"></script>';
}
add_filter( 'script_loader_tag', 'il_panino_add_type_attribute', 10, 3 );

/**
 * Load Custom Post Types
 */
$custom_post_types = array(
    'panino',
);

foreach ( $custom_post_types as $cpt ) {
    $file = get_template_directory() . '/inc/cpt/' . $cpt . '.php';
    if ( file_exists( $file ) ) {
        require_once $file;
    }
}

/**
 * Load Taxonomies
 */
$taxonomies = array(
    'categoria_panino',
);

foreach ( $taxonomies as $tax ) {
    $file = get_template_directory() . '/inc/taxonomy/' . $tax . '.php';
    if ( file_exists( $file ) ) {
        require_once $file;
    }
}

/**
 * Load ACF Components
 */
$acf_components = array(
    'hero-banner',
    'panino',
    'categoria_panino',
    'slider-prodotti',
    'cross-slider',
    'footer',
    'panino-menu',
    'heading-menu',
    'social-reels',
    'section-spacing',
);

foreach ( $acf_components as $component ) {
    $file = get_template_directory() . '/inc/acf/' . $component . '.php';
    if ( file_exists( $file ) ) {
        require_once $file;
    }
}

/**
 * Helper: Get Bootstrap spacing classes for a section component.
 *
 * @param string $section_key The ACF field prefix (e.g. 'hero_banner', 'product_slider').
 * @return string CSS classes string (e.g. 'mt-3 mb-5').
 */
function il_panino_get_spacing_classes( $section_key ) {
    $prefixes = array(
        'margin_top'     => 'mt-',
        'margin_bottom'  => 'mb-',
        'padding_top'    => 'pt-',
        'padding_bottom' => 'pb-',
    );
    $classes = array();
    foreach ( $prefixes as $suffix => $css_prefix ) {
        $val = get_field( $section_key . '_' . $suffix );
        if ( $val !== '' && $val !== null && $val !== false ) {
            $classes[] = $css_prefix . intval($val);
        }
    }
    return implode(' ', $classes);
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
