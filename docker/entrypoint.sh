#!/bin/sh
set -e

echo "==> Running Laravel setup..."

# Generate app key if not set
if [ -z "$APP_KEY" ]; then
    echo "==> Generating application key..."
    php artisan key:generate --force
fi

# Cache configuration for performance
echo "==> Caching config..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Run migrations (--force required in production)
echo "==> Running migrations..."
php artisan migrate --force

# Create storage symlink if it doesn't exist
if [ ! -L /var/www/html/public/storage ]; then
    echo "==> Creating storage symlink..."
    php artisan storage:link
fi

echo "==> Starting services via supervisord..."
exec /usr/bin/supervisord -c /etc/supervisor/conf.d/supervisord.conf
