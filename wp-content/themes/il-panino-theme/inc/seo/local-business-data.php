<?php
/**
 * Local Business data layer.
 *
 * Centralised access to the business profile (name, address, opening hours,
 * social URLs, etc.) used by Schema.org JSON-LD and SEO meta tags.
 *
 * The data lives in Customizer theme_mods rather than ACF Options because the
 * project does not ship ACF Pro (see note in functions.php on the footer
 * customizer: ACF options pages require ACF Pro, which is unavailable here).
 *
 * Public surface:
 *   - il_panino_seo_get_business_data(): array<string,mixed>
 *   - il_panino_seo_parse_opening_hours( string ): array<int,array{days:string[],opens:string,closes:string,closed:bool}>
 *   - il_panino_seo_parse_string_list( string ): string[]
 *
 * @package il-panino-theme
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Return the full local business data set as a normalised array.
 *
 * All scalar fields are returned as strings (possibly empty).
 * `opening_hours` and `serves_cuisine` are returned already parsed.
 *
 * @return array<string,mixed>
 */
function il_panino_seo_get_business_data() {
    $defaults = array(
        'name'                 => 'Il Panino Bologna',
        'description'          => '',
        'phone'                => '',
        'email'                => '',
        'street'               => '',
        'city'                 => 'Bologna',
        'postal_code'          => '',
        'region'               => 'BO',
        'country'              => 'IT',
        'lat'                  => '',
        'lng'                  => '',
        'google_maps_url'      => '',
        'price_range'          => '€€',
        'serves_cuisine'       => '',
        'accepts_reservations' => '',
        'opening_hours'        => '',
        'facebook_url'         => '',
        'instagram_url'        => '',
        'tripadvisor_url'      => '',
        'thefork_url'          => '',
        'default_og_image_id'  => 0,
    );

    $data = array();
    foreach ( $defaults as $key => $default ) {
        $data[ $key ] = get_theme_mod( 'il_panino_business_' . $key, $default );
    }

    // Normalise structured fields.
    $data['opening_hours_raw']  = (string) $data['opening_hours'];
    $data['opening_hours']      = il_panino_seo_parse_opening_hours( (string) $data['opening_hours'] );
    $data['serves_cuisine_raw'] = (string) $data['serves_cuisine'];
    $data['serves_cuisine']     = il_panino_seo_parse_string_list( (string) $data['serves_cuisine'] );
    $data['accepts_reservations'] = ( '1' === (string) $data['accepts_reservations'] || true === $data['accepts_reservations'] );

    /**
     * Filter the resolved business data array.
     *
     * Use this to override or extend any field at render time.
     *
     * @param array $data Resolved business data.
     */
    return apply_filters( 'il_panino_seo_business_data', $data );
}

/**
 * Parse an opening-hours textarea into a structured array.
 *
 * Expected line format (one rule per line):
 *   "Mon,Tue,Wed,Thu,Fri | 11:30 | 15:30"
 *   "Sat | 18:30 | 22:30"
 *   "Sun | closed"
 *
 * Day tokens are case-insensitive and accept English short names (Mon..Sun) or
 * full names (Monday..Sunday). Lines starting with `#` and empty lines are
 * ignored. Time fields must be HH:MM. Invalid lines are silently dropped.
 *
 * @param string $raw Raw textarea content.
 * @return array<int,array{days:string[],opens:string,closes:string,closed:bool}>
 */
function il_panino_seo_parse_opening_hours( $raw ) {
    $rules = array();
    if ( '' === trim( (string) $raw ) ) {
        return $rules;
    }

    $day_aliases = array(
        'mon'       => 'Monday',
        'monday'    => 'Monday',
        'tue'       => 'Tuesday',
        'tues'      => 'Tuesday',
        'tuesday'   => 'Tuesday',
        'wed'       => 'Wednesday',
        'weds'      => 'Wednesday',
        'wednesday' => 'Wednesday',
        'thu'       => 'Thursday',
        'thur'      => 'Thursday',
        'thurs'     => 'Thursday',
        'thursday'  => 'Thursday',
        'fri'       => 'Friday',
        'friday'    => 'Friday',
        'sat'       => 'Saturday',
        'saturday'  => 'Saturday',
        'sun'       => 'Sunday',
        'sunday'    => 'Sunday',
    );

    $lines = preg_split( '/\r\n|\r|\n/', (string) $raw );
    foreach ( (array) $lines as $line ) {
        $line = trim( (string) $line );
        if ( '' === $line || '#' === $line[0] ) {
            continue;
        }

        $parts = array_map( 'trim', explode( '|', $line ) );
        if ( count( $parts ) < 2 ) {
            continue;
        }

        $day_tokens = array_filter( array_map( 'trim', explode( ',', $parts[0] ) ) );
        $days       = array();
        foreach ( $day_tokens as $token ) {
            $key = strtolower( $token );
            if ( isset( $day_aliases[ $key ] ) ) {
                $days[] = $day_aliases[ $key ];
            }
        }
        $days = array_values( array_unique( $days ) );
        if ( empty( $days ) ) {
            continue;
        }

        $second = strtolower( $parts[1] );
        if ( 'closed' === $second ) {
            $rules[] = array(
                'days'   => $days,
                'opens'  => '',
                'closes' => '',
                'closed' => true,
            );
            continue;
        }

        if ( count( $parts ) < 3 ) {
            continue;
        }

        $opens  = $parts[1];
        $closes = $parts[2];
        if ( ! preg_match( '/^\d{1,2}:\d{2}$/', $opens ) || ! preg_match( '/^\d{1,2}:\d{2}$/', $closes ) ) {
            continue;
        }

        $rules[] = array(
            'days'   => $days,
            'opens'  => $opens,
            'closes' => $closes,
            'closed' => false,
        );
    }

    return $rules;
}

/**
 * Parse a comma- or newline-separated list into a clean array of strings.
 *
 * @param string $raw Raw input.
 * @return string[]
 */
function il_panino_seo_parse_string_list( $raw ) {
    if ( '' === trim( (string) $raw ) ) {
        return array();
    }
    $parts = preg_split( '/[,\r\n]+/', (string) $raw );
    $out   = array();
    foreach ( (array) $parts as $part ) {
        $part = trim( (string) $part );
        if ( '' !== $part ) {
            $out[] = $part;
        }
    }
    return array_values( array_unique( $out ) );
}

/**
 * Return the absolute URL of the configured OG default image, or an empty
 * string if none is set or the attachment cannot be resolved.
 *
 * @return string
 */
function il_panino_seo_get_default_og_image_url() {
    $attachment_id = (int) get_theme_mod( 'il_panino_business_default_og_image_id', 0 );
    if ( $attachment_id <= 0 ) {
        return '';
    }
    $url = wp_get_attachment_image_url( $attachment_id, 'full' );
    return $url ? $url : '';
}
