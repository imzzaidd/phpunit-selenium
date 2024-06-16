#!/bin/sh

echo "Esperando a que Selenium Hub esté disponible en $SELENIUM_HUB_URL..."
while ! curl -sSf $SELENIUM_HUB_URL > /dev/null; do
    echo "Esperando a Selenium Hub..."
    sleep 10
done

# Cargar las variables de entorno desde .env
if [ -f /var/www/html/.env ]; then
  set -a
  # Leer y exportar las variables de entorno
  . /var/www/html/.env
  set +a
fi

vendor/bin/phpunit --configuration phpunit.xml --testsuite "UI Tests"
