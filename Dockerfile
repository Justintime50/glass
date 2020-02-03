FROM justintime50/apache-php:dev

COPY --chown=www-data:www-data ./src /var/www/html
COPY nginx.conf /etc/nginx/conf.d/default.conf
RUN php composer.phar install -q --no-ansi --no-interaction --no-scripts --no-suggest --no-progress --prefer-dist \
    && chmod -R 770 storage \
    && php artisan storage:link
