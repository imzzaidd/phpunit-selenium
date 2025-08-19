FROM php:8.2-cli

RUN apt-get update \
    && apt-get install -y \
        unzip \
        git \
        zip \
        curl \
        chromium-driver \
        libzip-dev \
    && docker-php-ext-install mysqli zip

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /app
COPY . /app