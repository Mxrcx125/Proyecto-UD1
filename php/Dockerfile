FROM php:8.3-fpm-alpine

# Instalar extensiones necesarias para conectar con MySQL mediante PDO
RUN docker-php-ext-install pdo pdo_mysql

WORKDIR /var/www/html
