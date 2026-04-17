# Bestseller + Homepage Slider Implementation Plan

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Sostituire il flag `panino_featured` con `panino_bestseller` e aggiornare la homepage in modo che lo slider mostri il bestseller + 4 random panini (escludendo frittini/dolci).

**Architecture:** Modifica schema ACF, modifica query in `product-slider.php` (tre step: pick bestseller, pick 4 random escludendo bestseller + frittini/dolci, render in ordine).

**Tech Stack:** WordPress 6.9, ACF Pro, PHP 8.x.

**Spec di riferimento:** `docs/superpowers/specs/2026-04-17-bestseller-slider-design.md`.

---

## Convenzioni

- Tutti i percorsi assoluti da `/Users/mattiafilosa/projects/mattiafilosa/il-panino/`.
- WP-CLI: `docker exec wp_app wp <cmd> --allow-root`.
- Footer co-author su ogni commit:
  ```
  Co-Authored-By: Claude Opus 4.7 (1M context) <noreply@anthropic.com>
  ```
- Nessuna modifica SCSS richiesta.

---

## Task 1: Schema ACF — sostituisci `panino_featured` con `panino_bestseller`

**Files:**
- Modify: `wp-content/themes/il-panino-theme/inc/acf/panino.php`

- [ ] **Step 1: Sostituisci il campo `panino_featured` con `panino_bestseller`**

In `inc/acf/panino.php`, trova il blocco (righe 11-22):
```php
array(
    'key' => 'field_panino_featured',
    'label' => 'In evidenza',
    'name' => 'panino_featured',
    'type' => 'true_false',
    'instructions' => 'Attiva per mostrare questo panino nello slider prodotti in homepage.',
    'default_value' => 0,
    'ui' => 1,
    'ui_on_text' => 'Si',
    'ui_off_text' => 'No',
    'wrapper' => array('width' => '100'),
),
```

Sostituiscilo con:

```php
array(
    'key' => 'field_panino_bestseller',
    'label' => 'Best Seller',
    'name' => 'panino_bestseller',
    'type' => 'true_false',
    'instructions' => 'Attiva questa opzione per indicare il panino best seller. Marca UN SOLO panino: se ne trovi più di uno marcato, lo slider homepage mostra in prima posizione quello creato per primo. I panini in categoria Frittini/Dolci vengono ignorati dallo slider anche se marcati.',
    'default_value' => 0,
    'ui' => 1,
    'ui_on_text' => 'Si',
    'ui_off_text' => 'No',
    'wrapper' => array('width' => '100'),
),
```

- [ ] **Step 2: Verifica sintassi**

```
docker exec wp_app php -l /var/www/html/wp-content/themes/il-panino-theme/inc/acf/panino.php
```

**Expected:** `No syntax errors detected ...`

- [ ] **Step 3: Verifica UI admin**

Apri `http://localhost:8080/wp-admin/edit.php?post_type=panino`, clicca su un panino. Verifica:
- Compare il toggle "Best Seller" (on/off) con le istruzioni sul "marca un solo panino".
- Non compare più "In evidenza".

- [ ] **Step 4: Commit**

```bash
git add wp-content/themes/il-panino-theme/inc/acf/panino.php
git commit -m "$(cat <<'EOF'
feat(acf): replace panino_featured with panino_bestseller

Instructions clarify single-panino rule and frittini/dolci exclusion.

Co-Authored-By: Claude Opus 4.7 (1M context) <noreply@anthropic.com>
EOF
)"
```

---

## Task 2: Logica query slider — bestseller + 4 random

**Files:**
- Modify: `wp-content/themes/il-panino-theme/components/product-slider.php`

- [ ] **Step 1: Sostituisci il blocco di query attuale**

In `product-slider.php`, sostituisci le righe 14-25 (il vecchio `$args` + `new WP_Query`) con la nuova logica a tre step.

