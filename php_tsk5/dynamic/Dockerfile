FROM php:8-apache
RUN docker-php-ext-install pdo pdo_mysql mysqli
RUN pecl install redis && docker-php-ext-enable redis