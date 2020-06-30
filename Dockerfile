FROM php:7.3-apache AS builder

RUN apt-get update

# Tell debian we want a modern version of node, not the ancient one they install by default
RUN apt-get install -y \
    curl \
    sudo \
    software-properties-common

RUN curl -sL https://deb.nodesource.com/setup_14.x | sudo bash -

# Install build dependencies
RUN apt-get install -y \
    nodejs \
    git \
    zip \
    unzip

# Copy in web application
ADD . /var/www/html

# Install Composer
RUN curl --silent --show-error https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Build app
WORKDIR "/var/www/html"
RUN cp .env.example .env && \
    echo "DB_DATABASE=$(pwd)/database/database.sqlite" >> .env && \
    npm install && \
    npm run production && \
    composer update --no-dev && \
    touch database/database.sqlite && \
    php artisan migrate && \
    php artisan db:seed && \
    chown -R www-data:www-data .

FROM php:7.3-apache

# Confgiure Apache and PHP
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf && \
    sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf && \
    a2enmod rewrite headers ssl

RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"

# Copy over the app we just built
COPY --from=builder /var/www/html /var/www/html
