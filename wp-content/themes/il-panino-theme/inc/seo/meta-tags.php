<?php
/**
 * SEO meta tags: description, OpenGraph, Twitter Cards.
 *
 * Outputs `<meta name="description">`, `og:*` and `twitter:*` tags in <head>.
 * Defers to third-party SEO plugins (Yoast, Rank Math, SEOPress, AIOSEO) when
 * one is active, to avoid duplicate tags.
 *
 * Hooked on `wp_head` at priority 1 so the meta block sits at the top of
 * <head>, above the JSON-LD schema (priority 20).
 *
 * Also removes WordPress core `rel_canonical` (registered on wp_head priority 10)
 * to prevent duplicate `<link rel="canonical">` tags. Suppression is gated on
 * `il_panino_seo_third_party_active()` so SEO plugins keep full control.
 *
 * @package il-panino-theme
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Detect whether a third-party SEO plugin is currently providing meta tags.
 *
 * Used by both the meta-tags renderer and the JSON-LD renderer.
 *
 * @return bool
 */
function il_panino_seo_third_party_active() {
    if (
        defined( 'WPSEO_VERSION' )          // Yoast SEO.
        || defined( 'RANK_MATH_VERSION' )   // Rank Math.
        || defined( 'SEOPRESS_VERSION' )    // SEOPress.
        || defined( 'AIOSEO_VERSION' )      // All in One SEO.
    ) {
        return true;
    }
    /**
     * Allow third-party integrations to declare ownership of SEO output.
     *
     * @param bool $active Whether to suppress theme-side SEO output.
     */
    return (bool) apply_filters( 'il_panino_seo_third_party_active', false );
}

/**
 * Truncate a string to a maximum length, ending on a word boundary where possible.
 *
 * @param string $text  Input text.
 * @param int    $limit Maximum length, in characters. Defaults to 160.
 * @return string
 */
function il_panino_seo_truncate( $text, $limit = 160 ) {
    $text = trim( wp_strip_all_tags( (string) $text ) );
    if ( '' === $text ) {
        return '';
    }
    if ( function_exists( 'mb_strlen' ) ) {
        if ( mb_strlen( $text, 'UTF-8' ) <= $limit ) {
            return $text;
        }
        $cut = mb_substr( $text, 0, $limit, 'UTF-8' );
    } else {
        if ( strlen( $text ) <= $limit ) {
            return $text;
        }
        $cut = substr( $text, 0, $limit );
    }
    // Trim back to the last word boundary if we are cutting mid-word.
    $space_pos = strrpos( $cut, ' ' );
    if ( false !== $space_pos && $space_pos > ( $limit * 0.6 ) ) {
        $cut = substr( $cut, 0, $space_pos );
    }
    return rtrim( $cut, " \t\n\r\0\x0B,;:.-" ) . '…';
}

/**
 * Resolve the title used in OG/Twitter tags for the current request.
 *
 * @return string
 */
function il_panino_seo_resolve_title() {
    if ( is_singular() ) {
        $post_id = get_queried_object_id();
        if ( $post_id ) {
            $title = get_the_title( $post_id );
            if ( $title ) {
                return wp_strip_all_tags( $title );
            }
        }
    }
    if ( is_home() || is_front_page() ) {
        return wp_strip_all_tags( get_bloginfo( 'name' ) );
    }
    if ( is_archive() ) {
        $title = get_the_archive_title();
        if ( $title ) {
            return wp_strip_all_tags( $title );
        }
    }
    if ( is_search() ) {
        return sprintf( /* translators: %s: search term. */ __( 'Risultati per: %s', 'il-panino-theme' ), get_search_query() );
    }
    return wp_strip_all_tags( get_bloginfo( 'name' ) );
}

/**
 * Resolve the meta description for the current request.
 *
 * Priority: post excerpt → post content (auto-excerpt) → business description fallback.
 *
 * @return string
 */
function il_panino_seo_resolve_description() {
    $business = il_panino_seo_get_business_data();
    $fallback = isset( $business['description'] ) ? (string) $business['description'] : '';

    if ( is_singular() ) {
        $post = get_queried_object();
        if ( $post instanceof WP_Post ) {
            // Hand-written excerpt wins.
            if ( ! empty( $post->post_excerpt ) ) {
                return il_panino_seo_truncate( $post->post_excerpt );
            }
            // Auto-generated excerpt from content.
            if ( ! empty( $post->post_content ) ) {
                $auto = wp_trim_words( wp_strip_all_tags( strip_shortcodes( $post->post_content ) ), 40, '' );
                if ( '' !== trim( $auto ) ) {
                    return il_panino_seo_truncate( $auto );
                }
            }
        }
    }

    return il_panino_seo_truncate( $fallback );
}

/**
 * Resolve the canonical URL for the current request.
 *
 * @return string
 */
