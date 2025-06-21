FROM php:8.2-apache

# Instala extensiones necesarias para Laravel
RUN apt-get update && apt-get install -y \
    git unzip zip curl libpq-dev libzip-dev libonig-dev libxml2-dev \
    && docker-php-ext-install pdo pdo_pgsql zip

# Instala Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copia los archivos de Laravel
COPY . /var/www/html/

# Configura Apache para servir Laravel desde /public
RUN chown -R www-data:www-data /var/www/html \
    && a2enmod rewrite \
    && service apache2 restart

WORKDIR /var/www/html

# Instala dependencias de Laravel
RUN composer install --no-dev --optimize-autoloader

# Variables de entorno
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
