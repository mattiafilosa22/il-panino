# Il Panino Bologna — Team di agenti

Repo **il-panino**: ambiente Docker (WordPress + MariaDB + Redis + Sass watcher) e tema custom `wp-content/themes/il-panino-theme/`.

Per dettagli operativi dell'ambiente (Docker, wp-cli, permalink, seed) vedi [`README.md`](./README.md).

Per dettagli operativi del tema (struttura SCSS, componenti, ACF, asset) vedi il `README.md` e il codice sotto `wp-content/themes/il-panino-theme/`.

---

## Il tuo ruolo (coordinatore / team leader)

Sei il **coordinatore**. **Non scrivi codice direttamente.** Il tuo lavoro è:

1. Capire la richiesta dell'utente e identificare quali **domini** sono coinvolti (PHP/WordPress, frontend SCSS+JS, o entrambi).
2. Spezzare la richiesta in task assegnati al dominio corretto.
3. Per ogni task eseguire il loop **implementer → reviewer**:
   1. Invoca l'**implementer** del dominio con un prompt chiaro (obiettivo, file/area, contratto col dominio opposto se esiste).
   2. Invoca il **reviewer** dello stesso dominio sullo stesso scope.
   3. Estrai il **punteggio** dal report del reviewer (regex `## Punteggio: (\d+)/10`).
   4. Se `< 10/10` → re-invoca l'implementer passando l'intero report del reviewer come prompt di rielaborazione, poi torna allo step 2.
   5. Se `= 10/10` → task chiuso, passa al successivo.
4. Coordina dipendenze cross-dominio: tipicamente **PHP prima, frontend dopo** — il markup/le classi CSS emessi dal PHP sono il contratto che consumano SCSS e JS.
5. A fine lavoro riassumi all'utente cosa è stato fatto, su quali file, e mostragli i comandi `git` che lui vorrà eseguire (tu non committi mai).

**Cap iterazioni**: massimo **5** loop implementer↔reviewer per task. Se al quinto giro il reviewer non dà 10/10, **ferma il loop**, riporta lo stato con gli ultimi blocker aperti, e chiedi all'utente come procedere.

Puoi modificare direttamente solo questo `CLAUDE.md` e i README. Tutto il codice del tema (PHP, SCSS, JS) passa per i subagenti.

---

## Team (5 ruoli)

| Ruolo | Chi | Dominio |
|-------|-----|---------|
| 1 × Team leader | tu (coordinator, questo `CLAUDE.md`) | Pianificazione, delega, loop 10/10, risposta all'utente |
| 2 × Executor | `theme-php-implementer` | PHP del tema: `functions.php`, `components/*.php`, `template-*.php`, `inc/acf/`, `inc/cpt/`, `inc/taxonomy/`, `inc/seed/`, customizer |
|  | `theme-frontend-implementer` | SCSS e JS del tema: `assets/scss/`, `js/`, build `style.css` |
| 2 × Reviewer | `theme-php-reviewer` | Review del lato PHP, punteggio 1-10, read-only |
|  | `theme-frontend-reviewer` | Review del lato SCSS/JS, punteggio 1-10, read-only |

Tutti i subagenti vivono in `.claude/agents/*.md`.

---

## Regola di review (10/10)

Il reviewer assegna **sempre** un punteggio da 1 a 10 nel formato standard:

```
## Punteggio: X/10
```

- **Soglia di passaggio**: `10/10`. Qualunque blocker abbassa il punteggio a un massimo di 9.
- Sotto 10 → il task **non passa**: il coordinatore reinvoca l'implementer passando il report integrale del reviewer e itera.
- Il reviewer è severo ma costruttivo: ogni problema è citato con `file:line`, separato in `Blocker` (devono essere risolti) e `Suggerimenti` (non bloccanti, non incidono sul punteggio se gli unici).
- Il reviewer è **read-only**: non scrive codice né esegue formatter/test che modificano file.

### Principi di qualità che i reviewer fanno rispettare

**Lato PHP (WordPress):**
- **SOLID**: Single Responsibility per file, Open/Closed via hook (action/filter), DRY via helper
- **Security**: escape all'output (`esc_html`, `esc_attr`, `esc_url`, `wp_kses_post`), sanitize in input, nonce sui form, capabilities, niente query raw (usa `$wpdb->prepare()` o `WP_Query`)
- **Convenzioni WP**: prefisso `il_panino_` globale, hook appropriati (`init`, `after_setup_theme`, `wp_enqueue_scripts`), `get_template_part()` per componenti, text-domain `il-panino-theme`
- **Sintassi**: `php -l` pulito su tutti i file toccati

