FROM php:8.1-fpm-alpine as base
RUN  apk update && apk upgrade &&  apk add $PHPIZE_DEPS

ENV APP_HOME=/var/www/html
FROM base as dev
WORKDIR $APP_HOME
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
RUN pecl install xdebug && docker-php-ext-enable xdebug \
    && echo "zend_extension=$(find /usr/local/lib/php/extensions/ -name xdebug.so)" > /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.mode=coverage" >> /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.remote_autostart=off" >> /usr/local/etc/php/conf.d/xdebug.ini
RUN set -ex \
  && apk --no-cache add \
    postgresql-dev
RUN docker-php-ext-install sockets pdo_pgsql


RUN pecl install -o -f redis \
&&  rm -rf /tmp/pear \
&&  docker-php-ext-enable redis

FROM dev as ci
WORKDIR $APP_HOME
COPY . .
RUN composer install
RUN cp .env.example .env
RUN php artisan key:generate
RUN php artisan test

FROM ci as prod
WORKDIR $APP_HOME
# ESSE COMANDO REMOVE TODAS AS DEPENDENCIAS DE DESENVOLVIMENTO
RUN composer install --no-dev



FROM base as finish
WORKDIR $APP_HOME
COPY --from=prod --chown=www-data ${APP_HOME} ${APP_HOME}