function il_panino_seo_resolve_canonical() {
    if ( is_singular() ) {
        $url = get_permalink( get_queried_object_id() );
        if ( $url ) {
            return $url;
        }
    }
    if ( is_home() || is_front_page() ) {
        return home_url( '/' );
    }
    if ( is_category() || is_tag() || is_tax() ) {
        $term = get_queried_object();
        if ( $term && ! is_wp_error( $term ) ) {
            $url = get_term_link( $term );
            if ( ! is_wp_error( $url ) ) {
                return (string) $url;
            }
        }
    }
    if ( is_post_type_archive() ) {
        $url = get_post_type_archive_link( get_query_var( 'post_type' ) );
        if ( $url ) {
            return $url;
        }
    }
    // Fallback: best-effort current URL.
    // Always derive scheme + host from home_url() to avoid Host header injection
    // (HTTP_HOST is attacker-controlled and must never be reflected into canonical/og:url).
    $home_parts = wp_parse_url( home_url() );
    $scheme     = isset( $home_parts['scheme'] ) ? $home_parts['scheme'] : ( is_ssl() ? 'https' : 'http' );
    $host       = isset( $home_parts['host'] ) ? $home_parts['host'] : '';
    if ( '' === $host ) {
        // No reliable host: bail out rather than emit a broken canonical.
        return home_url( '/' );
    }

    // Sanitize REQUEST_URI: keep only path + querystring, never authority.
    $raw_uri = isset( $_SERVER['REQUEST_URI'] ) ? wp_unslash( $_SERVER['REQUEST_URI'] ) : '/';
    $parts   = wp_parse_url( $raw_uri );
    $path    = isset( $parts['path'] ) ? $parts['path'] : '/';
    $query   = isset( $parts['query'] ) ? '?' . $parts['query'] : '';

    return esc_url_raw( $scheme . '://' . $host . $path . $query );
}

/**
 * Suppress WordPress core's `rel_canonical` so the theme emits a single canonical tag.
 *
 * Core registers `rel_canonical` on `wp_head` at priority 10. Our renderer runs at
 * priority 1 and would otherwise produce a duplicate `<link rel="canonical">` in <head>.
 *
 * When a third-party SEO plugin is active we leave core untouched and skip our own
 * output (see `il_panino_seo_render_meta_tags`), so the plugin remains the sole source.
 *
 * Hooked on `template_redirect` (priority 1) which fires before `wp_head`.
 *
 * @return void
 */
function il_panino_seo_dedupe_core_canonical() {
    if ( il_panino_seo_third_party_active() ) {
        return;
    }
    remove_action( 'wp_head', 'rel_canonical' );
}
add_action( 'template_redirect', 'il_panino_seo_dedupe_core_canonical', 1 );

/**
 * Resolve the OG image URL for the current request.
 *
 * Priority: featured image (full size) → configured default OG image → ''.
 *
 * @return string
 */
function il_panino_seo_resolve_og_image() {
    if ( is_singular() ) {
        $post_id = get_queried_object_id();
        if ( $post_id && has_post_thumbnail( $post_id ) ) {
            $url = get_the_post_thumbnail_url( $post_id, 'full' );
            if ( $url ) {
                return $url;
            }
        }
    }
    return il_panino_seo_get_default_og_image_url();
}

/**
 * Resolve the OG type for the current request.
 *
 * @return string
 */
function il_panino_seo_resolve_og_type() {
    if ( is_singular( 'post' ) ) {
        return 'article';
    }
    if ( is_singular( 'panino' ) ) {
        // Restaurant menu item per OpenGraph "restaurant" vertical.
        return 'restaurant.menu_item';
    }
    return 'website';
}

/**
 * Echo a single <meta> tag with name/property + content.
 *
 * @param string $attribute 'name' or 'property'.
 * @param string $key       Tag key (e.g. 'description', 'og:title').
 * @param string $value     Raw value; will be esc_attr()'d.
 * @return void
 */
function il_panino_seo_print_meta( $attribute, $key, $value ) {
    if ( '' === (string) $value ) {
        return;
    }
    printf(
        '<meta %1$s="%2$s" content="%3$s">' . "\n",
        esc_attr( $attribute ),
        esc_attr( $key ),
        esc_attr( $value )
    );
}

/**
 * Render description, OpenGraph and Twitter meta tags in <head>.
 *
 * @return void
 */
function il_panino_seo_render_meta_tags() {
    if ( il_panino_seo_third_party_active() ) {
        return;
    }

    $title       = il_panino_seo_resolve_title();
    $description = il_panino_seo_resolve_description();
    $canonical   = il_panino_seo_resolve_canonical();
    $image       = il_panino_seo_resolve_og_image();
    $og_type     = il_panino_seo_resolve_og_type();
    $site_name   = get_bloginfo( 'name' );
    $locale      = get_locale() ? get_locale() : 'it_IT';

    // Standard description.
    il_panino_seo_print_meta( 'name', 'description', $description );

    // Canonical link (separate from meta).
    if ( '' !== $canonical ) {
        printf( '<link rel="canonical" href="%s">' . "\n", esc_url( $canonical ) );
    }

    // OpenGraph.
    il_panino_seo_print_meta( 'property', 'og:type', $og_type );
    il_panino_seo_print_meta( 'property', 'og:title', $title );
    il_panino_seo_print_meta( 'property', 'og:description', $description );
    il_panino_seo_print_meta( 'property', 'og:url', $canonical );
    il_panino_seo_print_meta( 'property', 'og:site_name', $site_name );
    il_panino_seo_print_meta( 'property', 'og:locale', $locale );
    if ( '' !== $image ) {
        il_panino_seo_print_meta( 'property', 'og:image', $image );
    }

    // Twitter Card.
    il_panino_seo_print_meta( 'name', 'twitter:card', 'summary_large_image' );
    il_panino_seo_print_meta( 'name', 'twitter:title', $title );
    il_panino_seo_print_meta( 'name', 'twitter:description', $description );
    if ( '' !== $image ) {
        il_panino_seo_print_meta( 'name', 'twitter:image', $image );
    }
}
add_action( 'wp_head', 'il_panino_seo_render_meta_tags', 1 );
