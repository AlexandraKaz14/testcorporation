FROM php:8.4-fpm

ADD docker/php/php.ini /usr/local/etc/php/php.ini

COPY . /var/www

RUN curl -fsSL https://deb.nodesource.com/setup_17.x

RUN apt-get update && apt-get install -y \
    git \
    curl \
    libcurl4-openssl-dev \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    zip \
    unzip \
    nodejs \
    npm \
    libpq-dev \
    nano \
    htop \
    ca-certificates

RUN pecl install redis

RUN docker-php-ext-enable redis
RUN docker-php-ext-install zip
RUN docker-php-ext-install ftp
RUN docker-php-ext-install curl
RUN docker-php-ext-install mbstring
RUN docker-php-ext-install exif
RUN docker-php-ext-install pcntl
RUN docker-php-ext-install bcmath
RUN docker-php-ext-install gd
RUN docker-php-ext-install pgsql
RUN docker-php-ext-install pdo_pgsql


RUN apt-get clean && rm -rf /var/lib/apt/lists/*

RUN npm cache clean -f
RUN npm install -g n
RUN npm install
RUN n stable

# Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Рабочая директория
WORKDIR /var/www

# Убедимся, что директория существует
RUN mkdir -p /var/www/bootstrap/cache

# Дадим нужные права
RUN chown -R www-data:www-data /var/www/bootstrap/cache && chmod -R 775 /var/www/bootstrap/cache

RUN composer install --no-dev --optimize-autoloader --no-interaction

RUN npm run build

# Убедимся, что работаем от root
USER root
