FROM php:8.4-apache

# Instalar dependencias del sistema + Chromium (compatible con ARM)
RUN apt-get update && apt-get install -y \
    curl \
    gnupg2 \
    ca-certificates \
    apt-transport-https \
    software-properties-common \
    chromium \
    chromium-driver \
    unzip \
    git \
    zlib1g-dev \
    libzip-dev \
    && docker-php-ext-install zip \
    && docker-php-ext-enable zip \
    && rm -rf /var/lib/apt/lists/*

# Establecer el directorio de trabajo
WORKDIR /var/www/html

# Copiar el código fuente y el archivo .env
COPY . /var/www/html

# Instalar Composer y dependencias
COPY --from=composer:2.1 /usr/bin/composer /usr/bin/composer
RUN composer install --no-scripts --no-autoloader

# Copiar el script de entrada y darle permisos de ejecución
COPY entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh

# Exponer el puerto 80
EXPOSE 80

# Definir el punto de entrada
ENTRYPOINT ["/usr/local/bin/entrypoint.sh"]