#!/bin/sh
set -e

php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan storage:link

php artisan migrate --force

if [ "$(php artisan tinker --execute='echo \App\Models\User::count();' | tail -n 1)" = "0" ]; then
    php artisan db:seed --force
fi

mkdir -p storage/app/public/portadas
cp database/seeders/portadas/* storage/app/public/portadas/

chown -R www-data:www-data storage bootstrap/cache

exec apache2-foreground
