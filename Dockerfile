FROM php:apache
COPY . /var/www/html/

RUN a2enmod rewrite

RUN chmod -R 755 /var/www/html

RUN docker-php-ext-install mysqli
EXPOSE 80