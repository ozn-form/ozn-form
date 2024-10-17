FROM php:8.2-apache

RUN pecl install xdebug \
    && docker-php-ext-enable  xdebug

RUN apt-get update && apt-get install -y vim curl openssl libxml2-dev zip zlib1g-dev libonig-dev\
    && docker-php-ext-install pdo_mysql xml

RUN apt-get install -y \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
        libpng-dev \
    && docker-php-ext-install -j$(nproc) iconv \
    && docker-php-ext-configure gd --with-freetype=/usr/include/ --with-jpeg=/usr/include/ \
    && docker-php-ext-install -j$(nproc) gd

COPY --from=composer:2.1.3 /usr/bin/composer /usr/bin/composer

RUN composer global require 'phpunit/phpunit:*'
ENV PATH /root/.composer/vendor/bin:$PATH

RUN a2enmod rewrite
RUN a2enmod ssl
RUN a2ensite default-ssl
RUN a2enmod headers