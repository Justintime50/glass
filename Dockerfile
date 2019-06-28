FROM php:fpm

RUN docker-php-ext-install mysqli pdo pdo_mysql