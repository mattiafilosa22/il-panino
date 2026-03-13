<?php
/**
 * Register Categoria Taxonomy for Panino CPT
 */
function il_panino_register_tax_categoria_panino() {
    $labels = array(
        'name'                       => _x( 'Categorie Panini', 'Taxonomy General Name', 'il-panino-theme' ),
        'singular_name'              => _x( 'Categoria Panino', 'Taxonomy Singular Name', 'il-panino-theme' ),
        'menu_name'                  => __( 'Categorie', 'il-panino-theme' ),
        'all_items'                  => __( 'Tutte le Categorie', 'il-panino-theme' ),
        'parent_item'                => __( 'Categoria Genitore', 'il-panino-theme' ),
        'parent_item_colon'          => __( 'Categoria Genitore:', 'il-panino-theme' ),
        'new_item_name'              => __( 'Nuovo Nome Categoria', 'il-panino-theme' ),
        'add_new_item'               => __( 'Aggiungi Nuova Categoria', 'il-panino-theme' ),
        'edit_item'                  => __( 'Modifica Categoria', 'il-panino-theme' ),
        'update_item'                => __( 'Aggiorna Categoria', 'il-panino-theme' ),
        'view_item'                  => __( 'Vedi Categoria', 'il-panino-theme' ),
        'separate_items_with_commas' => __( 'Separa le categorie con virgole', 'il-panino-theme' ),
        'add_or_remove_items'        => __( 'Aggiungi o rimuovi categorie', 'il-panino-theme' ),
        'choose_from_most_used'      => __( 'Scegli tra le categorie più usate', 'il-panino-theme' ),
        'popular_items'              => __( 'Categorie Popolari', 'il-panino-theme' ),
        'search_items'               => __( 'Cerca Categorie', 'il-panino-theme' ),
        'not_found'                  => __( 'Nessuna categoria trovata', 'il-panino-theme' ),
        'no_terms'                   => __( 'Nessuna categoria', 'il-panino-theme' ),
        'items_list'                 => __( 'Lista categorie', 'il-panino-theme' ),
        'items_list_navigation'      => __( 'Navigazione lista categorie', 'il-panino-theme' ),
    );
    
    $args = array(
        'labels'                     => $labels,
        'hierarchical'               => true,
        'public'                     => true,
        'show_ui'                    => true,
        'show_admin_column'          => true,
        'show_in_nav_menus'          => true,
        'show_tagcloud'              => true,
        'show_in_rest'               => true, // abilita gutenberg/rest api support
        'rewrite'                    => array( 'slug' => 'categoria-panino' ),
    );
    
    register_taxonomy( 'categoria_panino', array( 'panino' ), $args );
}
add_action( 'init', 'il_panino_register_tax_categoria_panino', 0 );
