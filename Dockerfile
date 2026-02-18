FROM php:apache

RUN a2enmod rewrite

# Configurar Apache para permitir acceso y procesar PHP
RUN echo '<Directory /var/www/html/>\n\
    Options Indexes FollowSymLinks\n\
    AllowOverride All\n\
    Require all granted\n\
    DirectoryIndex index.php index.html\n\
</Directory>\n\
<FilesMatch \.php$>\n\
    SetHandler application/x-httpd-php\n\
</FilesMatch>' > /etc/apache2/conf-available/docker-php.conf

RUN a2enconf docker-php

RUN docker-php-ext-install mysqli

# Instalar Composer para gestionar dependencias (PHPMailer)
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copiar entrypoint que instala dependencias al iniciar
COPY docker-entrypoint.sh /usr/local/bin/docker-entrypoint.sh
RUN chmod +x /usr/local/bin/docker-entrypoint.sh

EXPOSE 80

ENTRYPOINT ["docker-entrypoint.sh"]