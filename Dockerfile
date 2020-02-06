FROM justintime50/nginx-php:dev

RUN apk add --no-cache --virtual .phpize-deps $PHPIZE_DEPS && pecl install -f xdebug \
    && echo "zend_extension=$(find /usr/local/lib/php/extensions/ -name xdebug.so)" > /usr/local/etc/php/conf.d/xdebug.ini;

COPY --chown=www-data:www-data ./src /var/www/html
COPY nginx.conf /etc/nginx/conf.d/default.conf
RUN php composer.phar install -q --no-ansi --no-interaction --no-scripts --no-suggest --no-progress --prefer-dist \
    && chmod -R 775 storage \
    && php artisan storage:link \
    && chmod -R 775 bootstrap/cache
