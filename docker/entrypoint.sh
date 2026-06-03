#!/bin/bash
set -e

echo "==> Laravel startup"

# Limpiar cache viejo
php artisan config:clear 2>/dev/null || true

# Mostrar variables para debug
echo "==> DB_CONNECTION=${DB_CONNECTION}"
echo "==> DB_HOST=${DB_HOST}"
echo "==> DB_DATABASE=${DB_DATABASE}"
echo "==> DATABASE_URL=${DATABASE_URL:0:40}..."

# Si DATABASE_URL existe y las vars individuales están vacías, parsearla
if [ -n "$DATABASE_URL" ] && [ -z "$DB_HOST" ]; then
    echo "==> Parsing DATABASE_URL..."
    # postgresql://user:pass@host:port/dbname
    export DB_HOST=$(echo "$DATABASE_URL" | sed -E 's|.*@([^:/]+).*|\1|')
    export DB_PORT=$(echo "$DATABASE_URL" | sed -E 's|.*:([0-9]+)/.*|\1|')
    export DB_DATABASE=$(echo "$DATABASE_URL" | sed -E 's|.*/([^?]+).*|\1|')
    export DB_USERNAME=$(echo "$DATABASE_URL" | sed -E 's|.*://([^:]+):.*|\1|')
    export DB_PASSWORD=$(echo "$DATABASE_URL" | sed -E 's|.*://[^:]+:([^@]+)@.*|\1|')
    export DB_SSLMODE=require
    echo "==> Parsed => HOST=${DB_HOST} DB=${DB_DATABASE} USER=${DB_USERNAME}"
fi

# Recachear con variables correctas
echo "==> Caching config..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Esperar conexión a DB (máx 60s)
echo "==> Waiting for database..."
MAX_TRIES=30
COUNT=0
until php -r "
    \$host = getenv('DB_HOST');
    \$port = getenv('DB_PORT') ?: '5432';
    \$db   = getenv('DB_DATABASE');
    \$user = getenv('DB_USERNAME');
    \$pass = getenv('DB_PASSWORD');
    \$ssl  = getenv('DB_SSLMODE') ?: 'require';
    if (!empty(getenv('DATABASE_URL'))) {
        \$dsn = getenv('DATABASE_URL');
        \$opts = [\PDO::ATTR_TIMEOUT => 5];
        try { new PDO(\$dsn, null, null, \$opts); echo 'OK'; exit(0); } catch(\Exception \$e) {}
    }
    \$dsn = \"pgsql:host={\$host};port={\$port};dbname={\$db};sslmode={\$ssl}\";
    try { new PDO(\$dsn, \$user, \$pass, [\PDO::ATTR_TIMEOUT => 5]); echo 'OK'; exit(0); }
    catch(\Exception \$e) { echo \$e->getMessage(); exit(1); }
" 2>/dev/null | grep -q "OK"; do
    COUNT=$((COUNT + 1))
    if [ "$COUNT" -ge "$MAX_TRIES" ]; then
        echo "==> ERROR: Cannot connect to database. Debug info:"
        php -r "
            \$dsn = \"pgsql:host=\" . getenv('DB_HOST') . \";port=\" . (getenv('DB_PORT') ?: 5432) . \";dbname=\" . getenv('DB_DATABASE') . \";sslmode=\" . (getenv('DB_SSLMODE') ?: 'require');
            try { new PDO(\$dsn, getenv('DB_USERNAME'), getenv('DB_PASSWORD')); }
            catch(\Exception \$e) { echo \$e->getMessage() . PHP_EOL; }
        "
        exit 1
    fi
    echo "  attempt $COUNT/$MAX_TRIES..."
    sleep 2
done

echo "==> Database connected!"
echo "==> Running migrations..."
php artisan migrate --force

# Storage symlink
if [ ! -L /var/www/html/public/storage ]; then
    php artisan storage:link
fi

echo "==> Starting Apache on port 10000..."
exec apache2-foreground
