FROM php:5.6-apache

# Install vim
RUN apt-get update && \
    apt-get install -y vim && \
    pecl install xdebug && \
    docker-php-ext-enable xdebug

RUN apt-get install -y \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
        libpng12-dev
RUN docker-php-ext-install gd

COPY ./xdebug.ini /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
COPY ./php.ini /usr/local/etc/php/php.ini
