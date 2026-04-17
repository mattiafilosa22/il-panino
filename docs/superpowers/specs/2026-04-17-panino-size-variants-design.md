# Design: panino con 3 size (Medium / Large / XXL)

Data: 2026-04-17
Stato: approvato dall'utente, pronto per plan implementativo

## Obiettivo

Ogni `panino` del menu espone 3 varianti di prezzo — Medium, Large, XXL. La card del menu mostra le 3 righe prezzo al posto dell'attuale singola riga + riga "Menù". Lo stesso CPT `panino` ospita anche `frittini` e `dolci`, che sono voci flat (prezzo unico).

Il menu di riferimento (`IL PANINO BOLOGNA`) viene popolato nel DB tramite uno script seed idempotente. Large = Medium + 3, XXL = Medium + 10 per tutti i panini con 3 size.

## Scope

### In scope
- Schema ACF del CPT `panino`: 3 campi prezzo size.
- Template menu grid (`components/menu-core.php`) + SCSS card.
- Ristrutturazione tassonomia `categoria_panino`: 5 categorie finali (Classic, Premium, Fit, Frittini, Dolci).
- Script seed WP-CLI che popola 22 panini + 5 frittini + 4 dolci.

### Fuori scope
- `components/product-slider.php` (homepage) resta invariato — niente prezzi nel slider.
- Immagini per i nuovi panini (da caricare manualmente via WP admin).
- Campi `allergeni` (non presenti nei dati sorgente; restano vuoti).
- Migrazione dati dei panini di test preesistenti (vengono cancellati).
- Promo "MENU +5€" visibile nel menu cartaceo (funzionalità separata, non implementata).

## Architettura

### 1) Schema ACF (`inc/acf/panino-menu.php`)

Il field group `group_panino_menu_fields` viene modificato:

| Azione | Campo | Tipo | Obbligatorio | Note |
|--------|-------|------|--------------|------|
| rimuovi | `prezzo` | — | — | sostituito da `prezzo_medium` |
| rimuovi | `prezzo_menu` | — | — | sostituito da `prezzo_large` |
| rimuovi | `descrizione_menu` | — | — | funzionalità "menù" tolta dalla card |
| aggiungi | `prezzo_medium` | number (step 0.01) | sì | Per panini: prezzo size medium. Per frittini/dolci: prezzo unico. |
| aggiungi | `prezzo_large` | number (step 0.01) | no | Vuoto per voci flat (frittini/dolci). |
| aggiungi | `prezzo_xxl` | number (step 0.01) | no | Vuoto per voci flat. |
| invariato | `ingredienti` | textarea | no | — |
| invariato | `allergeni` | textarea | no | — |

`field_key` nuovi, naming convention ACF standard (`field_prezzo_medium`, ...).

**Regola di rendering** (usata dal template): se `prezzo_large` OR `prezzo_xxl` sono vuoti, la card mostra una singola riga prezzo (usando `prezzo_medium`). Altrimenti mostra le 3 righe size.

### 2) Template card (`components/menu-core.php`)

Il blocco `c-menu-card__header` + `c-menu-card__menu-info` viene sostituito da:

```php
<h3 class="c-menu-card__name"><?php the_title(); ?></h3>

<div class="c-menu-card__sizes">
    <?php if ( $has_sizes ) : ?>
        <div class="c-menu-card__size-row">
            <span class="c-menu-card__size-label">Medium</span>
            <span class="c-menu-card__size-price">&euro;&nbsp;<?php echo $fmt($prezzo_medium); ?></span>
        </div>
        <div class="c-menu-card__size-row">
            <span class="c-menu-card__size-label">Large</span>
            <span class="c-menu-card__size-price">&euro;&nbsp;<?php echo $fmt($prezzo_large); ?></span>
        </div>
        <div class="c-menu-card__size-row">
            <span class="c-menu-card__size-label">XXL</span>
            <span class="c-menu-card__size-price">&euro;&nbsp;<?php echo $fmt($prezzo_xxl); ?></span>
        </div>
    <?php else : ?>
        <div class="c-menu-card__size-row c-menu-card__size-row--flat">
            <span class="c-menu-card__size-price">&euro;&nbsp;<?php echo $fmt($prezzo_medium); ?></span>
        </div>
    <?php endif; ?>
</div>

<hr class="c-menu-card__divider" />

<?php if ($ingredienti) : ?>
    <p class="c-menu-card__ingredienti"><?php echo esc_html($ingredienti); ?></p>
<?php endif; ?>
<?php if ($allergeni) : ?>
    <p class="c-menu-card__allergeni">Allergeni: <?php echo esc_html($allergeni); ?></p>
<?php endif; ?>
```

