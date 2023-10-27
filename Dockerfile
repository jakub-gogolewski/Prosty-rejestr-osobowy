# Użyj oficjalnego obrazu PHP z Apache
FROM php:8.2-apache

# Ustaw katalog roboczy
WORKDIR /var/www/html

# Zainstaluj Composer oraz potrzebne rozszerzenia PHP
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
    && apt-get update && apt-get install -y \
    libsqlite3-dev \
    && docker-php-ext-install pdo pdo_sqlite \
    && apt-get clean && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

# Ustal konfigurację Apache, aby obsługiwać aplikacje Symfony
RUN a2enmod rewrite

COPY .000-default.conf /etc/apache2/sites-available/000-default.conf
COPY . /var/www/html/
RUN chown -R www-data:www-data /var/www/html/var
