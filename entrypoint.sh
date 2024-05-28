#!/bin/sh

# Espera a que el Selenium Hub esté disponible
echo "Esperando a que Selenium Hub esté disponible en $SELENIUM_HUB_URL..."
while ! curl -sSf $SELENIUM_HUB_URL > /dev/null; do
    echo "Esperando a Selenium Hub..."
    sleep 5
done

# Ejecuta las pruebas PHPUnit
vendor/bin/phpunit --configuration phpunit.xml --testsuite "UI Tests"
