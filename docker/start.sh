#!/bin/sh
# corre cada vez que Render arranca el contenedor
set -e

# los cachés se arman acá y no en el Dockerfile porque necesitan las variables de entorno de Render
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan storage:link

php artisan migrate --force

# la primera vez la base está vacía: cargo el admin, el cliente y los cómics
if [ "$(php artisan tinker --execute='echo \App\Models\User::count();' | tail -n 1)" = "0" ]; then
    php artisan db:seed --force
fi

# el disco de Render se borra en cada deploy, pero la base no: vuelvo a copiar las portadas del seeder
mkdir -p storage/app/public/portadas
cp database/seeders/portadas/* storage/app/public/portadas/

# Apache corre como www-data y tiene que poder escribir sesiones, caché y portadas nuevas
chown -R www-data:www-data storage bootstrap/cache

exec apache2-foreground