**Contenuto esatto da inserire al posto del vecchio blocco query** (tra le righe `$sfondo_destra = get_field('slider_sfondo_destra');` e `$label_class = 'c-product-label--bottom-right';`):

```php
// Filter: escludi frittini/dolci dallo slider.
$slider_category_filter = array(
    array(
        'taxonomy' => 'categoria_panino',
        'field'    => 'slug',
        'terms'    => array('frittini', 'dolci'),
        'operator' => 'NOT IN',
    ),
);

// 1) Bestseller (il più vecchio per data di creazione, se più di uno marcato).
$bestseller_q = new WP_Query(array(
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
$bestseller_id = $bestseller_q->posts[0] ?? 0;

// 2) Random: riempi fino a 5 slide totali (4 se c'è bestseller, 5 altrimenti).
$random_target = 5 - count(array_filter(array($bestseller_id)));
$random_q = new WP_Query(array(
    'post_type'      => 'panino',
    'posts_per_page' => $random_target,
    'orderby'        => 'rand',
    'post__not_in'   => array_filter(array($bestseller_id)),
    'tax_query'      => $slider_category_filter,
    'fields'         => 'ids',
    'no_found_rows'  => true,
));
$random_ids = $random_q->posts;

// 3) Ordine finale: bestseller in testa, poi i random.
$slider_ids = array_values(array_filter(array_merge(array($bestseller_id), $random_ids)));

if ( empty($slider_ids) ) {
    return;
}

// Query di render, con ordine preservato.
$panini_query = new WP_Query(array(
    'post_type'      => 'panino',
    'post__in'       => $slider_ids,
    'orderby'        => 'post__in',
    'posts_per_page' => count($slider_ids),
    'no_found_rows'  => true,
));
```

Tutto il resto del file (dalla riga `$label_class = ...` in giù, incluso il while di render) **resta invariato**.

- [ ] **Step 2: Verifica sintassi**

```
docker exec wp_app php -l /var/www/html/wp-content/themes/il-panino-theme/components/product-slider.php
```

**Expected:** `No syntax errors detected ...`

- [ ] **Step 3: Commit**

```bash
git add wp-content/themes/il-panino-theme/components/product-slider.php
git commit -m "$(cat <<'EOF'
feat(slider): show bestseller + 4 random panini, exclude frittini/dolci

Three-step query: pick bestseller (first by date if multiple marked),
pick 4 random excluding the bestseller, render preserving order.
Slider renders nothing if no panini match.

Co-Authored-By: Claude Opus 4.7 (1M context) <noreply@anthropic.com>
EOF
)"
```

---

## Task 3: Marca 1 panino come bestseller per test + verifica end-to-end

**Files:** nessuna modifica ai file del tema.

- [ ] **Step 1: Marca "Otto Colonne" come bestseller via WP-CLI**

```
docker exec wp_app wp eval --allow-root 'foreach ((new WP_Query(array("post_type"=>"panino","title"=>"Otto Colonne","posts_per_page"=>1,"fields"=>"ids")))->posts as $id) { update_field("panino_bestseller", 1, $id); echo "marked: $id\n"; }'
```

**Expected:** `marked: <id>` (un numero). Se nessun output, il panino non esiste — verifica che il seed sia stato eseguito.

- [ ] **Step 2: Verifica slider homepage**

```
curl -s http://localhost:8080/ | grep -oE '<span class="c-product-label__text[^>]*>[^<]*</span>' | head -10
```

**Expected:** 5 span label, il primo deve contenere `Otto Colonne`. I successivi 4 sono nomi random tra i panini Classic/Premium/Fit (NON frittini/dolci come "Tiramisù", "Patate Fritte Dippers", ecc.).

- [ ] **Step 3: Verifica randomness (fai 3 fetch e confronta gli ultimi 4 nomi)**

```
for i in 1 2 3; do echo "--- fetch $i ---"; curl -s http://localhost:8080/ | grep -oE '<span class="c-product-label__text[^>]*>[^<]*</span>' | tail -4; done
```

