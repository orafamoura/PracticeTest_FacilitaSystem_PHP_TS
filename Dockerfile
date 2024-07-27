FROM php:8.3-fpm

# Instalar extensões necessárias
RUN apt-get update && apt-get install -y \
    libcurl4-openssl-dev pkg-config libssl-dev \
    && pecl install mongodb \
    && docker-php-ext-enable mongodb \
    && docker-php-ext-install pdo pdo_mysql \
    && apt-get install -y wget unzip \
    && wget https://getcomposer.org/download/latest-stable/composer.phar -O /usr/local/bin/composer \
    && chmod +x /usr/local/bin/composer

# Copiar os arquivos da aplicação
COPY . /var/www/html/

# Definir permissões apropriadas
RUN chown -R www-data:www-data /var/www/html

WORKDIR /var/www/html

RUN composer install

EXPOSE 80

CMD ["php-fpm"]
