# Panino Size Variants Implementation Plan

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Ogni `panino` espone 3 size (Medium/Large/XXL) nella card del menu; frittini e dolci sono categorie dello stesso CPT con prezzo flat; 31 voci (22 panini + 5 frittini + 4 dolci) vengono popolate via script seed idempotente.

**Architecture:** Schema ACF modificato (3 campi prezzo), template menu-core aggiornato con rendering condizionale (flat vs 3-size), SCSS riorganizzato su nuove classi BEM, seed script invocato via WP-CLI che è l'unica fonte di verità del contenuto iniziale. Categorie ristrutturate a 5 slug finali (classic/premium/fit/frittini/dolci) con `menu_order` per ordinamento.

**Tech Stack:** WordPress 6.x, ACF Pro, PHP 8.x, SCSS (compilato nel container `wp_scss_watcher`), WP-CLI (via `docker exec wp_app wp ...`).

**Spec di riferimento:** `docs/superpowers/specs/2026-04-17-panino-size-variants-design.md` — consultare per dati ingredienti e prezzi completi.

---

## Convenzioni

- Tutti i percorsi sono **assoluti dalla root del progetto**: `/Users/mattiafilosa/projects/mattiafilosa/il-panino/`.
- Il tema vive in: `wp-content/themes/il-panino-theme/`.
- Il container WordPress è `wp_app`, il DB è `wp_db`. WP-CLI si esegue così:
  ```
  docker exec wp_app wp <comando> --allow-root
  ```
- **Testing**: questo progetto non ha una test suite PHP. La verifica è manuale via browser (`http://localhost:8080/menu`) + query DB + WP-CLI. Trattiamo ogni task con un "acceptance check" esplicito al posto di unit test.
- **Commit**: dopo ogni task, commit con messaggio convenzionale. Co-author footer:
  ```
  Co-Authored-By: Claude Opus 4.7 (1M context) <noreply@anthropic.com>
  ```

---

## File Structure

**Modificati:**
- `wp-content/themes/il-panino-theme/inc/acf/panino-menu.php` — schema ACF (Task 1)
- `wp-content/themes/il-panino-theme/components/menu-core.php` — template card (Task 2)
- `wp-content/themes/il-panino-theme/assets/scss/components/_menu-core.scss` — stili card (Task 3)
- `wp-content/themes/il-panino-theme/functions.php` — aggiunta require del seed (Task 4)

**Creati:**
- `wp-content/themes/il-panino-theme/inc/seed/seed-panini.php` — script seed (Task 4)

**Invariati:** product-slider, functions core, altri ACF.

---

## Task 1: Schema ACF — 3 campi size

**Files:**
- Modify: `wp-content/themes/il-panino-theme/inc/acf/panino-menu.php` (sostituisci interamente)

- [ ] **Step 1: Sostituisci il contenuto di `panino-menu.php`**

Contenuto completo del file (rimuove `prezzo`, `prezzo_menu`, `descrizione_menu`; aggiunge `prezzo_medium`, `prezzo_large`, `prezzo_xxl`):

