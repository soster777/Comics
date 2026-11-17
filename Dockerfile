# Render no tiene PHP, así que la app corre en un contenedor con PHP + Apache
FROM php:8.4-apache

# pdo_pgsql para conectarse a la base Postgres de Render; unzip lo usa composer
RUN apt-get update && apt-get install -y libpq-dev unzip \
    && docker-php-ext-install pdo_pgsql \
    && rm -rf /var/lib/apt/lists/*

# Apache sirve la carpeta public (como en XAMPP), escucha en el puerto que da Render
# y lee el .htaccess de Laravel (mod_rewrite)
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
ENV PORT=10000
RUN sed -ri 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf \
    && sed -ri 's!Listen 80!Listen ${PORT}!' /etc/apache2/ports.conf \
    && sed -ri 's!<VirtualHost \*:80>!<VirtualHost *:${PORT}>!' /etc/apache2/sites-available/000-default.conf \
    && sed -ri '/<Directory \/var\/www\/>/,/<\/Directory>/ s/AllowOverride None/AllowOverride All/' /etc/apache2/apache2.conf \
    && a2enmod rewrite

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html
COPY . .

# sin las dependencias de desarrollo (phpunit, faker, etc.)
RUN composer install --no-dev --optimize-autoloader --no-interaction

COPY docker/start.sh /usr/local/bin/start.sh
RUN chmod +x /usr/local/bin/start.sh

CMD ["start.sh"]
