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
    // Caricamento Font: Bebas Neue
    wp_enqueue_style( 'google-fonts-bebas', 'https://fonts.googleapis.com/css2?family=Bebas+Neue&display=swap', array(), null );

    wp_enqueue_style( 'il-panino-style', get_stylesheet_uri(), array(), '1.0.0' );
    
    // Caricamento JS Custom
    wp_enqueue_script( 'il-panino-navigation', get_template_directory_uri() . '/js/main.js', array(), '1.0.0', true );
}
add_action( 'wp_enqueue_scripts', 'il_panino_theme_scripts' );

/**
 * Setup ACF Options Page (se necessario)
 */
if( function_exists('acf_add_options_page') ) {
    acf_add_options_page(array(
        'page_title'    => 'Impostazioni Tema',
        'menu_title'    => 'Impostazioni Tema',
        'menu_slug'     => 'theme-general-settings',
        'capability'    => 'edit_posts',
        'redirect'      => false
    ));
}
