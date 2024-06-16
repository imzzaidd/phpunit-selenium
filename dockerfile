FROM php:8.2-apache

# Actualizar e instalar dependencias necesarias
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    zlib1g-dev \
    libzip-dev \
    && docker-php-ext-install zip \
    && docker-php-ext-enable zip

# Instalar Google Chrome
RUN apt-get install -y wget gnupg2 \
    && wget -q -O - https://dl-ssl.google.com/linux/linux_signing_key.pub | apt-key add - \
    && sh -c 'echo "deb [arch=amd64] http://dl.google.com/linux/chrome/deb/ stable main" >> /etc/apt/sources.list.d/google-chrome.list' \
    && apt-get update \
    && apt-get install -y google-chrome-stable \
    && rm -rf /var/lib/apt/lists/*
    
# Instalar ChromeDriver
RUN LATEST_VERSION=$(curl -sS chromedriver.storage.googleapis.com/LATEST_RELEASE) \
    && wget -O /tmp/chromedriver.zip https://chromedriver.storage.googleapis.com/$LATEST_VERSION/chromedriver_linux64.zip \
    && unzip /tmp/chromedriver.zip chromedriver -d /usr/local/bin/ \
    && rm /tmp/chromedriver.zip

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
