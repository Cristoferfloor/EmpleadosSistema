FROM php:8.2-apache

# Instala extensiones necesarias para Laravel
RUN apt-get update && apt-get install -y \
    git unzip zip curl libpq-dev libzip-dev libonig-dev libxml2-dev \
    && docker-php-ext-install pdo pdo_pgsql zip

# Instala Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copia todos los archivos del proyecto
COPY . /var/www/html/

# Configura permisos y Apache
RUN chown -R www-data:www-data /var/www/html \
    && a2enmod rewrite

# Establece el directorio de trabajo
WORKDIR /var/www/html

# Instala dependencias de Laravel
RUN composer install --no-dev --optimize-autoloader

# Ejecuta migraciones y lanza Apache al iniciar
CMD php artisan migrate --force && apache2-foreground
