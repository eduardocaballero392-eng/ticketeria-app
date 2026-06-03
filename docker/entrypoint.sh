#!/bin/bash
set -e

echo "==> Laravel startup"

cd /var/www/html

# Parsear DATABASE_URL si las vars individuales están vacías
if [ -n "$DATABASE_URL" ] && [ -z "$DB_HOST" ]; then
    echo "==> Parsing DATABASE_URL..."
    DB_HOST=$(echo "$DATABASE_URL"     | sed -E 's|.*@([^:/]+).*|\1|')
    DB_PORT=$(echo "$DATABASE_URL"     | sed -E 's|.*:([0-9]+)/[^/].*|\1|')
    DB_DATABASE=$(echo "$DATABASE_URL" | sed -E 's|.*/([^?]+)(\?.*)?$|\1|')
    DB_USERNAME=$(echo "$DATABASE_URL" | sed -E 's|.*://([^:]+):.*|\1|')
    DB_PASSWORD=$(echo "$DATABASE_URL" | sed -E 's|.*://[^:]+:([^@]+)@.*|\1|')
    DB_SSLMODE=require
    echo "==> HOST=${DB_HOST} PORT=${DB_PORT} DB=${DB_DATABASE}"
fi

# Escribir .env con todos los valores correctos para que Apache/PHP los lean
cat > /var/www/html/.env << ENVEOF
APP_NAME="${APP_NAME:-Sistema de Tickets}"
APP_ENV=${APP_ENV:-production}
APP_KEY=${APP_KEY}
APP_DEBUG=${APP_DEBUG:-false}
APP_URL=${APP_URL:-http://localhost}

LOG_CHANNEL=stderr
LOG_LEVEL=${LOG_LEVEL:-error}

DB_CONNECTION=pgsql
DB_HOST=${DB_HOST}
DB_PORT=${DB_PORT:-5432}
DB_DATABASE=${DB_DATABASE}
DB_USERNAME=${DB_USERNAME}
DB_PASSWORD=${DB_PASSWORD}
DB_SSLMODE=${DB_SSLMODE:-require}

CACHE_DRIVER=${CACHE_DRIVER:-file}
SESSION_DRIVER=${SESSION_DRIVER:-file}
QUEUE_CONNECTION=${QUEUE_CONNECTION:-sync}
FILESYSTEM_DISK=local

MAIL_MAILER=${MAIL_MAILER:-smtp}
MAIL_HOST=${MAIL_HOST:-smtp.gmail.com}
MAIL_PORT=${MAIL_PORT:-587}
MAIL_USERNAME=${MAIL_USERNAME}
MAIL_PASSWORD=${MAIL_PASSWORD}
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=${MAIL_FROM_ADDRESS}
MAIL_FROM_NAME="${MAIL_FROM_NAME:-Sistema de Tickets}"
ENVEOF

echo "==> .env written"

# Limpiar cache viejo y recachear con .env correcto
php artisan config:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Storage symlink
[ ! -L /var/www/html/public/storage ] && php artisan storage:link 2>/dev/null || true

# Migraciones en background (Apache arranca ya)
(
    echo "==> [bg] Waiting for DB..."
    N=0
    until php -r "
        \$url = getenv('DATABASE_URL');
        if (\$url) {
            preg_match('|(postgresql|pgsql)://([^:]+):([^@]+)@([^:/]+):(\d+)/([^?]+)|', \$url, \$m);
            \$dsn = \"pgsql:host={\$m[4]};port={\$m[5]};dbname={\$m[6]};sslmode=require\";
            try { new PDO(\$dsn, \$m[2], \$m[3], [PDO::ATTR_TIMEOUT=>5]); echo 'OK'; exit(0); }
            catch(Exception \$e) { exit(1); }
        }
        \$h=getenv('DB_HOST'); \$p=getenv('DB_PORT')?:'5432'; \$d=getenv('DB_DATABASE');
        \$dsn=\"pgsql:host=\$h;port=\$p;dbname=\$d;sslmode=require\";
        try { new PDO(\$dsn,getenv('DB_USERNAME'),getenv('DB_PASSWORD'),[PDO::ATTR_TIMEOUT=>5]); echo 'OK'; exit(0); }
        catch(Exception \$e) { exit(1); }
    " 2>/dev/null | grep -q OK; do
        N=$((N+1))
        [ "$N" -ge 30 ] && echo "==> [bg] DB timeout" && break
        sleep 3
    done
    echo "==> [bg] Running migrations..."
    php artisan migrate --force && echo "==> [bg] Migrations OK" || echo "==> [bg] Migrations FAILED"
) &

echo "==> Starting Apache on port 10000..."
exec apache2-foreground
