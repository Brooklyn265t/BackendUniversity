FROM php:8-apache
RUN docker-php-ext-install pdo pdo_mysql mysqli
RUN pecl install redis && docker-php-ext-enable redis
RUN apt update && apt install zlib1g-dev libpng-dev libfreetype-dev -y
RUN docker-php-ext-configure gd --with-freetype
RUN docker-php-ext-install gd