`$has_sizes = ! empty($prezzo_large) && ! empty($prezzo_xxl);`
`$fmt` è una closure/helper che fa `number_format((float)$v, 2, ',', '.')` — evita duplicazione.

SRP: la card si limita a rendering; la logica "ha le size?" è un booleano derivato in testa al loop, non sparso nel markup.

### 3) SCSS (`assets/scss/components/_menu-core.scss`)

**Rimosso:**
- `.c-menu-card__row` (era per la riga single-price/menù)
- `.c-menu-card__name--menu`
- tutto il sotto-albero `.c-menu-card__menu-info*`

**Aggiunto:**

```scss
.c-menu-card {
    // ... esistente ...

    &__sizes {
        display: flex;
        flex-direction: column;
        gap: 0.35rem;
        margin: 0.75rem 0;
    }

    &__size-row {
        display: flex;
        justify-content: space-between;
        align-items: baseline;

        &--flat {
            justify-content: flex-end;
        }
    }

    &__size-label {
        font-family: var(--font-menu);
        font-size: 1rem;
        font-weight: 600;
        letter-spacing: 0.5px;
        text-transform: uppercase;
        color: var(--color-text-dark);
    }

    &__size-price {
        font-family: var(--font-heading);
        font-size: 1.4rem;
        color: var(--color-text-dark);
        line-height: 1.15;
    }

    &__divider {
        border: 0;
        border-top: 1px solid rgba(0, 0, 0, 0.08);
        margin: 0.75rem 0;
    }
}
```

Riuso totale delle CSS custom properties esistenti. Nessun nuovo token di design. Il nome-panino (`.c-menu-card__name`) conserva la dimensione/font attuale.

### 4) Tassonomia categorie

**Stato attuale** (query al DB):
- `Aperitivi` (count 0) — eliminata
- `Classici` (count 2) — eliminata
- `Speciali` (count 2) — eliminata

**Stato finale:** `Classic`, `Premium`, `Fit`, `Frittini`, `Dolci`.

Slug: `classic`, `premium`, `fit`, `frittini`, `dolci`.

Ordinamento filtri nella menu page: manteniamo l'ordine Classic → Premium → Fit → Frittini → Dolci. `get_terms()` in `menu-core.php` viene modificato per ordinare via `term_meta` numerico `menu_order` (valori 10/20/30/40/50), e il seed imposta quel meta al momento della creazione. Fallback: se `menu_order` manca, ordine alfabetico.

### 5) Script seed (`inc/seed/seed-panini.php`)

Responsabilità unica: creare/aggiornare i post `panino` dai dati statici.

Il seed si assicura dello **stato finale atteso**: categorie corrette (crea le 5 nuove, elimina le 3 vecchie), panini di test preesistenti rimossi, 31 post `panino` presenti con i dati attesi. È l'unica sorgente di verità del contenuto iniziale.

**Struttura:**

```php
<?php
// inc/seed/seed-panini.php
// Idempotente. Eseguibile via: wp eval-file inc/seed/seed-panini.php

if ( ! defined('ABSPATH') ) exit;

const IL_PANINO_SEED_DATA = [
    'classic' => [
        ['title' => 'Felsina',         'medium' => 7.00,  'ingredienti' => '...'],
        ['title' => 'Otto Colonne',    'medium' => 7.50,  'ingredienti' => '...'],
        // ...
    ],
    'premium' => [ /* ... */ ],
    'fit'     => [ /* ... */ ],
    'frittini' => [
        ['title' => 'Patate Fritte Dippers', 'medium' => 4.50, 'flat' => true],
        // ...
    ],
    'dolci' => [ /* ... */ ],
];

function il_panino_seed_run(): void {
    il_panino_seed_ensure_categories(); // crea nuove + elimina vecchie
    il_panino_seed_wipe_test_panini();   // elimina i 4 panini di test preesistenti (solo al primo run: gli altri upsert non li toccano)
    foreach (IL_PANINO_SEED_DATA as $cat_slug => $items) {
        foreach ($items as $item) {
            il_panino_seed_upsert($item, $cat_slug);
        }
    }
}

// Funzioni private:
// il_panino_seed_ensure_categories(): crea le 5 nuove categorie con menu_order, cancella Aperitivi/Classici/Speciali.
// il_panino_seed_wipe_test_panini(): wp_delete_post(id, true) sui panini attualmente assegnati
//                                     alle vecchie categorie (Classici/Speciali/Aperitivi). Questo
//                                     pulisce SOLO i dati di test preesistenti senza toccare panini
//                                     aggiunti manualmente dopo il seed.
// il_panino_seed_upsert($item, $cat_slug): get_page_by_title() -> wp_insert_post / wp_update_post,
//                                          update_field('prezzo_medium', ...), calcola large/xxl,
//                                          wp_set_object_terms con slug categoria.
//                                          Log: WP_CLI::log("[created|updated] {$title}").

il_panino_seed_run();
```

