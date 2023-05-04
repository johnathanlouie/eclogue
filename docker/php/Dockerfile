FROM php:5.6.40-fpm-alpine3.8

WORKDIR /app

COPY --chmod=755 files/install-php-extensions /usr/local/bin/install-php-extensions
RUN install-php-extensions xdebug @composer-1.10.26