```php
<?php
/**
 * Register ACF fields for Panino CPT - Menu Page Fields
 */
if ( function_exists('acf_add_local_field_group') ) :

acf_add_local_field_group(array(
    'key' => 'group_panino_menu_fields',
    'title' => 'Dettagli Menù Panino',
    'fields' => array(
        array(
            'key' => 'field_panino_prezzo_medium',
            'label' => 'Prezzo Medium',
            'name' => 'prezzo_medium',
            'type' => 'number',
            'instructions' => 'Prezzo size Medium (per frittini/dolci: prezzo unico)',
            'required' => 1,
            'wrapper' => array('width' => '33'),
            'default_value' => '',
            'placeholder' => '7.00',
            'prepend' => '€',
            'min' => 0,
            'step' => '0.10',
        ),
        array(
            'key' => 'field_panino_prezzo_large',
            'label' => 'Prezzo Large',
            'name' => 'prezzo_large',
            'type' => 'number',
            'instructions' => 'Prezzo size Large. Lasciare vuoto per voci flat (frittini/dolci).',
            'required' => 0,
            'wrapper' => array('width' => '33'),
            'default_value' => '',
            'placeholder' => '10.00',
            'prepend' => '€',
            'min' => 0,
            'step' => '0.10',
        ),
        array(
            'key' => 'field_panino_prezzo_xxl',
            'label' => 'Prezzo XXL',
            'name' => 'prezzo_xxl',
            'type' => 'number',
            'instructions' => 'Prezzo size XXL. Lasciare vuoto per voci flat (frittini/dolci).',
            'required' => 0,
            'wrapper' => array('width' => '34'),
            'default_value' => '',
            'placeholder' => '17.00',
            'prepend' => '€',
            'min' => 0,
            'step' => '0.10',
        ),
        array(
            'key' => 'field_panino_ingredienti',
            'label' => 'Ingredienti',
            'name' => 'ingredienti',
            'type' => 'textarea',
            'instructions' => 'Lista degli ingredienti',
            'required' => 0,
            'wrapper' => array('width' => '100'),
            'default_value' => '',
            'placeholder' => 'Mortadella, burrata, granella di pistacchio, rucola',
            'rows' => 2,
            'new_lines' => 'br',
        ),
        array(
            'key' => 'field_panino_allergeni',
            'label' => 'Allergeni',
            'name' => 'allergeni',
            'type' => 'textarea',
            'instructions' => 'Lista degli allergeni',
            'required' => 0,
            'wrapper' => array('width' => '100'),
            'default_value' => '',
            'placeholder' => 'Glutine (grano), Latte',
            'rows' => 2,
            'new_lines' => 'br',
        ),
    ),
    'location' => array(
        array(
            array(
                'param' => 'post_type',
                'operator' => '==',
                'value' => 'panino',
            ),
        ),
    ),
    'menu_order' => 1,
    'position' => 'normal',
    'style' => 'default',
    'label_placement' => 'top',
    'instruction_placement' => 'label',
    'hide_on_screen' => '',
    'active' => true,
    'description' => 'Campi prezzo per size + ingredienti.',
    'show_in_rest' => 1,
));

endif;
```

- [ ] **Step 2: Acceptance check**

Nel WP admin (`http://localhost:8080/wp-admin/edit.php?post_type=panino`), aprire un panino esistente. Verificare:
- Sono presenti 3 campi numerici: `Prezzo Medium`, `Prezzo Large`, `Prezzo XXL` (tutti con prepend `€`).
- Non compaiono più `Prezzo`, `Prezzo Menù`, `Descrizione Menù`.
- `Ingredienti` e `Allergeni` sono ancora presenti.

**Expected:** la UI mostra solo i 3 nuovi campi prezzo + ingredienti + allergeni. Nessun errore PHP nel log del container (`docker logs wp_app --tail 50`).

- [ ] **Step 3: Commit**

```bash
git add wp-content/themes/il-panino-theme/inc/acf/panino-menu.php
git commit -m "$(cat <<'EOF'
feat(acf): replace single price with 3 size variants (medium/large/xxl)

Removes legacy prezzo/prezzo_menu/descrizione_menu fields.

Co-Authored-By: Claude Opus 4.7 (1M context) <noreply@anthropic.com>
EOF
)"
```

---

## Task 2: Template card — rendering condizionale

**Files:**
- Modify: `wp-content/themes/il-panino-theme/components/menu-core.php` (sostituisci interamente)

- [ ] **Step 1: Sostituisci il contenuto di `menu-core.php`**

