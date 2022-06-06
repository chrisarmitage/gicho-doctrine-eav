FROM php:8.1-fpm

# Install additional dependencies
RUN apt-get update && apt-get install -y \
    git \
    zip \
    unzip \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

RUN pecl install redis \
    && docker-php-ext-configure pcntl --enable-pcntl \
    && docker-php-ext-enable \
        redis \
    && docker-php-ext-install \
        sockets \
        pcntl

# Install composer
COPY --from=composer:2.0 /usr/bin/composer /usr/bin/composer