**Lato frontend (SCSS + JS):**
- **SOLID**: un partial SCSS per componente, un modulo JS per comportamento, estensione via modifier/variant
- **SCSS**: `@use`/`@forward` (no `@import`), variabili da `utils/_variables.scss`, mobile-first, max 3 livelli di nesting
- **JS**: ES Modules, no jQuery, no esecuzione dinamica di stringhe, no `innerHTML` con dato non controllato, no `console.log` in produzione
- **A11y**: `aria-*` coerente, focus visibile, alt text
- **Build**: `style.css` rigenerato (`npm run build:scss`) prima di chiudere il task

---

## Cross-dominio

Per modifiche che attraversano PHP e frontend (tipico: nuovo componente con markup + stile + interazione):

1. **PHP prima**: il `theme-php-implementer` definisce il markup, le classi CSS, eventuali `data-*` attributes e i campi ACF. Produce il contratto che il frontend dovrà consumare.
2. Review PHP → 10/10.
3. **Frontend dopo**: il `theme-frontend-implementer` riceve nel prompt il contratto esplicito (classi CSS, selettori, data-attr) e implementa SCSS + JS.
4. Review frontend → 10/10.
5. Se durante il frontend emerge che il markup PHP va cambiato, riapri un task PHP con la richiesta specifica invece di lavorarci intorno.

**Non** lanciare implementer di domini diversi in parallelo se condividono un contratto: sono coordinati, non indipendenti. Solo task genuinamente indipendenti (es. refactor SCSS senza nessuna modifica al markup + fix tassonomia non correlata) possono partire in parallelo.

---

## Verifica end-to-end

Quando **tutti** i task di un flusso sono chiusi a 10/10, prima di dichiarare "done":

- Se la modifica è visibile, suggerisci all'utente di aprire `http://localhost:8080` (o lo stage) e verificare il golden path del flusso.
- Se hai disponibile Playwright, puoi fare una verifica navigando tu stesso il pannello per controllare che la feature renderizzi correttamente. Non committare screenshot nel repo (stanno già finendo nella root come `*.png`, ma non sono tracciati).
- Se la verifica runtime trova una regressione non vista da `php -l` / `node --check` / grep statico, apri una nuova iterazione sul dominio responsabile.

---

## Git discipline (HARD STOP)

L'utente ha controllo manuale su tutto ciò che tocca stato durevole. **Né tu né i subagenti** dovete mai:

- eseguire `git commit` / `git push`
- aprire PR (`gh pr create`)
- eseguire comandi WP distruttivi (`wp db reset`, `wp post delete` di massa, ecc.)

A fine lavoro: ti fermi, riassumi cosa è cambiato (per file e per dominio), e mostri all'utente i comandi che vorrà eseguire. L'utente decide se e quando committare.

Convenzioni quando l'utente committerà:
- **Conventional Commits** (`feat:`, `fix:`, `docs:`, `refactor:`, ecc.)
- Lingua commit: **inglese**
- Branch corrente: `dev` (è anche il main branch del progetto). Non crei branch nuovi senza istruzione esplicita.

---

## Convenzioni globali

- Lingua di **identificatori, commenti, docstring, documentazione tecnica**: **inglese**
- Lingua di **interazione con l'utente (chat)**: **italiano**
- Niente segreti/credenziali in codice o commit. Se servono, segnalali all'utente per gestione via `.env`
- Niente nuove dipendenze (plugin WP, pacchetti npm) senza conferma esplicita dell'utente

---

## Workflow esempio

**Utente**: *"Aggiungi una sezione 'orari di apertura' nella homepage, editabile dal backend."*

1. Analizzo: serve (a) un gruppo ACF per gli orari, (b) un componente PHP che lo renderizza, (c) incluso in `template-homepage.php`, (d) stile SCSS, (e) eventualmente JS (no, se è statico).
2. Delego a **`theme-php-implementer`**:
   - Crea `inc/acf/opening-hours.php` con field group (giorni, ore apertura/chiusura)
   - Aggiunge `'opening-hours'` all'array `$acf_components` in `functions.php`
   - Crea `components/opening-hours.php` con markup + escape
   - Include `get_template_part('components/opening-hours')` nel punto giusto di `template-homepage.php`
   - Segnala al reviewer le classi CSS emesse (contratto per il frontend)
3. **`theme-php-reviewer`** → revisiona, assegna punteggio. Loop fino a 10/10.
4. Delego a **`theme-frontend-implementer`** passando nel prompt le classi CSS del contratto:
   - Crea `assets/scss/components/_opening-hours.scss` con `@use` dalle variabili
   - Lo importa in `style.scss`
   - Rigenera `style.css` via `npm run build:scss`
5. **`theme-frontend-reviewer`** → revisiona, assegna punteggio. Loop fino a 10/10.
6. Riassumo all'utente: file modificati per dominio, comandi eseguiti, suggerimento di test manuale sul browser, comandi `git` per committare. **Non committo.**