```php
<?php
/**
 * Component: Menu Core
 * Grid di prodotti con filtro per categoria.
 *
 * Ordinamento categorie: via term_meta 'menu_order' (numerico crescente),
 * fallback alfabetico se il meta non è valorizzato.
 */

$categorie = get_terms(array(
    'taxonomy'   => 'categoria_panino',
    'hide_empty' => true,
    'meta_key'   => 'menu_order',
    'orderby'    => 'meta_value_num name',
    'order'      => 'ASC',
));

$panini_query = new WP_Query(array(
    'post_type'      => 'panino',
    'posts_per_page' => -1,
    'orderby'        => 'title',
    'order'          => 'ASC',
));

if ( ! $panini_query->have_posts() ) return;

$fmt_price = static function ($value) {
    return number_format((float) $value, 2, ',', '.');
};
?>

<?php $spacing = il_panino_get_spacing_classes('menu_core'); ?>
<section class="c-menu-core <?php echo esc_attr($spacing); ?>">
    <div class="container">

        <?php if ( ! empty($categorie) && ! is_wp_error($categorie) ) : ?>
            <div class="c-menu-core__filters" role="tablist" aria-label="Filtra per categoria">
                <button class="c-menu-core__filter is-active js-menu-filter" data-category="all" role="tab" aria-selected="true">
                    Tutti
                </button>
                <?php foreach ($categorie as $cat) : ?>
                    <button class="c-menu-core__filter js-menu-filter" data-category="<?php echo esc_attr($cat->slug); ?>" role="tab" aria-selected="false">
                        <?php echo esc_html($cat->name); ?>
                    </button>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <div class="c-menu-core__grid js-menu-grid">
            <?php while ($panini_query->have_posts()) : $panini_query->the_post();

                $img_senza_sfondo = get_field('immagine_panino_senza_sfondo');
                $prezzo_medium    = get_field('prezzo_medium');
                $prezzo_large     = get_field('prezzo_large');
                $prezzo_xxl       = get_field('prezzo_xxl');
                $ingredienti      = get_field('ingredienti');
                $allergeni        = get_field('allergeni');

                $img_url = $img_senza_sfondo ? $img_senza_sfondo['url'] : get_the_post_thumbnail_url(get_the_ID(), 'large');
                $img_alt = $img_senza_sfondo ? $img_senza_sfondo['alt'] : get_the_title();

                $has_sizes = ! empty($prezzo_large) && ! empty($prezzo_xxl);

                $terms = get_the_terms(get_the_ID(), 'categoria_panino');
                $cat_slugs = '';
                if ($terms && ! is_wp_error($terms)) {
                    $cat_slugs = implode(' ', wp_list_pluck($terms, 'slug'));
                }
            ?>
                <article class="c-menu-card js-menu-card" data-categories="<?php echo esc_attr($cat_slugs); ?>">

                    <?php if ($img_url) : ?>
                        <div class="c-menu-card__image-wrap">
                            <img src="<?php echo esc_url($img_url); ?>"
                                 alt="<?php echo esc_attr($img_alt); ?>"
                                 class="c-menu-card__image"
                                 loading="lazy">
                        </div>
                    <?php endif; ?>

                    <div class="c-menu-card__body">
                        <h3 class="c-menu-card__name"><?php the_title(); ?></h3>

                        <?php if ($prezzo_medium !== '' && $prezzo_medium !== null) : ?>
                            <div class="c-menu-card__sizes">
                                <?php if ($has_sizes) : ?>
                                    <div class="c-menu-card__size-row">
                                        <span class="c-menu-card__size-label">Medium</span>
                                        <span class="c-menu-card__size-price">&euro;&nbsp;<?php echo esc_html($fmt_price($prezzo_medium)); ?></span>
                                    </div>
                                    <div class="c-menu-card__size-row">
                                        <span class="c-menu-card__size-label">Large</span>
                                        <span class="c-menu-card__size-price">&euro;&nbsp;<?php echo esc_html($fmt_price($prezzo_large)); ?></span>
                                    </div>
                                    <div class="c-menu-card__size-row">
                                        <span class="c-menu-card__size-label">XXL</span>
                                        <span class="c-menu-card__size-price">&euro;&nbsp;<?php echo esc_html($fmt_price($prezzo_xxl)); ?></span>
                                    </div>
                                <?php else : ?>
                                    <div class="c-menu-card__size-row c-menu-card__size-row--flat">
                                        <span class="c-menu-card__size-price">&euro;&nbsp;<?php echo esc_html($fmt_price($prezzo_medium)); ?></span>
                                    </div>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>

                        <hr class="c-menu-card__divider" />

                        <?php if ($ingredienti) : ?>
                            <p class="c-menu-card__ingredienti"><?php echo esc_html($ingredienti); ?></p>
                        <?php endif; ?>

                        <?php if ($allergeni) : ?>
                            <p class="c-menu-card__allergeni">Allergeni: <?php echo esc_html($allergeni); ?></p>
                        <?php endif; ?>
                    </div>

                </article>
            <?php endwhile; ?>
        </div>

    </div>
</section>
<?php wp_reset_postdata(); ?>
```

