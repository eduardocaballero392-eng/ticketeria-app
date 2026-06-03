#!/bin/bash
set -e

echo "==> Running Laravel setup..."

# Limpiar cache viejo (puede tener credenciales incorrectas)
php artisan config:clear 2>/dev/null || true
php artisan cache:clear 2>/dev/null || true

# Si DATABASE_URL existe, usarla directamente (Render la provee con SSL)
if [ -n "$DATABASE_URL" ]; then
    echo "==> Using DATABASE_URL for connection"
fi

echo "==> DB_HOST=${DB_HOST}"
echo "==> DB_DATABASE=${DB_DATABASE}"
echo "==> DB_SSLMODE=${DB_SSLMODE}"

# Recachear con las variables de entorno actuales
echo "==> Caching config, routes and views..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Esperar a que la DB esté disponible
echo "==> Waiting for database connection..."
MAX_TRIES=30
COUNT=0
until php -r "
    try {
        \$dsn = 'pgsql:host=' . getenv('DB_HOST') . ';port=' . (getenv('DB_PORT') ?: 5432) . ';dbname=' . getenv('DB_DATABASE') . ';sslmode=' . (getenv('DB_SSLMODE') ?: 'require');
        new PDO(\$dsn, getenv('DB_USERNAME'), getenv('DB_PASSWORD'));
        echo 'OK';
    } catch (Exception \$e) {
        echo 'FAIL: ' . \$e->getMessage();
        exit(1);
    }
" 2>/dev/null | grep -q "OK"; do
    COUNT=$((COUNT + 1))
    if [ "$COUNT" -ge "$MAX_TRIES" ]; then
        echo "ERROR: Database not reachable. Last error:"
        php -r "
            try {
                \$dsn = 'pgsql:host=' . getenv('DB_HOST') . ';port=' . (getenv('DB_PORT') ?: 5432) . ';dbname=' . getenv('DB_DATABASE') . ';sslmode=' . (getenv('DB_SSLMODE') ?: 'require');
                new PDO(\$dsn, getenv('DB_USERNAME'), getenv('DB_PASSWORD'));
            } catch (Exception \$e) {
                echo \$e->getMessage() . PHP_EOL;
                exit(1);
            }
        "
        exit 1
    fi
    echo "  Waiting for DB... attempt $COUNT/$MAX_TRIES"
    sleep 2
done

echo "==> Database connection OK!"
echo "==> Running migrations..."
php artisan migrate --force

# Crear symlink de storage si no existe
if [ ! -L /var/www/html/public/storage ]; then
    echo "==> Creating storage symlink..."
    php artisan storage:link
fi

echo "==> Starting PHP-FPM + Nginx..."
exec /init
