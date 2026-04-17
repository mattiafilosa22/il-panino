<?php
/**
 * Seed script per il CPT `panino`.
 *
 * Esegui: docker exec wp_app wp eval-file /var/www/html/wp-content/themes/il-panino-theme/inc/seed/seed-panini.php --allow-root
 *
 * Idempotente. Cancella solo i panini assegnati alle vecchie categorie legacy
 * (classici, speciali, aperitivi) e sostituisce con dati nuovi.
 */

if ( ! defined('ABSPATH') ) {
    exit;
}

const IL_PANINO_SEED_LEGACY_CATEGORY_SLUGS = array('classici', 'speciali', 'aperitivi');

const IL_PANINO_SEED_CATEGORIES = array(
    'classic'  => array('name' => 'Classic',  'menu_order' => 10),
    'premium'  => array('name' => 'Premium',  'menu_order' => 20),
    'fit'      => array('name' => 'Fit',      'menu_order' => 30),
    'frittini' => array('name' => 'Frittini', 'menu_order' => 40),
    'dolci'    => array('name' => 'Dolci',    'menu_order' => 50),
);

function il_panino_seed_data(): array {
    return array(
        'classic' => array(
            array('title' => 'Felsina',         'medium' => 7.00, 'ingredienti' => 'Mortadella, burrata, granella di pistacchio, rucola'),
            array('title' => 'Otto Colonne',    'medium' => 7.50, 'ingredienti' => 'Mortadella, squacquerone, crema di pistacchio, rucola'),
            array('title' => 'Mazzini',         'medium' => 7.00, 'ingredienti' => 'Mortadella, scamorza affumicata, melanzane sott\'olio'),
            array('title' => 'San Vitale',      'medium' => 7.00, 'ingredienti' => 'Salame strolghino, tomino, funghi trifolati, salsa piccante, rucola'),
            array('title' => 'Stalingrado',     'medium' => 7.00, 'ingredienti' => 'Prosciutto crudo, mozzarella fior di latte, pomodori secchi, basilico'),
            array('title' => 'Dell\'Arcoveggio','medium' => 7.00, 'ingredienti' => 'Salame Milano, brie, pomodori secchi, carciofi sott\'olio'),
            array('title' => 'Rizzoli',         'medium' => 7.00, 'ingredienti' => 'Prosciutto cotto, scamorza, insalata, pomodoro, crema tartufata'),
            array('title' => 'Santo Stefano',   'medium' => 7.50, 'ingredienti' => 'Prosciutto crudo, burratina, pomodori freschi, rucola'),
        ),
        'premium' => array(
            array('title' => 'Emilia Ponente',  'medium' => 9.00, 'ingredienti' => 'Porchetta, pecorino, melanzane grigliate, pomodori, maionese'),
            array('title' => 'Volturno',        'medium' => 9.00, 'ingredienti' => 'Porchetta, scamorza affumicata, friarielli, salsa piccante'),
            array('title' => 'Belle Arti',      'medium' => 8.00, 'ingredienti' => 'Coppa, scamorza, brie, zucchine e melanzane grigliate, maionese'),
            array('title' => 'Delle Moline',    'medium' => 8.00, 'ingredienti' => 'Salame, scamorza affumicata, pomodori secchi, salsa piccante, rucola'),
            array('title' => 'Ferrarese',       'medium' => 8.00, 'ingredienti' => 'Spianata piccante, scamorza affumicata, melanzane, tabasco, rucola'),
            array('title' => 'Andrea Costa',    'medium' => 8.00, 'ingredienti' => 'Speck, brie, crema di kiwi, rucola'),
            array('title' => 'Centotrecento',   'medium' => 8.00, 'ingredienti' => 'Lardo di Colonnata, squacquerone, pomodori secchi'),
            array('title' => 'Mascarella',      'medium' => 8.00, 'ingredienti' => 'Capocollo, scamorza affumicata, pomodori secchi, carciofi sott\'olio'),
        ),
        'fit' => array(
            array('title' => 'Battisti',       'medium' => 9.50, 'ingredienti' => 'Bresaola, scaglie di grana, rucola, pomodori, limone'),
            array('title' => 'Arno',           'medium' => 7.00, 'ingredienti' => 'Fesa di tacchino, pecorino, basilico, rucola'),
            array('title' => 'Ruggi',          'medium' => 7.00, 'ingredienti' => 'Fesa di tacchino, insalata, uovo sodo, salsa tzatziki'),
            array('title' => 'Angelli',        'medium' => 7.00, 'ingredienti' => 'Sgombretto, zucchine grigliate, friarielli, crema di noci'),
            array('title' => 'Dei Carracci',   'medium' => 6.50, 'ingredienti' => 'Mozzarella, zucchine grigliate, scaglie di grana, basilico'),
            array('title' => 'Azzurra',        'medium' => 6.50, 'ingredienti' => 'Mozzarella, zucchine e melanzane grigliate, rucola'),
        ),
        'frittini' => array(
            array('title' => 'Patate Fritte Dippers', 'medium' => 4.50, 'flat' => true),
            array('title' => 'Fried Cheese Stick',    'medium' => 4.00, 'flat' => true),
            array('title' => 'Verdurine Pastellate',  'medium' => 4.50, 'flat' => true),
            array('title' => 'Polpettine di Carne',   'medium' => 5.00, 'flat' => true),
            array('title' => 'Olive all\'Ascolana',   'medium' => 5.00, 'flat' => true),
        ),
        'dolci' => array(
            array('title' => 'Tiramisù',              'medium' => 5.50, 'flat' => true),
            array('title' => 'Delizia al Pistacchio', 'medium' => 5.50, 'flat' => true),
            array('title' => 'Cheesecake',            'medium' => 5.50, 'flat' => true),
            array('title' => 'Caramello Salato',      'medium' => 5.50, 'flat' => true),
        ),
    );
}

