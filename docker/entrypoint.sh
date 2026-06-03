#!/bin/bash
set -e

echo "==> Laravel startup"

# Limpiar cache viejo
php artisan config:clear 2>/dev/null || true

# Parsear DATABASE_URL si las vars individuales están vacías
if [ -n "$DATABASE_URL" ] && [ -z "$DB_HOST" ]; then
    echo "==> Parsing DATABASE_URL..."
    export DB_HOST=$(echo "$DATABASE_URL"     | sed -E 's|.*@([^:/]+).*|\1|')
    export DB_PORT=$(echo "$DATABASE_URL"     | sed -E 's|.*:([0-9]+)/[^/].*|\1|')
    export DB_DATABASE=$(echo "$DATABASE_URL" | sed -E 's|.*/([^?]+)(\?.*)?$|\1|')
    export DB_USERNAME=$(echo "$DATABASE_URL" | sed -E 's|.*://([^:]+):.*|\1|')
    export DB_PASSWORD=$(echo "$DATABASE_URL" | sed -E 's|.*://[^:]+:([^@]+)@.*|\1|')
    export DB_SSLMODE=require
    echo "==> HOST=${DB_HOST} PORT=${DB_PORT} DB=${DB_DATABASE} USER=${DB_USERNAME}"
fi

# Cachear config con vars correctas
echo "==> Caching config..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Storage symlink
if [ ! -L /var/www/html/public/storage ]; then
    php artisan storage:link 2>/dev/null || true
fi

# Ejecutar migraciones en background (Apache arranca ya, las migraciones se hacen después)
(
    echo "==> [bg] Waiting for database..."
    MAX=30
    N=0
    until php -r "
        \$u = getenv('DATABASE_URL');
        if (\$u) {
            // Construir DSN desde URL
            preg_match('|pgsql://([^:]+):([^@]+)@([^:/]+):(\d+)/([^?]+)|', str_replace('postgresql://', 'pgsql://', \$u), \$m);
            \$dsn = \"pgsql:host={\$m[3]};port={\$m[4]};dbname={\$m[5]};sslmode=require\";
            try { new PDO(\$dsn, \$m[1], \$m[2], [PDO::ATTR_TIMEOUT=>5]); echo 'OK'; exit(0); }
            catch(Exception \$e) { file_put_contents('php://stderr', \$e->getMessage().PHP_EOL); exit(1); }
        }
        \$dsn = 'pgsql:host='.getenv('DB_HOST').';port='.(getenv('DB_PORT')?:'5432').';dbname='.getenv('DB_DATABASE').';sslmode='.(getenv('DB_SSLMODE')?:'require');
        try { new PDO(\$dsn, getenv('DB_USERNAME'), getenv('DB_PASSWORD'), [PDO::ATTR_TIMEOUT=>5]); echo 'OK'; exit(0); }
        catch(Exception \$e) { file_put_contents('php://stderr', \$e->getMessage().PHP_EOL); exit(1); }
    " 2>/dev/null | grep -q OK; do
        N=$((N+1))
        [ "$N" -ge "$MAX" ] && echo "==> [bg] ERROR: DB unreachable after ${MAX} attempts" && exit 1
        echo "==> [bg] attempt $N/$MAX..."
        sleep 3
    done
    echo "==> [bg] Database connected! Running migrations..."
    php artisan migrate --force && echo "==> [bg] Migrations done!" || echo "==> [bg] Migration failed!"
) &

echo "==> Starting Apache on port 10000..."
exec apache2-foreground
