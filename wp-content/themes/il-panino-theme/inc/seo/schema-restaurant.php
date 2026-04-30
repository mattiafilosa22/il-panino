<?php
/**
 * Schema.org JSON-LD: Restaurant + LocalBusiness.
 *
 * Outputs a single <script type="application/ld+json"> block in the document
 * <head> describing the restaurant. Empty fields are skipped so that we never
 * emit `null`/empty entries in the JSON.
 *
 * Hooked late on `wp_head` (priority 20) so it sits after the meta tags block
 * (priority 1).
 *
 * @package il-panino-theme
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Build the Schema.org Restaurant array from the configured business data.
 *
 * Returns null when the data set is so empty that no useful schema can be
 * produced (i.e. only the hard-coded "name" default would be emitted).
 *
 * @return array<string,mixed>|null
 */
function il_panino_seo_build_restaurant_schema() {
    $data = il_panino_seo_get_business_data();

    $schema = array(
        '@context'       => 'https://schema.org',
        '@type'          => 'Restaurant',
        'additionalType' => 'https://schema.org/LocalBusiness',
        'name'           => (string) $data['name'],
        'url'            => home_url( '/' ),
    );

    if ( ! empty( $data['description'] ) ) {
        $schema['description'] = (string) $data['description'];
    }

    // Image: prefer the configured default OG image; fall back to site icon.
    $image_url = il_panino_seo_get_default_og_image_url();
    if ( '' === $image_url ) {
        $site_icon_id = (int) get_option( 'site_icon' );
        if ( $site_icon_id > 0 ) {
            $candidate = wp_get_attachment_image_url( $site_icon_id, 'full' );
            $image_url = $candidate ? $candidate : '';
        }
    }
    if ( '' !== $image_url ) {
        $schema['image'] = $image_url;
    }

    // Address.
    $address = array_filter( array(
        'streetAddress'   => (string) $data['street'],
        'addressLocality' => (string) $data['city'],
        'addressRegion'   => (string) $data['region'],
        'postalCode'      => (string) $data['postal_code'],
        'addressCountry'  => (string) $data['country'],
    ), static function ( $value ) {
        return '' !== (string) $value;
    } );
    if ( ! empty( $address ) ) {
        $schema['address'] = array_merge( array( '@type' => 'PostalAddress' ), $address );
    }

    if ( ! empty( $data['phone'] ) ) {
        $schema['telephone'] = (string) $data['phone'];
    }
    if ( ! empty( $data['email'] ) ) {
        $schema['email'] = (string) $data['email'];
    }

    // Geo.
    $lat = is_numeric( $data['lat'] ) ? (float) $data['lat'] : null;
    $lng = is_numeric( $data['lng'] ) ? (float) $data['lng'] : null;
    if ( null !== $lat && null !== $lng ) {
        $schema['geo'] = array(
            '@type'     => 'GeoCoordinates',
            'latitude'  => $lat,
            'longitude' => $lng,
        );
    }

    // Opening hours.
    $hours_spec = array();
    foreach ( (array) $data['opening_hours'] as $rule ) {
        if ( ! empty( $rule['closed'] ) ) {
            // OpeningHoursSpecification with no opens/closes implies closed.
            $hours_spec[] = array(
                '@type'     => 'OpeningHoursSpecification',
                'dayOfWeek' => array_map(
                    static function ( $d ) { return 'https://schema.org/' . $d; },
                    (array) $rule['days']
                ),
            );
            continue;
        }
        $hours_spec[] = array(
            '@type'     => 'OpeningHoursSpecification',
            'dayOfWeek' => array_map(
                static function ( $d ) { return 'https://schema.org/' . $d; },
                (array) $rule['days']
            ),
            'opens'     => (string) $rule['opens'],
            'closes'    => (string) $rule['closes'],
        );
    }
    if ( ! empty( $hours_spec ) ) {
        $schema['openingHoursSpecification'] = $hours_spec;
    }

    if ( ! empty( $data['price_range'] ) ) {
        $schema['priceRange'] = (string) $data['price_range'];
    }

    if ( ! empty( $data['serves_cuisine'] ) && is_array( $data['serves_cuisine'] ) ) {
        $schema['servesCuisine'] = array_values( $data['serves_cuisine'] );
    }

    // sameAs: only valid URLs.
    $same_as = array();
    foreach ( array( 'facebook_url', 'instagram_url', 'tripadvisor_url', 'thefork_url' ) as $key ) {
        $url = isset( $data[ $key ] ) ? (string) $data[ $key ] : '';
        if ( '' !== $url ) {
            $same_as[] = esc_url_raw( $url );
        }
    }
    $same_as = array_values( array_filter( $same_as ) );
    if ( ! empty( $same_as ) ) {
        $schema['sameAs'] = $same_as;
    }

    // acceptsReservations is always meaningful (true|false), but we emit it
    // only when the editor has explicitly opted in to keep the JSON minimal.
    if ( ! empty( $data['accepts_reservations'] ) ) {
        $schema['acceptsReservations'] = true;
    }

    // hasMenu: link to the page using template-menu.php, if any.
    $menu_url = il_panino_seo_get_menu_page_url();
    if ( '' !== $menu_url ) {
        $schema['hasMenu'] = $menu_url;
    }

    /**
     * Filter the Restaurant schema array before it is encoded.
     *
     * @param array $schema Schema.org Restaurant array.
     * @param array $data   Resolved business data.
     */
    $schema = apply_filters( 'il_panino_seo_restaurant_schema', $schema, $data );

    // If only the @context/@type/url/name (defaults) survived, bail out.
    $non_meta_keys = array_diff(
        array_keys( $schema ),
        array( '@context', '@type', 'additionalType', 'url', 'name' )
    );
    if ( empty( $non_meta_keys ) && 'Il Panino Bologna' === $schema['name'] ) {
        return null;
    }

    return $schema;
}

/**
 * Resolve the URL of the page assigned to template-menu.php, if published.
 *
 * @return string Permalink, or '' if no published menu page exists.
 */
function il_panino_seo_get_menu_page_url() {
    $menu_pages = get_pages( array(
        'meta_key'    => '_wp_page_template',
        'meta_value'  => 'template-menu.php',
        'number'      => 1,
        'post_status' => 'publish',
    ) );
    if ( empty( $menu_pages ) ) {
        return '';
    }
    $url = get_permalink( $menu_pages[0]->ID );
    return $url ? $url : '';
}

/**
 * Echo the Restaurant JSON-LD block in <head>.
 *
 * @return void
 */
function il_panino_seo_render_restaurant_schema() {
    // If a third-party SEO plugin is active, defer to it and avoid duplicates.
    if ( il_panino_seo_third_party_active() ) {
        return;
    }

    $schema = il_panino_seo_build_restaurant_schema();
    if ( empty( $schema ) ) {
        return;
    }

    $json = wp_json_encode( $schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES );
    if ( false === $json ) {
        return;
    }

    // wp_json_encode() output is safe inside a <script type="application/ld+json">
    // block: it has no </script> sequence (slashes are escaped to \/ when needed).
    // We also defensively escape any stray "</" just in case a filter injected one.
    $json = str_replace( '</', '<\/', $json );

    echo "\n<script type=\"application/ld+json\">" . $json . "</script>\n"; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
}
add_action( 'wp_head', 'il_panino_seo_render_restaurant_schema', 20 );
