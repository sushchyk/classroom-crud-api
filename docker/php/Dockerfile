# ./docker/php/Dockerfile
FROM php:7.3-fpm

RUN docker-php-ext-install pdo_mysql

RUN php -r "copy('https://getcomposer.org/installer', '/tmp/composer-setup.php');" \
    && php -r "if (hash_file('SHA384', 'composer-setup.php') === '%SHA_384%') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;" \
    && php /tmp/composer-setup.php --filename=composer \
    && php -r "unlink('/tmp/composer-setup.php');" \
    && mv /tmp/composer /usr/local/bin/composer

WORKDIR /usr/src/app

RUN composer install

COPY . /usr/src/app

RUN PATH=$PATH:/usr/src/apps/vendor/bin:bin