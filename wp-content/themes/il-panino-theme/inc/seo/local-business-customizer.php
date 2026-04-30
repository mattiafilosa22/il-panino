<?php
/**
 * Customizer panel: "Dati locale".
 *
 * Provides the editable fields that feed Schema.org JSON-LD and SEO meta
 * tags. We intentionally use the Customizer (theme_mod) instead of an ACF
 * options page because the project does not include ACF Pro (the same reason
 * documented for the footer in functions.php).
 *
 * All admin labels are in Italian (project convention); identifiers and
 * comments stay in English.
 *
 * @package il-panino-theme
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Sanitize the price-range select.
 *
 * @param string $value Raw value.
 * @return string Sanitized value belonging to the allowed set.
 */
function il_panino_seo_sanitize_price_range( $value ) {
    $allowed = array( '€', '€€', '€€€', '€€€€' );
    return in_array( $value, $allowed, true ) ? $value : '€€';
}

/**
 * Sanitize a checkbox-style theme_mod ('1' or '').
 *
 * @param mixed $value Raw value.
 * @return string '1' or ''.
 */
function il_panino_seo_sanitize_checkbox( $value ) {
    return ( '1' === (string) $value || true === $value ) ? '1' : '';
}

/**
 * Sanitize a country code (2 letters, upper-case).
 *
 * @param string $value Raw value.
 * @return string Two-letter uppercase country code or empty string.
 */
function il_panino_seo_sanitize_country_code( $value ) {
    $value = strtoupper( preg_replace( '/[^A-Za-z]/', '', (string) $value ) );
    return ( 2 === strlen( $value ) ) ? $value : '';
}

/**
 * Register the "Dati locale" Customizer section and its controls.
 *
 * @param WP_Customize_Manager $wp_customize Customizer manager instance.
 * @return void
 */
