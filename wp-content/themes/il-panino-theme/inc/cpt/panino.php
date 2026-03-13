<?php
/**
 * Register Panino Custom Post Type
 */
function il_panino_register_cpt_panino() {
    $labels = array(
        'name'                  => _x( 'Panini', 'Post type general name', 'il-panino-theme' ),
        'singular_name'         => _x( 'Panino', 'Post type singular name', 'il-panino-theme' ),
        'menu_name'             => _x( 'Panini', 'Admin Menu text', 'il-panino-theme' ),
        'name_admin_bar'        => _x( 'Panino', 'Add New on Toolbar', 'il-panino-theme' ),
        'add_new'               => __( 'Aggiungi Nuovo', 'il-panino-theme' ),
        'add_new_item'          => __( 'Aggiungi Nuovo Panino', 'il-panino-theme' ),
        'new_item'              => __( 'Nuovo Panino', 'il-panino-theme' ),
        'edit_item'             => __( 'Modifica Panino', 'il-panino-theme' ),
        'view_item'             => __( 'Visualizza Panino', 'il-panino-theme' ),
        'all_items'             => __( 'Tutti i Panini', 'il-panino-theme' ),
        'search_items'          => __( 'Cerca Panini', 'il-panino-theme' ),
        'not_found'             => __( 'Nessun panino trovato.', 'il-panino-theme' ),
        'not_found_in_trash'    => __( 'Nessun panino trovato nel cestino.', 'il-panino-theme' ),
    );

    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => array( 'slug' => 'panino' ),
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_position'      => 5,
        'menu_icon'          => 'dashicons-food',
        'supports'           => array( 'title', 'editor', 'thumbnail', 'excerpt' ),
        'show_in_rest'       => true, // abilita gutenberg
    );

    register_post_type( 'panino', $args );
}
add_action( 'init', 'il_panino_register_cpt_panino' );
