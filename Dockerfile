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


WORKDIR /var/www/html

# Copiar os arquivos da aplicação
COPY . .

RUN composer install

# Definir permissões apropriadas
RUN chown -R www-data:www-data /var/www/html

EXPOSE 80

CMD ["php-fpm"]
