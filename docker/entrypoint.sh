#!/bin/bash
set -e

echo "==> Running Laravel setup..."

# Cache de configuración para producción
echo "==> Caching config, routes and views..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Ejecutar migraciones (--force requerido en producción)
echo "==> Running migrations..."
php artisan migrate --force

# Crear symlink de storage si no existe
if [ ! -L /var/www/html/public/storage ]; then
    echo "==> Creating storage symlink..."
    php artisan storage:link
fi

echo "==> Starting PHP-FPM + Nginx..."
# Arrancar el proceso init de serversideup (s6-overlay)
exec /init