- [ ] **Step 2: Acceptance check (solo sintassi)**

```
docker exec wp_app php -l /var/www/html/wp-content/themes/il-panino-theme/components/menu-core.php
```

**Expected:** `No syntax errors detected ...`

La verifica visiva completa avverrà nel Task 5 (dopo il seed).

- [ ] **Step 3: Commit**

```bash
git add wp-content/themes/il-panino-theme/components/menu-core.php
git commit -m "$(cat <<'EOF'
feat(menu): render 3 size rows or flat price in menu card

Uses has_sizes boolean derived from data (not category) to decide layout.
Removes obsolete menu section. Category filters now ordered by menu_order term meta.

Co-Authored-By: Claude Opus 4.7 (1M context) <noreply@anthropic.com>
EOF
)"
```

---

## Task 3: SCSS — nuove classi size + rimozione legacy

**Files:**
- Modify: `wp-content/themes/il-panino-theme/assets/scss/components/_menu-core.scss`

- [ ] **Step 1: Sostituisci il blocco `.c-menu-card` (dal commento "// Menu Card" alla fine del file)**

Mantieni la sezione `.c-menu-core { ... }` (righe 6-59) invariata. Sostituisci **tutto da riga 61 in poi** con:

```scss
// Menu Card
.c-menu-card {
    background-color: var(--color-bg-header);
    border-radius: 16px;
    overflow: hidden;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);

    &:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.12);
    }

    &.is-hidden {
        display: none;
    }

    &__image-wrap {
        background-color: var(--color-primary);
        border-radius: 12px;
        margin: 0.75rem;
        overflow: hidden;
        aspect-ratio: 4 / 3;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    &__image {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.4s ease;

        .c-menu-card:hover & {
            transform: scale(1.05);
        }
    }

    &__body {
        padding: 1.25rem 1.25rem 1.5rem;
    }

    &__name {
        font-family: var(--font-heading);
        font-size: 1.8rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: var(--color-text-dark);
        margin: 0 0 0.75rem;
        line-height: 1.15;
    }

    &__sizes {
        display: flex;
        flex-direction: column;
        gap: 0.35rem;
        margin: 0 0 0.75rem;
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

    &__ingredienti {
        font-family: var(--font-body);
        font-size: 0.9rem;
        color: var(--color-text-dark);
        line-height: 1.5;
        margin: 0 0 0.5rem;
    }

    &__allergeni {
        font-family: var(--font-body);
        font-size: 0.85rem;
        color: var(--color-text-dark);
        opacity: 0.65;
        line-height: 1.4;
        margin: 0;
        font-style: italic;
    }
}
```

- [ ] **Step 2: Verifica compilazione SCSS**

Il container `wp_scss_watcher` compila in automatico. Verifica che la compilazione abbia prodotto CSS valido:

```
docker logs wp_scss_watcher --tail 30
```

**Expected:** log mostra compilazione andata a buon fine, nessun errore. `style.css` del tema aggiornato (controlla con `ls -la wp-content/themes/il-panino-theme/style.css`).

- [ ] **Step 3: Commit**

