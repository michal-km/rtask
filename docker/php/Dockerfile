# Base official distribution

FROM php:8.1-apache-bullseye
ENV APACHE_DOCUMENT_ROOT /var/www/rtask/web

# Change document root

RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# Enable clean URLs

RUN a2enmod rewrite

# Metadata

LABEL org.opencontainers.image.authors="Michał Kaźmierczak" \
      org.opencontainers.image.description="An exercise in running dockerized Drupal" \
      org.opencontainers.image.title="Drupal dev environment" \
      org.opencontainers.image.vendor="Michał Kaźmierczak"

# APT update

RUN apt-get update -y

# Dependencies for gd and zip

RUN apt-get install -y libzip-dev zlib1g-dev libpng-dev libwebp-dev libjpeg-dev libfreetype6-dev
RUN docker-php-ext-configure gd --with-jpeg --with-freetype

# Install neccessary php extensions

RUN docker-php-ext-install zip gd pdo_mysql opcache

# Install mysql client

RUN apt-get install -y mariadb-client

# Install git

RUN apt-get install -y git

# Install composer

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Create Drupal project

WORKDIR /var/www
RUN composer create-project drupal/recommended-project rtask

# Create Drupal dev environment

WORKDIR /var/www/rtask
RUN composer require drupal/core-dev
RUN composer install
RUN composer require drush/drush
RUN ln -s /var/www/rtask/vendor/drush/drush/drush /usr/bin/drush
RUN composer require --dev phpspec/prophecy-phpunit:^2
RUN ln -s /var/www/rtask/vendor/phpunit/phpunit/phpunit /usr/bin/phpunit

COPY ./phpunit.xml.dist /var/www/rtask/web/core/phpunit.xml.dist
COPY ./files /var/www/rtask/web/sites/default/files
RUN chown -R www-data:www-data /var/www/rtask/web/sites/default/files && chmod -R 770 /var/www/rtask/web/sites/default/files
COPY ./settings.php /var/www/rtask/web/sites/default/settings.php
RUN chmod 444 /var/www/rtask/web/sites/default/settings.php
RUN mkdir /var/www/rtask/config_sync
RUN chown -R www-data:www-data /var/www/rtask/config_sync && chmod 770 /var/www/rtask/config_sync

RUN composer install
