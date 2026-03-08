#!/bin/bash

CONTAINER_NAME="wp_db"
DB_USER="wordpress"
DB_PASS="wordpress"
DB_NAME="wordpress"
IMPORT_PATH="./data/backup-database.sql"

if [ ! -f "$IMPORT_PATH" ]; then
    echo "❌ Errore: Il file $IMPORT_PATH non esiste!"
    exit 1
fi

echo "⏳ Inizio importazione del database '${DB_NAME}' nel container '${CONTAINER_NAME}'..."

# Esegui il ripristino leggendo dal file e passando a mysql
cat $IMPORT_PATH | docker exec -i $CONTAINER_NAME mysql -u $DB_USER -p$DB_PASS $DB_NAME

if [ $? -eq 0 ]; then
    echo "✅ Importazione completata con successo!"
else
    echo "❌ Errore durante l'importazione del database."
fi