```bash
git add wp-content/themes/il-panino-theme/assets/scss/components/_menu-core.scss wp-content/themes/il-panino-theme/style.css
git commit -m "$(cat <<'EOF'
style(menu-card): replace price row + menu-info with size rows + divider

Introduces .c-menu-card__sizes, __size-row, __size-label, __size-price, __divider.
Removes legacy .c-menu-card__row, __name--menu, __menu-info* classes.

Co-Authored-By: Claude Opus 4.7 (1M context) <noreply@anthropic.com>
EOF
)"
```

---

## Task 4: Script seed — popolamento idempotente

**Files:**
- Create: `wp-content/themes/il-panino-theme/inc/seed/seed-panini.php`
- Modify: `wp-content/themes/il-panino-theme/functions.php` (nessuna modifica richiesta — il seed non viene auto-caricato, si esegue on-demand via `wp eval-file`)

- [ ] **Step 1: Crea la directory e il file seed**

Crea `wp-content/themes/il-panino-theme/inc/seed/seed-panini.php` con **esattamente** questo contenuto:

```php
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

    il_panino_seed_ensure_categories();
    il_panino_seed_wipe_legacy_panini();

    foreach ( il_panino_seed_data() as $cat_slug => $items ) {
        foreach ( $items as $item ) {
            il_panino_seed_upsert($item, $cat_slug);
        }
    }

    il_panino_seed_log('[seed done]');
}

il_panino_seed_run();
```

- [ ] **Step 2: Verifica sintassi**

```
docker exec wp_app php -l /var/www/html/wp-content/themes/il-panino-theme/inc/seed/seed-panini.php
```

**Expected:** `No syntax errors detected ...`

- [ ] **Step 3: Commit**

```bash
git add wp-content/themes/il-panino-theme/inc/seed/seed-panini.php
git commit -m "$(cat <<'EOF'
feat(seed): add idempotent seed script for panini CPT

Populates 22 panini + 5 frittini + 4 dolci with 3-size pricing rule
(large = medium + 3, xxl = medium + 10). Manages 5-category taxonomy
and removes legacy categories. Non-destructive for manually-added panini.

Co-Authored-By: Claude Opus 4.7 (1M context) <noreply@anthropic.com>
EOF
)"
```

---

## Task 5: Esecuzione seed + verifica end-to-end

**Files:** nessuna modifica ai file del tema, solo esecuzione DB.

- [ ] **Step 1: Esegui il seed**

```
docker exec wp_app wp eval-file /var/www/html/wp-content/themes/il-panino-theme/inc/seed/seed-panini.php --allow-root
```

**Expected output (sintesi):**
- Righe `[category created]` o `[category ok]` per Classic/Premium/Fit/Frittini/Dolci
- Righe `[category removed]` per classici/speciali/aperitivi (se esistevano)
- Righe `[panino wiped]` per i 4 panini di test nelle vecchie categorie
- 31 righe `[panino created]` (prima esecuzione)
- Riga finale `[seed done]`
- Exit code 0

- [ ] **Step 2: Verifica count nel DB**

```
docker exec wp_db mysql -uwordpress -pwordpress wordpress -e "SELECT COUNT(*) AS total FROM wp_posts WHERE post_type='panino' AND post_status='publish';"
```

**Expected:** `total = 31`

```
docker exec wp_db mysql -uwordpress -pwordpress wordpress -e "SELECT t.slug, COUNT(tr.object_id) AS n FROM wp_terms t JOIN wp_term_taxonomy tt ON t.term_id=tt.term_id LEFT JOIN wp_term_relationships tr ON tt.term_taxonomy_id=tr.term_taxonomy_id WHERE tt.taxonomy='categoria_panino' GROUP BY t.slug ORDER BY t.slug;"
```

**Expected distribuzione:**
- `classic`: 8
- `premium`: 8
- `fit`: 6
- `frittini`: 5
- `dolci`: 4
- totale: 31, nessuna riga per `classici`/`speciali`/`aperitivi`.

- [ ] **Step 3: Verifica idempotenza (2° run)**

