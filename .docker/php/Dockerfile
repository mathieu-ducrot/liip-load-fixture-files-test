FROM php:7.1-fpm

WORKDIR /var/www

COPY .bashrc /root/.bashrc
COPY php.ini /usr/local/etc/php/php.ini

RUN docker-php-ext-install pdo_mysql

RUN apt-get update \
    && apt-get install \
    nano \
    git \
    zip \
    unzip\
    -y --no-install-recommends

# Install de Composer
## Composer needs : git - zip - unzip
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
    && php composer-setup.php \
    && php -r "unlink('composer-setup.php');" \
    && mv composer.phar /usr/local/bin/composer

EXPOSE 9000
CMD ["php-fpm"]