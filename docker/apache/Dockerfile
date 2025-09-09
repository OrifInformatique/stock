FROM php:8.1-apache

RUN apt-get update && apt-get install -y \
    libzip-dev \
    zip \
    libicu-dev \
    && docker-php-ext-install zip pdo pdo_mysql intl mysqli

RUN a2enmod rewrite

WORKDIR /var/www/html