**Expected:** almeno 2 dei 3 set di "ultimi 4 nomi" devono differire tra loro (caching browser può renderli identici su `curl` senza cookie — OK se 2/3 differiscono).

Se tutti e 3 sono identici: possibile caching server-side da object cache (Redis). Non è un bug, ma segnalalo nel report finale.

- [ ] **Step 4: Verifica esclusione categorie**

Cerca "Tiramisù", "Patate Fritte Dippers", "Fried Cheese Stick" nell'output homepage:

```
curl -s http://localhost:8080/ | grep -iE "tiramis|patate fritte|fried cheese|cheesecake|caramello salato"
```

**Expected:** nessun match. Se trovi match, l'esclusione `NOT IN` non funziona e bisogna debuggare.

- [ ] **Step 5: Edge case — nessun bestseller**

```
docker exec wp_app wp eval --allow-root 'foreach ((new WP_Query(array("post_type"=>"panino","title"=>"Otto Colonne","posts_per_page"=>1,"fields"=>"ids")))->posts as $id) { update_field("panino_bestseller", 0, $id); echo "unmarked: $id\n"; }'
```

Poi:

```
curl -s http://localhost:8080/ | grep -oE '<span class="c-product-label__text[^>]*>[^<]*</span>' | wc -l | tr -d ' '
```

**Expected:** `5` (cinque label, tutti random, nessuno in particolare).

Rimarca Otto Colonne come bestseller alla fine del Step 5:

```
docker exec wp_app wp eval --allow-root 'foreach ((new WP_Query(array("post_type"=>"panino","title"=>"Otto Colonne","posts_per_page"=>1,"fields"=>"ids")))->posts as $id) { update_field("panino_bestseller", 1, $id); echo "remarked: $id\n"; }'
```

- [ ] **Step 6: Commit (se c'è qualcosa da committare; di solito no)**

Questo task è solo verifica. Non produce commit.

---

## Task 4: Cleanup — verifica nessun reference residuo a `panino_featured`

**Files:** nessuna modifica diretta.

- [ ] **Step 1: Grep reference residui**

```
grep -rn "panino_featured" wp-content/themes/il-panino-theme/ --include="*.php"
```

**Expected:** zero match. Se trovi hit, sostituisci/rimuovi e committa come `chore(cleanup): remove residual panino_featured references`.

- [ ] **Step 2: Verifica che la chiave meta `panino_featured` sia droppata dal DB per i panini seed**

```
docker exec wp_db mysql -uwordpress -pwordpress wordpress -e "SELECT post_id, meta_value FROM wp_postmeta WHERE meta_key='panino_featured' LIMIT 10;"
```

**Expected:** 0 righe o solo righe di panini non-seed (l'utente potrebbe averne marcati manualmente in passato). Se l'output include righe con `meta_value='1'`, non è un bug — il campo è semplicemente orfano e verrà ignorato. Solo segnalalo nel report finale.

---

## Definition of Done

- [ ] `inc/acf/panino.php` non contiene più `panino_featured`, contiene `panino_bestseller` con label "Best Seller" e istruzioni corrette.
- [ ] `components/product-slider.php` implementa la logica a 3 step (bestseller → random → render-in-order).
- [ ] Homepage mostra 5 slide: Otto Colonne in posizione 1, 4 panini random Classic/Premium/Fit in posizioni 2-5.
- [ ] Nessun frittino/dolce compare mai nello slider.
- [ ] Randomness verificata: ≥2/3 dei fetch hanno differenze nelle posizioni 2-5.
- [ ] Edge case "nessun bestseller" → slider mostra 5 random, nessuno fissato.
- [ ] Nessun reference residuo a `panino_featured` nel codice del tema.
- [ ] Tutti i commit hanno il footer co-author.
- [ ] Nessun error/warning PHP nel log di `wp_app` per i file toccati.
