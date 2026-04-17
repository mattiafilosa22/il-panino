# Design: Best Seller flag + Homepage Slider

Data: 2026-04-17
Stato: approvato dall'utente, pronto per plan implementativo

## Obiettivo

Introdurre un flag `panino_bestseller` nel back-office e modificare il query dello slider homepage affinché mostri 5 voci: il best seller in prima posizione + 4 panini casuali scelti tra le categorie Classic / Premium / Fit (escludendo Frittini e Dolci). Il vecchio flag `panino_featured` viene rimosso.

## Scope

### In scope
- ACF: rimuovi `panino_featured`, aggiungi `panino_bestseller` (true_false).
- Template `components/product-slider.php`: nuova logica di query.
- Documentazione d'uso nell'`instructions` del campo ACF.

### Fuori scope
- Enforcement "solo uno marcato" lato DB (se più di uno è marcato, il template prende il primo per data).
- Visual changes alla card dello slider (resta identica).
- Modifiche SCSS.
- Auto-selezione bestseller (nessun algoritmo — è manuale).

## Architettura

### 1) Schema ACF (`inc/acf/panino.php`)

Il field group `group_panino_fields` viene aggiornato:

| Azione | Campo | Tipo | Note |
|--------|-------|------|------|
| rimuovi | `panino_featured` | — | sostituito da `panino_bestseller` |
| aggiungi | `panino_bestseller` | true_false | UI toggle, default off, istruzioni: "Marca UN SOLO panino. Se più di uno è marcato, lo slider prende quello creato per primo." |

Gli altri campi (`immagine_panino_senza_sfondo`, `logo_panino`, `posizione_label_nome`) restano invariati.

### 2) Logica di query (`components/product-slider.php`)

```php
// 1) Trova il bestseller (il primo per data di creazione se multipli).
$bestseller = new WP_Query(array(
    'post_type'      => 'panino',
    'posts_per_page' => 1,
    'orderby'        => 'date',
    'order'          => 'ASC',
    'meta_query'     => array(
        array('key' => 'panino_bestseller', 'value' => '1'),
    ),
    'tax_query'      => $slider_category_filter,
    'fields'         => 'ids',
    'no_found_rows'  => true,
));
$bestseller_id = $bestseller->posts[0] ?? 0;

// 2) Trova 4 random dalle categorie panino-grade, escludendo il bestseller già pescato.
$random = new WP_Query(array(
    'post_type'      => 'panino',
    'posts_per_page' => 4,
    'orderby'        => 'rand',
    'post__not_in'   => array_filter(array($bestseller_id)),
    'tax_query'      => $slider_category_filter,
    'fields'         => 'ids',
    'no_found_rows'  => true,
));
$random_ids = $random->posts;

// 3) Concatena: bestseller in testa, poi i random.
$slider_ids = array_filter(array_merge(array($bestseller_id), $random_ids));

if ( empty($slider_ids) ) return; // niente da mostrare
```

`$slider_category_filter` (costante locale al template):

```php
$slider_category_filter = array(
    array(
        'taxonomy' => 'categoria_panino',
        'field'    => 'slug',
        'terms'    => array('frittini', 'dolci'),
        'operator' => 'NOT IN',
    ),
);
```

Il loop del render itera su `$slider_ids` via `new WP_Query(array('post__in' => $slider_ids, 'orderby' => 'post__in', ...))` per preservare l'ordine (bestseller primo).

### 3) Edge cases

- **Nessun panino marcato bestseller**: lo slider mostra 5 random (bestseller_id = 0 → non aggiunto all'array). Il loop di render funziona regolarmente.
- **Nessun random disponibile** (meno di 4 panini non-frittini/non-dolci): mostra quelli trovati, anche se meno di 5.
- **Nessun panino in assoluto**: `$slider_ids` vuoto → `return` anticipato, sezione non renderizzata.
- **Bestseller in categoria frittini/dolci**: non succede perché il `tax_query` lo esclude anche dalla query bestseller. Se un utente marca un frittino come bestseller, il campo ACF lo permette ma il template lo ignora.

### 4) Randomness

`orderby => 'rand'` genera un ordine diverso ad ogni page load. Accettabile perché:
- Il dataset è piccolo (≤22 panini), non c'è problema di performance.
- L'obiettivo è "a caso", non "stable per user" — un rerender con altri panini è desiderato.

## Principi di design rispettati

- **SRP**: la logica di fetch (bestseller + random) è isolata in testa al template, il render solo itera. Il tax_query filter è una costante locale, non duplicata.
- **Decoupling dai dati**: il template decide cosa pescare in base al meta (`panino_bestseller`) e alla tassonomia, non a un hard-coded id.
- **YAGNI**: no UI admin per scegliere multiple panini, no logica "se bestseller vuoto allora featured=1" (feature legacy droppata pulita).
- **Escape output**: confermato, tutto `esc_*` come prima.
- **No SQL diretto**: solo `WP_Query`.

## Testing

- **Unit-style manual**: marca un panino come bestseller (via wp-admin o WP-CLI `update_field panino_bestseller 1 <post_id>`). Ricarica la homepage. Il primo slide deve essere quel panino.
- **Random check**: ricarica 5 volte la homepage. I 4 slide non-bestseller devono variare in almeno 2 dei 5 reload.
- **Esclusione categorie**: marca un frittino come bestseller. Ricarica homepage. Non deve apparire nello slider (né come bestseller né come random).
- **Edge empty bestseller**: togli il bestseller a tutti. Slider deve mostrare 5 random. Se ci sono solo 22 panini, 5 su 22.
- **PHP lint**: `docker exec wp_app php -l ...`.

## Passi implementativi (alto livello — il plan detail verrà scritto dopo)

1. Aggiorna `inc/acf/panino.php`: rimuovi `panino_featured`, aggiungi `panino_bestseller`.
2. Aggiorna `components/product-slider.php` con la nuova logica di query a 3 step.
3. Marca 1 panino (Otto Colonne?) come bestseller via WP-CLI per testing.
4. Verifica visuale su homepage. Commit dopo ogni step.
