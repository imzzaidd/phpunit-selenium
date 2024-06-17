#!/bin/sh

echo "Esperando a que Selenium Hub esté disponible en $SELENIUM_HUB_URL..."
while ! curl -sSf $SELENIUM_HUB_URL > /dev/null; do
    echo "Esperando a Selenium Hub..."
    sleep 10
done

# Cargar las variables de entorno desde .env si existe el archivo
if [ -f ./.env ]; then
  # Cargar las variables de entorno desde .env utilizando el comando `dotenv`
  eval $(dotenv -f ./.env)
fi

vendor/bin/phpunit --configuration phpunit.xml --testsuite "UI Tests"