**Principi applicati:**
- **SRP**: ogni funzione fa una cosa (categorie, wipe, upsert).
- **DRY**: regola `large = medium + 3`, `xxl = medium + 10` centralizzata in `seed_upsert`.
- **Open/Closed**: aggiungere un panino = aggiungere una riga all'array, nessuna modifica alle funzioni.
- **Idempotenza**: re-esecuzione dello script non duplica post (lookup by title).
- **API-first**: `update_field()` di ACF, `wp_insert_post()`, `wp_set_object_terms()` — nessun SQL diretto. Prepared statements non necessari (WordPress API gestisce escaping).
- **Fail loud**: se ACF non disponibile o CPT non registrato, lo script esce con `WP_CLI::error()`.

### 6) Dati (22 panini + 5 frittini + 4 dolci)

Vedi array `IL_PANINO_SEED_DATA`. Ingredienti normalizzati (scioltimi abbreviazioni tipo "pom.secchi" → "pomodori secchi"). Prezzi:

| Categoria | Panino | Medium | Large (=M+3) | XXL (=M+10) |
|-----------|--------|-------:|-------------:|------------:|
| Classic | Felsina | 7,00 | 10,00 | 17,00 |
| Classic | Otto Colonne | 7,50 | 10,50 | 17,50 |
| Classic | Mazzini | 7,00 | 10,00 | 17,00 |
| Classic | San Vitale | 7,00 | 10,00 | 17,00 |
| Classic | Stalingrado | 7,00 | 10,00 | 17,00 |
| Classic | Dell'Arcoveggio | 7,00 | 10,00 | 17,00 |
| Classic | Rizzoli | 7,00 | 10,00 | 17,00 |
| Classic | Santo Stefano | 7,50 | 10,50 | 17,50 |
| Premium | Emilia Ponente | 9,00 | 12,00 | 19,00 |
| Premium | Volturno | 9,00 | 12,00 | 19,00 |
| Premium | Belle Arti | 8,00 | 11,00 | 18,00 |
| Premium | Delle Moline | 8,00 | 11,00 | 18,00 |
| Premium | Ferrarese | 8,00 | 11,00 | 18,00 |
| Premium | Andrea Costa | 8,00 | 11,00 | 18,00 |
| Premium | Centotrecento | 8,00 | 11,00 | 18,00 |
| Premium | Mascarella | 8,00 | 11,00 | 18,00 |
| Fit | Battisti | 9,50 | 12,50 | 19,50 |
| Fit | Arno | 7,00 | 10,00 | 17,00 |
| Fit | Ruggi | 7,00 | 10,00 | 17,00 |
| Fit | Angelli | 7,00 | 10,00 | 17,00 |
| Fit | Dei Carracci | 6,50 | 9,50 | 16,50 |
| Fit | Azzurra | 6,50 | 9,50 | 16,50 |
| Frittini | Patate Fritte Dippers | 4,50 | — | — |
| Frittini | Fried Cheese Stick | 4,00 | — | — |
| Frittini | Verdurine Pastellate | 4,50 | — | — |
| Frittini | Polpettine di Carne | 5,00 | — | — |
| Frittini | Olive all'Ascolana | 5,00 | — | — |
| Dolci | Tiramisù | 5,50 | — | — |
| Dolci | Delizia al Pistacchio | 5,50 | — | — |
| Dolci | Cheesecake | 5,50 | — | — |
| Dolci | Caramello Salato | 5,50 | — | — |

### Ingredienti (appendice dati seed)

**Classic:**
- Felsina: Mortadella, burrata, granella di pistacchio, rucola
- Otto Colonne: Mortadella, squacquerone, crema di pistacchio, rucola
- Mazzini: Mortadella, scamorza affumicata, melanzane sott'olio
- San Vitale: Salame strolghino, tomino, funghi trifolati, salsa piccante, rucola
- Stalingrado: Prosciutto crudo, mozzarella fior di latte, pomodori secchi, basilico
- Dell'Arcoveggio: Salame Milano, brie, pomodori secchi, carciofi sott'olio
- Rizzoli: Prosciutto cotto, scamorza, insalata, pomodoro, crema tartufata
- Santo Stefano: Prosciutto crudo, burratina, pomodori freschi, rucola

**Premium:**
- Emilia Ponente: Porchetta, pecorino, melanzane grigliate, pomodori, maionese
- Volturno: Porchetta, scamorza affumicata, friarielli, salsa piccante
- Belle Arti: Coppa, scamorza, brie, zucchine e melanzane grigliate, maionese
- Delle Moline: Salame, scamorza affumicata, pomodori secchi, salsa piccante, rucola
- Ferrarese: Spianata piccante, scamorza affumicata, melanzane, tabasco, rucola
- Andrea Costa: Speck, brie, crema di kiwi, rucola
- Centotrecento: Lardo di Colonnata, squacquerone, pomodori secchi
- Mascarella: Capocollo, scamorza affumicata, pomodori secchi, carciofi sott'olio