function il_panino_seed_log(string $message): void {
    if ( defined('WP_CLI') && WP_CLI ) {
        WP_CLI::log($message);
    } else {
        echo $message . PHP_EOL;
    }
}

function il_panino_seed_error(string $message): void {
    if ( defined('WP_CLI') && WP_CLI ) {
        WP_CLI::error($message);
    } else {
        fwrite(STDERR, 'ERROR: ' . $message . PHP_EOL);
        exit(1);
    }
}

function il_panino_seed_ensure_categories(): void {
    foreach ( IL_PANINO_SEED_CATEGORIES as $slug => $cfg ) {
        $term = term_exists($slug, 'categoria_panino');
        if ( ! $term ) {
            $created = wp_insert_term($cfg['name'], 'categoria_panino', array('slug' => $slug));
            if ( is_wp_error($created) ) {
                il_panino_seed_error("Impossibile creare categoria {$slug}: " . $created->get_error_message());
            }
            $term_id = (int) $created['term_id'];
            il_panino_seed_log("[category created] {$cfg['name']} ({$slug})");
        } else {
            $term_id = (int) $term['term_id'];
            wp_update_term($term_id, 'categoria_panino', array('name' => $cfg['name']));
            il_panino_seed_log("[category ok] {$cfg['name']} ({$slug})");
        }
        update_term_meta($term_id, 'menu_order', $cfg['menu_order']);
    }

    foreach ( IL_PANINO_SEED_LEGACY_CATEGORY_SLUGS as $legacy_slug ) {
        $term = term_exists($legacy_slug, 'categoria_panino');
        if ( $term ) {
            $term_id = (int) $term['term_id'];
            wp_delete_term($term_id, 'categoria_panino');
            il_panino_seed_log("[category removed] {$legacy_slug}");
        }
    }
}

function il_panino_seed_wipe_legacy_panini(): void {
    $posts = get_posts(array(
        'post_type'      => 'panino',
        'post_status'    => 'any',
        'posts_per_page' => -1,
        'tax_query'      => array(
            array(
                'taxonomy' => 'categoria_panino',
                'field'    => 'slug',
                'terms'    => IL_PANINO_SEED_LEGACY_CATEGORY_SLUGS,
            ),
        ),
        'fields' => 'ids',
    ));

    foreach ( $posts as $post_id ) {
        wp_delete_post($post_id, true);
        il_panino_seed_log("[panino wiped] #{$post_id} (legacy category)");
    }
}

function il_panino_seed_upsert(array $item, string $cat_slug): void {
    $title  = $item['title'];
    $medium = (float) $item['medium'];
    $is_flat = ! empty($item['flat']);

    $existing = get_page_by_title($title, OBJECT, 'panino');
    $post_data = array(
        'post_type'   => 'panino',
        'post_title'  => $title,
        'post_status' => 'publish',
    );

    if ( $existing ) {
        $post_data['ID'] = $existing->ID;
        $post_id = wp_update_post($post_data, true);
        $action = 'updated';
    } else {
        $post_id = wp_insert_post($post_data, true);
        $action = 'created';
    }

    if ( is_wp_error($post_id) ) {
        il_panino_seed_log("[error] {$title}: " . $post_id->get_error_message());
        return;
    }

    update_field('prezzo_medium', $medium, $post_id);
    if ( $is_flat ) {
        update_field('prezzo_large', '', $post_id);
        update_field('prezzo_xxl', '', $post_id);
    } else {
        update_field('prezzo_large', round($medium + 3, 2), $post_id);
        update_field('prezzo_xxl', round($medium + 10, 2), $post_id);
    }

    if ( isset($item['ingredienti']) ) {
        update_field('ingredienti', $item['ingredienti'], $post_id);
    } else {
        update_field('ingredienti', '', $post_id);
    }

    wp_set_object_terms($post_id, array($cat_slug), 'categoria_panino', false);

    il_panino_seed_log("[panino {$action}] {$title} (€{$medium}" . ($is_flat ? ', flat' : '') . ") → {$cat_slug}");
}

function il_panino_seed_run(): void {
    if ( ! post_type_exists('panino') ) {
        il_panino_seed_error('CPT `panino` non registrato — controlla che il tema sia attivo.');
    }
    if ( ! function_exists('update_field') ) {
        il_panino_seed_error('ACF non disponibile — plugin non attivo.');
    }

    // ORDINE CRITICO: wipe PRIMA di ensure_categories().
    // ensure_categories() cancella le categorie legacy (classici/speciali/aperitivi)
    // e la cancellazione del term distrugge via cascade i term_relationships.
    // Se invertito, wipe_legacy_panini() non troverebbe più nulla tramite tax_query
    // (i post rimarrebbero orfani e la funzione diventa non idempotente da stato sporco).
    il_panino_seed_wipe_legacy_panini();
    il_panino_seed_ensure_categories();

    foreach ( il_panino_seed_data() as $cat_slug => $items ) {
        foreach ( $items as $item ) {
            il_panino_seed_upsert($item, $cat_slug);
        }
    }

    il_panino_seed_log('[seed done]');
}

il_panino_seed_run();