function il_panino_seo_customize_register( $wp_customize ) {
    $section_id = 'il_panino_data_locale';

    $wp_customize->add_section( $section_id, array(
        'title'       => __( 'Dati locale (SEO / Schema)', 'il-panino-theme' ),
        'priority'    => 40,
        'description' => __( 'Dati anagrafici, geo, orari, business e social del ristorante. Usati da Schema.org JSON-LD e meta tag SEO/OpenGraph.', 'il-panino-theme' ),
    ) );

    $fields = array(
        // Contatti.
        'name' => array(
            'default'     => 'Il Panino Bologna',
            'label'       => __( 'Nome attività', 'il-panino-theme' ),
            'type'        => 'text',
            'sanitize'    => 'sanitize_text_field',
        ),
        'description' => array(
            'default'     => '',
            'label'       => __( 'Descrizione attività', 'il-panino-theme' ),
            'type'        => 'textarea',
            'sanitize'    => 'sanitize_textarea_field',
            'description' => __( 'Frase breve sul locale; usata come fallback per meta description.', 'il-panino-theme' ),
        ),
        'phone' => array(
            'default'     => '',
            'label'       => __( 'Telefono', 'il-panino-theme' ),
            'type'        => 'text',
            'input_attrs' => array( 'type' => 'tel' ),
            'sanitize'    => 'sanitize_text_field',
            'description' => __( 'Formato internazionale, es. +39 340 967 7143.', 'il-panino-theme' ),
        ),
        'email' => array(
            'default'     => '',
            'label'       => __( 'Email', 'il-panino-theme' ),
            'type'        => 'email',
            'sanitize'    => 'sanitize_email',
        ),
        'street' => array(
            'default'     => '',
            'label'       => __( 'Indirizzo (via e civico)', 'il-panino-theme' ),
            'type'        => 'text',
            'sanitize'    => 'sanitize_text_field',
            'description' => __( 'Es. "Via Galliera, 91/A".', 'il-panino-theme' ),
        ),
        'city' => array(
            'default'     => 'Bologna',
            'label'       => __( 'Città', 'il-panino-theme' ),
            'type'        => 'text',
            'sanitize'    => 'sanitize_text_field',
        ),
        'postal_code' => array(
            'default'     => '',
            'label'       => __( 'CAP', 'il-panino-theme' ),
            'type'        => 'text',
            'sanitize'    => 'sanitize_text_field',
        ),
        'region' => array(
            'default'     => 'BO',
            'label'       => __( 'Provincia / Regione', 'il-panino-theme' ),
            'type'        => 'text',
            'sanitize'    => 'sanitize_text_field',
            'description' => __( 'Codice provincia (es. BO).', 'il-panino-theme' ),
        ),
        'country' => array(
            'default'     => 'IT',
            'label'       => __( 'Paese (codice ISO 2)', 'il-panino-theme' ),
            'type'        => 'text',
            'sanitize'    => 'il_panino_seo_sanitize_country_code',
            'description' => __( 'Codice paese a 2 lettere, es. IT.', 'il-panino-theme' ),
        ),

        // Geo.
        'lat' => array(
            'default'     => '',
            'label'       => __( 'Latitudine', 'il-panino-theme' ),
            'type'        => 'text',
            'input_attrs' => array(
                'type'        => 'number',
                'step'        => '0.000001',
                'placeholder' => '44.498955',
            ),
            'sanitize'    => 'sanitize_text_field',
        ),
        'lng' => array(
            'default'     => '',
            'label'       => __( 'Longitudine', 'il-panino-theme' ),
            'type'        => 'text',
            'input_attrs' => array(
                'type'        => 'number',
                'step'        => '0.000001',
                'placeholder' => '11.347156',
            ),
            'sanitize'    => 'sanitize_text_field',
        ),
        'google_maps_url' => array(
            'default'     => '',
            'label'       => __( 'URL Google Maps', 'il-panino-theme' ),
            'type'        => 'url',
            'sanitize'    => 'esc_url_raw',
        ),

        // Orari.
        'opening_hours' => array(
            'default'     => '',
            'label'       => __( 'Orari di apertura', 'il-panino-theme' ),
            'type'        => 'textarea',
            'sanitize'    => 'sanitize_textarea_field',
            'description' => __( 'Una regola per riga. Formato: "Mon,Tue,Wed,Thu,Fri | 11:30 | 15:30". Per giorni di chiusura: "Sun | closed". Giorni: Mon, Tue, Wed, Thu, Fri, Sat, Sun (oppure nomi completi). Le righe non valide sono ignorate.', 'il-panino-theme' ),
        ),

        // Business.
        'price_range' => array(
            'default'     => '€€',
            'label'       => __( 'Fascia di prezzo', 'il-panino-theme' ),
            'type'        => 'select',
            'choices'     => array(
                '€'    => '€',
                '€€'   => '€€',
                '€€€'  => '€€€',
                '€€€€' => '€€€€',
            ),
            'sanitize'    => 'il_panino_seo_sanitize_price_range',
        ),
        'serves_cuisine' => array(
            'default'     => 'Italian, Sandwiches',
            'label'       => __( 'Tipologie di cucina', 'il-panino-theme' ),
            'type'        => 'text',
            'sanitize'    => 'sanitize_text_field',
            'description' => __( 'Elenco separato da virgole, in inglese (es. "Italian, Sandwiches"). Usato in Schema.org servesCuisine.', 'il-panino-theme' ),
        ),
        'accepts_reservations' => array(
            'default'     => '',
            'label'       => __( 'Accetta prenotazioni', 'il-panino-theme' ),
            'type'        => 'checkbox',
            'sanitize'    => 'il_panino_seo_sanitize_checkbox',
        ),

        // Social.
        'facebook_url' => array(
            'default'     => '',
            'label'       => __( 'Facebook URL', 'il-panino-theme' ),
            'type'        => 'url',
            'sanitize'    => 'esc_url_raw',
        ),
        'instagram_url' => array(
            'default'     => '',
            'label'       => __( 'Instagram URL', 'il-panino-theme' ),
            'type'        => 'url',
            'sanitize'    => 'esc_url_raw',
        ),
        'tripadvisor_url' => array(
            'default'     => '',
            'label'       => __( 'TripAdvisor URL', 'il-panino-theme' ),
            'type'        => 'url',
            'sanitize'    => 'esc_url_raw',
        ),
        'thefork_url' => array(
            'default'     => '',
            'label'       => __( 'TheFork URL', 'il-panino-theme' ),
            'type'        => 'url',
            'sanitize'    => 'esc_url_raw',
        ),
    );

    foreach ( $fields as $key => $field ) {
        $setting_id = 'il_panino_business_' . $key;

        $wp_customize->add_setting( $setting_id, array(
            'default'           => $field['default'],
            'type'              => 'theme_mod',
            'capability'        => 'edit_theme_options',
            'sanitize_callback' => $field['sanitize'],
            'transport'         => 'refresh',
        ) );

        $control_args = array(
            'label'   => $field['label'],
            'section' => $section_id,
            'type'    => $field['type'],
        );
        if ( ! empty( $field['choices'] ) ) {
            $control_args['choices'] = $field['choices'];
        }
        if ( ! empty( $field['description'] ) ) {
            $control_args['description'] = $field['description'];
        }
        if ( ! empty( $field['input_attrs'] ) ) {
            $control_args['input_attrs'] = $field['input_attrs'];
        }

        $wp_customize->add_control( $setting_id, $control_args );
    }

    // Default OG image (image attachment picker).
    $wp_customize->add_setting( 'il_panino_business_default_og_image_id', array(
        'default'           => 0,
        'type'              => 'theme_mod',
        'capability'        => 'edit_theme_options',
        'sanitize_callback' => 'absint',
        'transport'         => 'refresh',
    ) );
    $wp_customize->add_control(
        new WP_Customize_Media_Control(
            $wp_customize,
            'il_panino_business_default_og_image_id',
            array(
                'label'       => __( 'Immagine OG di default', 'il-panino-theme' ),
                'description' => __( 'Usata quando una pagina non ha un\'immagine in evidenza. Consigliata 1200x630.', 'il-panino-theme' ),
                'section'     => $section_id,
                'mime_type'   => 'image',
            )
        )
    );
}
add_action( 'customize_register', 'il_panino_seo_customize_register' );
