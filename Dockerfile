FROM justintime50/nginx-php:latest

ARG PROD

COPY --chown=www-data:www-data ./src /var/www/html
COPY test.conf /etc/supervisord.conf

RUN if [ ! -z "$PROD" ]; then \
    # Setup prod env
    composer install -q --no-ansi --no-interaction --no-scripts --no-plugins --no-progress --prefer-dist --optimize-autoloader --no-dev \
    && npm install -s --omit=dev \
    && npx vite build; \
    # Setup dev env
    else \
    composer install \
    && npm install; \
    fi \
    # Setup shared env
    && php artisan storage:link

ENTRYPOINT ["/bin/sh", "-c", "if [ ! -z \"$PROD\" ]; then php artisan optimize; else php artisan optimize:clear; fi && exec supervisord"]
