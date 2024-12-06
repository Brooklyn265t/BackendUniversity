FROM php:7.4-apache
RUN docker-php-ext-install pdo pdo_mysql mysqli
EXPOSE 80
ADD index.php /var/www/html
ADD style.css /var/www/html

