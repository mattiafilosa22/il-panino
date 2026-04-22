<?php
/**
 * Idempotent seed for footer ACF fields on the shared options page.
 *
 * Run via:
 *   docker exec wp_app wp eval-file \
 *     /var/www/html/wp-content/themes/il-panino-theme/inc/seed/seed-footer.php \
 *     --allow-root
 *
 * Writes each field only when currently empty, so re-running never overwrites
 * editor changes. Targets object_id 'option' (maps to wp_options rows prefixed
 * with `options_`) because the footer component reads from the options page to
 * stay template-agnostic.
 *
 * @package il-panino-theme
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( ! function_exists( 'update_field' ) || ! function_exists( 'get_field' ) ) {
    if ( defined( 'WP_CLI' ) && WP_CLI ) {
        WP_CLI::warning( '[seed-footer] ACF is not active; aborting.' );
    }
    return;
}

$il_panino_seed_footer_data = array(
    'footer_indirizzo_1'        => 'Via Galliera, 91/A',
    'footer_indirizzo_2'        => '40121 Bologna BO',
    'footer_indirizzo_maps_url' => 'https://www.google.com/maps/search/?api=1&query=Via+Galliera+91%2FA+40121+Bologna+BO',
    'footer_telefono_numero'    => '393409677143',
    'footer_telefono_url'       => 'https://wa.me/393409677143',
    'footer_orari_titolo'       => 'Aperto tutti i giorni:',
    'footer_orari_fascia_1'     => '11:30 - 15:30',
    'footer_orari_fascia_2'     => '18:30 - 21:00',
);

foreach ( $il_panino_seed_footer_data as $il_panino_seed_name => $il_panino_seed_value ) {
    $il_panino_seed_current = get_field( $il_panino_seed_name, 'option' );
    if ( $il_panino_seed_current === '' || $il_panino_seed_current === null || $il_panino_seed_current === false ) {
        update_field( $il_panino_seed_name, $il_panino_seed_value, 'option' );
        if ( defined( 'WP_CLI' ) && WP_CLI ) {
            WP_CLI::log( "[seed-footer] set {$il_panino_seed_name}" );
        }
    } else {
        if ( defined( 'WP_CLI' ) && WP_CLI ) {
            WP_CLI::log( "[seed-footer] skip {$il_panino_seed_name} (already set)" );
        }
    }
}

unset( $il_panino_seed_footer_data, $il_panino_seed_name, $il_panino_seed_value, $il_panino_seed_current );
