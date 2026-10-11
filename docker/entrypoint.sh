#!/bin/sh
set -e

# Render indica el puerto en la variable PORT
PORT="${PORT:-10000}"
sed -i "s/^Listen .*/Listen ${PORT}/" /etc/apache2/ports.conf
sed -i "s/<VirtualHost \*:[0-9]*>/<VirtualHost *:${PORT}>/" /etc/apache2/sites-available/000-default.conf

# Si no se configuró APP_KEY, se genera una para este arranque
if [ -z "$APP_KEY" ]; then
    export APP_KEY="base64:$(head -c 32 /dev/urandom | base64)"
fi

# Base de datos SQLite con los datos de prueba
touch database/database.sqlite
php artisan migrate:fresh --seed --force
chown -R www-data:www-data database storage

php artisan config:cache
php artisan route:cache
php artisan view:cache

exec apache2-foreground