**Fit:**
- Battisti: Bresaola, scaglie di grana, rucola, pomodori, limone
- Arno: Fesa di tacchino, pecorino, basilico, rucola
- Ruggi: Fesa di tacchino, insalata, uovo sodo, salsa tzatziki
- Angelli: Sgombretto, zucchine grigliate, friarielli, crema di noci
- Dei Carracci: Mozzarella, zucchine grigliate, scaglie di grana, basilico
- Azzurra: Mozzarella, zucchine e melanzane grigliate, rucola

**Frittini e Dolci**: nessun campo `ingredienti` (resta vuoto).

## Data flow

```
WP admin (editor) ──> ACF (prezzo_medium/large/xxl) ──> meta table
                                                               │
                                                               v
template-menu.php ──> components/menu-core.php ──> get_field() ──> $has_sizes ──> card HTML
                                                                      │
                                                                      └──> SCSS compila a style.css via scss-watcher container
```

Seed flow:
```
wp eval-file inc/seed/seed-panini.php
   │
   ├──> il_panino_seed_ensure_categories() ──> wp_insert_term / wp_delete_term
   ├──> [opt] il_panino_seed_wipe() ──> wp_delete_post
   └──> foreach item ──> il_panino_seed_upsert() ──> wp_insert_post + update_field + wp_set_object_terms
```

## Error handling

- Seed: se CPT `panino` non registrato → `WP_CLI::error()` ed exit 1.
- Seed: se ACF non attivo → `WP_CLI::error()` (ACF è dipendenza hard del tema).
- Seed: se un `wp_insert_post()` ritorna `WP_Error` → log come errore e prosegui con gli altri (non block).
- Template: se `prezzo_medium` è vuoto (dato sporco) → non renderizza la sezione sizes ma non crasha. La card mostra solo titolo + ingredienti.

## Testing

- **Manuale**: visita `/menu` dopo il seed. Verifica: 5 filtri categoria visibili, 22 panini con 3 righe prezzo, 9 voci flat (frittini/dolci) con una sola riga prezzo, stile coerente con card attuale.
- **Seed idempotente**: rilanciare `wp eval-file inc/seed/seed-panini.php` due volte — il secondo run logga solo `[updated]`, nessun duplicato. Verifica query `SELECT COUNT(*) FROM wp_posts WHERE post_type='panino' AND post_status='publish'` → deve dare 31 (22+5+4) entrambe le volte.
- **Non-distruttività del seed**: aggiungere un nuovo `panino` manualmente da WP admin (in una delle 5 categorie nuove) e rilanciare il seed — il panino manuale **deve sopravvivere**. Il seed tocca solo i titoli elencati nei dati e i panini delle vecchie categorie legacy.
- **Responsive**: la griglia è già responsive (1200/992/576 breakpoint). Verifico che le 3 righe prezzo non escano dalla card su mobile.

## Principi di design rispettati

- **SRP**: template/SCSS/seed separati, ognuno con responsabilità unica. La logica "ha sizes?" è un booleano calcolato una volta.
- **OCP**: aggiungere una categoria o un panino = modifica dati, non codice.
- **DRY**: formatter prezzo (`$fmt`) riusato per tutte le righe. Regola "large=+3, xxl=+10" centralizzata nel seed.
- **Escape/safety**: `esc_html()`, `esc_attr()`, `esc_url()` per ogni output; `wp_kses` non serve perché non accettiamo HTML utente.
- **API-first**: nessun SQL diretto; si usano `wp_insert_post`, `update_field`, `wp_set_object_terms`, `get_terms`.
- **Nessuna accoppiamento**: la card non dipende dalla categoria per decidere cosa mostrare — decide in base ai dati (`$has_sizes`). Frittini e dolci "sono panini senza size" per il template, il che è più robusto di un branch per category slug.

## Passi implementativi (alto livello — il plan dettagliato verrà scritto dopo)

1. Modifica `inc/acf/panino-menu.php`: rimuovi vecchi campi, aggiungi i 3 nuovi.
2. Aggiorna `components/menu-core.php` con il nuovo markup card.
3. Aggiorna `_menu-core.scss`: rimuovi classi vecchie, aggiungi `.c-menu-card__sizes` e figli.
4. Scrivi `inc/seed/seed-panini.php` con i dati completi.
5. Esegui `wp eval-file inc/seed/seed-panini.php` (container `wp_app`).
6. Verifica visuale a `http://localhost:8080/menu` con Playwright.
7. Commit.
