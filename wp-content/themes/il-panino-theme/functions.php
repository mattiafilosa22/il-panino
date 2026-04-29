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
    'panino-menu',
    'heading-menu',
    'instagram-feed',
    'menu-banner',
    'section-visibility',
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
 * Helper: Check if a section component should be hidden.
 *
 * Reads the ACF true_false field `<section_key>_hidden` set on the current page.
 *
 * @param string $section_key Section key (e.g. 'hero_banner', 'menu_core').
 * @return bool True if the section should be hidden, false otherwise.
 */
function il_panino_is_section_hidden( $section_key ) {
    if ( ! function_exists('get_field') ) {
        return false;
    }
    return (bool) get_field( $section_key . '_hidden' );
}

/**
 * Build a pre-filled WhatsApp order URL for a menu item (panino, frittino, dolce).
 *
 * The URL is derived from the item's category: items in 'frittini' or 'dolci'
 * use a "side" message template, everything else uses the full panino template
 * (with size "medium"). The phone number is currently hardcoded; if a per-item
 * override is ever required, it can be layered on top via an ACF field without
 * changing this signature.
 *
 * @param int    $post_id        Post ID (reserved for future per-item overrides).
 * @param string $item_title     Post title (raw, already decoded; will be URL-encoded here).
 * @param array  $category_slugs List of category term slugs for this post.
 * @return string Fully-qualified https://wa.me/ URL. Still pass through esc_url() at render time.
 */
function il_panino_get_whatsapp_order_url( $post_id, $item_title, $category_slugs = array() ) {
    unset( $post_id ); // Reserved for future per-item overrides.
    $phone   = '393409677143';
    $is_side = ! empty( array_intersect( array( 'frittini', 'dolci' ), (array) $category_slugs ) );
    if ( $is_side ) {
        $message = sprintf( 'Ciao vorrei ordinare %s, potete consegnarmelo qua:', $item_title );
    } else {
        $message = sprintf( 'Ciao, vorrei ordinare 1 %s medium, potete consegnarmelo qua:', $item_title );
    }
    return 'https://wa.me/' . $phone . '?text=' . rawurlencode( $message );
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

/**
 * Customizer: Contatti Footer
 *
 * Exposes the shared footer fields (sitemap/contact titles, address, phone,
 * opening hours, email, buttons, copyright, credits) as theme_mods, so the
 * footer can be edited from a single location in the admin regardless of the
 * template being viewed. Replaces the previous ACF options-page approach,
 * which required ACF Pro (unavailable in this project).
 *
 * @param WP_Customize_Manager $wp_customize Customizer manager instance.
 */
function il_panino_customize_register_footer( $wp_customize ) {
    $wp_customize->add_section( 'il_panino_footer_contacts', array(
        'title'    => 'Contatti Footer',
        'priority' => 35,
    ) );

    $fields = array(
        'footer_sitemap_titolo' => array(
            'default'  => 'Sitemap',
            'label'    => 'Titolo colonna Sitemap',
            'type'     => 'text',
            'sanitize' => 'sanitize_text_field',
        ),
        'footer_contatti_titolo' => array(
            'default'  => 'Contatti',
            'label'    => 'Titolo colonna Contatti',
            'type'     => 'text',
            'sanitize' => 'sanitize_text_field',
        ),
        'footer_indirizzo_1' => array(
            'default'  => '',
            'label'    => 'Indirizzo - Riga 1',
            'type'     => 'text',
            'sanitize' => 'sanitize_text_field',
            'description' => 'Es. "Via Galliera, 91/A"',
        ),
        'footer_indirizzo_2' => array(
            'default'  => '',
            'label'    => 'Indirizzo - Riga 2',
            'type'     => 'text',
            'sanitize' => 'sanitize_text_field',
            'description' => 'Es. "40121 Bologna BO"',
        ),
        'footer_indirizzo_maps_url' => array(
            'default'  => '',
            'label'    => 'Indirizzo - URL Google Maps',
            'type'     => 'url',
            'sanitize' => 'esc_url_raw',
            'description' => 'Link cliccabile sull\'indirizzo, apre Google Maps in una nuova tab.',
        ),
        'footer_telefono_numero' => array(
            'default'  => '',
            'label'    => 'Telefono - Numero (testo)',
            'type'     => 'text',
            'sanitize' => 'sanitize_text_field',
            'description' => 'Testo visibile del numero, es. 393409677143.',
        ),
        'footer_telefono_url' => array(
            'default'  => '',
            'label'    => 'Telefono - Link (URL)',
            'type'     => 'url',
            'sanitize' => 'esc_url_raw',
            'description' => 'URL di destinazione, es. https://wa.me/393409677143.',
        ),
        'footer_orari_titolo' => array(
            'default'  => 'Aperto tutti i giorni:',
            'label'    => 'Orari - Titolo',
            'type'     => 'text',
            'sanitize' => 'sanitize_text_field',
        ),
        'footer_orari_fascia_1' => array(
            'default'  => '',
            'label'    => 'Orari - Fascia 1',
            'type'     => 'text',
            'sanitize' => 'sanitize_text_field',
            'description' => 'Es. 11:30 - 15:30',
        ),
        'footer_orari_fascia_2' => array(
            'default'  => '',
            'label'    => 'Orari - Fascia 2',
            'type'     => 'text',
            'sanitize' => 'sanitize_text_field',
            'description' => 'Es. 18:30 - 21:00',
        ),
        'footer_email' => array(
            'default'  => '',
            'label'    => 'Email',
            'type'     => 'email',
            'sanitize' => 'sanitize_email',
        ),
        'footer_btn_seguici' => array(
            'default'  => '',
            'label'    => 'Bottone Seguici - URL',
            'type'     => 'url',
            'sanitize' => 'esc_url_raw',
        ),
        'footer_btn_trovaci' => array(
            'default'  => '',
            'label'    => 'Bottone Trovaci - URL',
            'type'     => 'url',
            'sanitize' => 'esc_url_raw',
        ),
        'footer_copyright' => array(
            'default'  => 'Il Panino Bologna. Tutti i Diritti Riservati.',
            'label'    => 'Testo Copyright',
            'type'     => 'text',
            'sanitize' => 'sanitize_text_field',
        ),
        'footer_credits_nome' => array(
            'default'  => 'Mattia Filosa',
            'label'    => 'Credits - Nome',
            'type'     => 'text',
            'sanitize' => 'sanitize_text_field',
        ),
        'footer_credits_url' => array(
            'default'  => '',
            'label'    => 'Credits - URL',
            'type'     => 'url',
            'sanitize' => 'esc_url_raw',
        ),
    );

    foreach ( $fields as $field_id => $field ) {
        $wp_customize->add_setting( $field_id, array(
            'default'           => $field['default'],
            'type'              => 'theme_mod',
            'capability'        => 'edit_theme_options',
            'sanitize_callback' => $field['sanitize'],
        ) );

        $control_args = array(
            'label'   => $field['label'],
            'section' => 'il_panino_footer_contacts',
            'type'    => $field['type'],
        );
        if ( ! empty( $field['description'] ) ) {
            $control_args['description'] = $field['description'];
        }

        $wp_customize->add_control( $field_id, $control_args );
    }
}
add_action( 'customize_register', 'il_panino_customize_register_footer' );
