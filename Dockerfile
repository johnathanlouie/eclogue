FROM composer:2.2.6 as composer
WORKDIR /app
COPY composer.json .
CMD composer install
# FROM php:5.5.38-apache as php
# WORKDIR /var/www/html/api
# COPY --from=composer /var/www/html/api/vendor ./vendor
# RUN a2enmod rewrite
# CMD apache2-foreground
