FROM php:8.3-apache

RUN apt-get update && apt-get install -y \
    git \
    zip \
    unzip \
    libzip-dev \
    && docker-php-ext-install pdo_mysql zip

RUN pecl install xdebug \
    && docker-php-ext-enable xdebug

RUN a2enmod rewrite

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
COPY apache.conf /etc/apache2/sites-available/000-default.conf
COPY . /var/www

RUN chown -R www-data:www-data /var/www

WORKDIR /var/www
