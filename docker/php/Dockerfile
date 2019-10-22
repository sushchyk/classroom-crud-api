# ./docker/php/Dockerfile
FROM php:7.3-fpm

RUN apt update
RUN apt install -y --no-install-recommends \
    git \
    unzip \
    curl \
    libsodium-dev \
    zlib1g-dev \
    libzip-dev

RUN docker-php-ext-install pdo_mysql zip

ENV COMPOSER_ALLOW_SUPERUSER 1

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

COPY . /usr/src/app

WORKDIR /usr/src/app

RUN composer install

RUN PATH=$PATH:/usr/src/apps/vendor/bin:bin