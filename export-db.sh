#!/bin/bash

# Definisci i nomi e le credenziali basate sul docker-compose
CONTAINER_NAME="wp_db"
DB_USER="wordpress"
DB_PASS="wordpress"
DB_NAME="wordpress"
EXPORT_PATH="./data/backup-database.sql"

echo "⏳ Inizio esportazione del database '${DB_NAME}' dal container '${CONTAINER_NAME}'..."

# Esegui il dump tramite mysqldump all'interno del container
docker exec $CONTAINER_NAME mysqldump -u $DB_USER -p$DB_PASS $DB_NAME > $EXPORT_PATH

if [ $? -eq 0 ]; then
    echo "✅ Esportazione completata con successo!"
    echo "📁 File salvato in: $EXPORT_PATH"
else
    echo "❌ Errore durante l'esportazione del database."
fi
