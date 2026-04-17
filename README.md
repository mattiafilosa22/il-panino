# Il Panino Bologna - Custom WordPress Theme

Questo repository contiene l'ambiente Docker e il tema custom sviluppato per **Il Panino Bologna**.

## Requisiti
- Docker e Docker Compose

## Come Avviare il Progetto

Il progetto è interamente dockerizzato. Per avviare il database (MariaDB), WordPress, Redis (per il caching) e il compilatore SCSS (Node.js), esegui semplicemente:

```bash
docker-compose up -d --build
```

Al termine dell'avvio:
- Il sito sarà disponibile all'indirizzo `http://localhost:8080`.
- Potrebbe volerci qualche istante in più la prima volta per scaricare le immagini e inizializzare il DB.
- È incluso un container (`wp_scss_watcher`) che si occupa di compilare gli stili in tempo reale.

## Setup post-bootstrap

### wp-cli
L'immagine `wordpress:latest` include già `wp-cli` (binario `/usr/local/bin/wp`). Per eseguirlo, usa `docker exec` con `--allow-root` perché il container gira come root:

```bash
docker exec wp_app wp --info --allow-root
```

Se nei prossimi pin di immagine WordPress viene rimosso wp-cli, installalo manualmente una sola volta:

```bash
docker exec wp_app bash -c "curl -sO https://raw.githubusercontent.com/wp-cli/builds/gh-pages/phar/wp-cli.phar && chmod +x wp-cli.phar && mv wp-cli.phar /usr/local/bin/wp"
```

### Permalink pretty
Alla prima installazione la struttura permalink è "plain" (`/?page_id=N`) e le URL come `/menu/` rispondono 404. Configura i permalink e rigenera `.htaccess`:

```bash
docker exec wp_app wp rewrite structure '/%postname%/' --hard --allow-root
docker exec wp_app wp rewrite flush --hard --allow-root
```

Se Apache non riesce a scrivere `.htaccess` (warning "Regenerating a .htaccess file requires special configuration") crealo una volta a mano con le regole WordPress standard:

```bash
docker exec wp_app bash -c 'cat > /var/www/html/.htaccess <<EOF
# BEGIN WordPress
<IfModule mod_rewrite.c>
RewriteEngine On
RewriteBase /
RewriteRule ^index\.php$ - [L]
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule . /index.php [L]
</IfModule>
# END WordPress
EOF
chown www-data:www-data /var/www/html/.htaccess'
```

Verifica: `curl -sI http://localhost:8080/menu/` → `HTTP/1.1 200 OK`.

### Seed dei panini
Popola/aggiorna in modo idempotente le categorie e i prodotti del CPT `panino`:

```bash
docker exec wp_app wp eval-file /var/www/html/wp-content/themes/il-panino-theme/inc/seed/seed-panini.php --allow-root
```

Lo script cancella i panini legacy (categorie `classici`/`speciali`/`aperitivi`), rigenera le 5 categorie correnti (Classic/Premium/Fit/Frittini/Dolci) e fa upsert dei 31 panini definiti nel file `inc/seed/seed-panini.php`.

## Struttura del Tema

Il tema (`wp-content/themes/il-panino-theme`) è stato strutturato per essere modulare e facile da mantenere.

### Componenti (PHP)
I file di design sono stati scorporati dal template principale `template-homepage.php` per riutilizzabilità.
- `components/hero-banner.php`: La sezione iniziale della homepage.
- `components/header.php`: L'intestazione del sito con navigazione mobile/desktop.

### Advanced Custom Fields (ACF)
Per evitare un `functions.php` confusionario, i campi ACF creati o da creare sono stati suddivisi per componente.
I file si trovano nella cartella `inc/acf/` (es. `hero-banner.php`). Per registrarne di nuovi, ti basta aggiungere il nome del file all'array `$acf_components` dentro `functions.php`.

### Stili (SCSS)
Gli stili non sono più scritti direttamente in un file `style.css` globale, ma divisi logicamente per il preprocessing Sass:
```
assets/scss/
├── base/        # Reset e tag html root (_reset.scss)
├── components/  # Moduli dell'interfaccia (_header.scss, _hero-banner.scss, _buttons.scss)
├── utils/       # Variabili globali del tema (_variables.scss)
└── style.scss   # File di raccolta che importa tutti i "partials"
```

Grazie al container Docker per SCSS (`wp_scss_watcher`), ogni volta che salvi una modifica a un file all'interno di `assets/scss/`, il compilatore rigenererà istantaneamente il file sorgente `style.css` all'interno della cartella principale del tema. Non devi far girare nessun comando manualmente mentre sviluppi, a meno che tu non lo voglia compilare manualmente!

Se per qualche motivo vuoi generarlo senza Docker, dal terminale locale:
```bash
cd wp-content/themes/il-panino-theme
npm run build:scss  # Per compilare minificato per produzione
# oppure
npm run watch:scss  # Per avviare il processo di watch in locale
```
