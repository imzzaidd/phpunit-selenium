#!/bin/bash
set -euo pipefail

echo "Esperando a que Selenium esté disponible en $SELENIUM_HUB_URL/status..."

until curl -sSf "$SELENIUM_HUB_URL/status" > /dev/null; do
  echo "Selenium aún no está listo, esperando 2s..."
  sleep 2
done

echo "✅ Selenium está disponible. Ejecutando PHPUnit..."
exec "$@"