Rilancia lo stesso comando del Step 1. L'output deve mostrare `[panino updated]` (non `created`) per tutti e 31, categorie `[category ok]`. Il count rimane 31.

- [ ] **Step 4: Verifica visiva nel browser**

Apri `http://localhost:8080/menu` in browser.

**Expected visuale:**
- Filtri categoria visibili nell'ordine: Tutti, Classic, Premium, Fit, Frittini, Dolci.
- 22 card panino con 3 righe prezzo (Medium/Large/XXL) a destra, allineate verticalmente.
- 9 card (5 frittini + 4 dolci) con un'unica riga prezzo allineata a destra.
- Divider sottile tra prezzo e ingredienti.
- Nessun errore console JS. Nessuna referenza a "Menù" residua.

Se hai accesso a Playwright MCP, screenshot a `http://localhost:8080/menu`:

```
browser_navigate → http://localhost:8080/menu
browser_take_screenshot
```

- [ ] **Step 5: Commit (solo se ci sono stati cambiamenti — altrimenti skip)**

```bash
git status
```

Se il working tree è pulito (probabile, perché il seed modifica solo il DB), skip questo commit. Altrimenti committa eventuali fix emersi dalla verifica.

---

## Task 6: Cleanup finale

**Files:** nessuno — task di verifica finale.

- [ ] **Step 1: Verifica nessun reference rotto**

Cerca reference residui ai vecchi campi ACF:

```
grep -rn "prezzo_menu\|descrizione_menu\|get_field('prezzo')" wp-content/themes/il-panino-theme/ --include="*.php"
```

**Expected:** **zero match**. Se ne trovi, sistema (sostituisci con logica equivalente usando i nuovi campi, o rimuovi se il blocco è obsoleto) e committa.

- [ ] **Step 2: Verifica nessuna classe SCSS residua usata ancora**

```
grep -rn "c-menu-card__row\|c-menu-card__name--menu\|c-menu-card__menu-info" wp-content/themes/il-panino-theme/ --include="*.php" --include="*.scss"
```

**Expected:** zero match.

- [ ] **Step 3: Log del container WP — nessun PHP notice/warning**

```
docker logs wp_app --tail 100 | grep -iE "warning|error|notice" | grep -v "^$"
```

**Expected:** nessun output relativo a `menu-core.php`, `seed-panini.php`, o `panino-menu.php`.

- [ ] **Step 4: Commit finale di cleanup (se serve)**

Se sono emerse correzioni dai Step 1-3, committa:

```bash
git add -u
git commit -m "$(cat <<'EOF'
chore: cleanup legacy references after size variants migration

Co-Authored-By: Claude Opus 4.7 (1M context) <noreply@anthropic.com>
EOF
)"
```

Altrimenti skip.

---

## Definition of Done

Tutti questi punti devono essere verificati prima di considerare completato il plan:

- [ ] `panino-menu.php` espone solo i 3 campi prezzo size + ingredienti + allergeni nell'admin WP.
- [ ] `components/menu-core.php` rende 3 righe prezzo per panini e 1 riga prezzo flat per frittini/dolci.
- [ ] `_menu-core.scss` usa le nuove classi e compila senza errori; `style.css` aggiornato.
- [ ] `inc/seed/seed-panini.php` esiste, esegue senza errori, è idempotente (2 run = stesso stato).
- [ ] DB contiene 31 panini distribuiti nelle 5 nuove categorie (8/8/6/5/4); categorie legacy eliminate.
- [ ] `/menu` in browser mostra filtri ordinati Classic → Premium → Fit → Frittini → Dolci, layout card coerente con spec.
- [ ] Nessun grep hit su `prezzo_menu`, `descrizione_menu`, classi SCSS legacy.
- [ ] Nessun error/warning PHP nel log di `wp_app` riconducibile ai file toccati.
- [ ] Tutti i commit hanno il footer `Co-Authored-By: Claude Opus 4.7 (1M context) <noreply@anthropic.com>`.
