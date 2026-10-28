#!/bin/sh
set -e

# Fresh SQLite database on every start (free plan disk is temporary)
if [ ! -f database/database.sqlite ]; then
    touch database/database.sqlite
    FRESH=1
fi

php artisan migrate --force

if [ "$FRESH" = "1" ]; then
    php artisan db:seed --force
fi

# Cache config, routes and views for speed
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Let Apache write to the database, logs and cache
chown -R www-data:www-data database storage bootstrap/cache

exec apache2-foreground
