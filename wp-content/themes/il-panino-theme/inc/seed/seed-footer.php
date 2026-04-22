<?php
/**
 * Idempotent seed for footer Customizer settings (theme_mods).
 *
 * Run via:
 *   docker exec wp_app wp eval-file \
 *     /var/www/html/wp-content/themes/il-panino-theme/inc/seed/seed-footer.php \
 *     --allow-root
 *
 * Writes each theme_mod only when currently empty, so re-running never
 * overwrites editor changes performed via "Aspetto > Personalizza > Contatti
 * Footer".
 *
 * @package il-panino-theme
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$il_panino_seed_footer_data = array(
    'footer_sitemap_titolo'     => 'Sitemap',
    'footer_contatti_titolo'    => 'Contatti',
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
    $il_panino_seed_current = get_theme_mod( $il_panino_seed_name, '' );
    if ( $il_panino_seed_current === '' || $il_panino_seed_current === null || $il_panino_seed_current === false ) {
        set_theme_mod( $il_panino_seed_name, $il_panino_seed_value );
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
