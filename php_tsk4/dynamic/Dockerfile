FROM php:8-apache
RUN docker-php-ext-install pdo pdo_mysql mysqli
RUN pecl install --onlyreqdep --force redis \
&& rm -rf /tmp/pear \
&& docker-php-ext-enable redis
