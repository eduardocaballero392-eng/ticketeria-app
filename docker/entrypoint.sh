#!/bin/bash
set -e

echo "==> Laravel startup"
cd /var/www/html

# 1. Parsear DATABASE_URL si las vars individuales no vienen
if [ -n "$DATABASE_URL" ] && [ -z "$DB_HOST" ]; then
    echo "==> Parsing DATABASE_URL..."
    DB_HOST=$(echo "$DATABASE_URL"     | sed -E 's|.*@([^:/]+).*|\1|')
    DB_PORT=$(echo "$DATABASE_URL"     | sed -E 's|.*:([0-9]+)/[^/?].*|\1|')
    DB_DATABASE=$(echo "$DATABASE_URL" | sed -E 's|.*/([^?]+)(\?.*)?$|\1|')
    DB_USERNAME=$(echo "$DATABASE_URL" | sed -E 's|[a-z]+://([^:]+):.*|\1|')
    DB_PASSWORD=$(echo "$DATABASE_URL" | sed -E 's|[a-z]+://[^:]+:([^@]+)@.*|\1|')
    DB_SSLMODE=require
    echo "==> HOST=${DB_HOST} PORT=${DB_PORT} DB=${DB_DATABASE} USER=${DB_USERNAME}"
fi

# 2. Escribir .env
python3 - <<PYEOF
import os

env_vars = {
    "APP_NAME":          os.environ.get("APP_NAME", "Sistema de Tickets"),
    "APP_ENV":           os.environ.get("APP_ENV", "production"),
    "APP_KEY":           os.environ.get("APP_KEY", ""),
    "APP_DEBUG":         os.environ.get("APP_DEBUG", "false"),
    "APP_URL":           os.environ.get("APP_URL", "https://ticketeria-app.onrender.com"),
    "LOG_CHANNEL":       "stderr",
    "LOG_LEVEL":         os.environ.get("LOG_LEVEL", "error"),
    "DB_CONNECTION":     "pgsql",
    "DB_HOST":           os.environ.get("DB_HOST", ""),
    "DB_PORT":           os.environ.get("DB_PORT", "5432"),
    "DB_DATABASE":       os.environ.get("DB_DATABASE", ""),
    "DB_USERNAME":       os.environ.get("DB_USERNAME", ""),
    "DB_PASSWORD":       os.environ.get("DB_PASSWORD", ""),
    "DB_SSLMODE":        os.environ.get("DB_SSLMODE", "require"),
    "CACHE_DRIVER":      os.environ.get("CACHE_DRIVER", "file"),
    "SESSION_DRIVER":    "cookie",
    "QUEUE_CONNECTION":  os.environ.get("QUEUE_CONNECTION", "sync"),
    "FILESYSTEM_DISK":   "local",
    "MAIL_MAILER":       os.environ.get("MAIL_MAILER", "smtp"),
    "MAIL_HOST":         os.environ.get("MAIL_HOST", "smtp.gmail.com"),
    "MAIL_PORT":         os.environ.get("MAIL_PORT", "587"),
    "MAIL_USERNAME":     os.environ.get("MAIL_USERNAME", ""),
    "MAIL_PASSWORD":     os.environ.get("MAIL_PASSWORD", ""),
    "MAIL_ENCRYPTION":   "tls",
    "MAIL_FROM_ADDRESS": os.environ.get("MAIL_FROM_ADDRESS", ""),
    "MAIL_FROM_NAME":    os.environ.get("MAIL_FROM_NAME", "Sistema de Tickets"),
}

lines = []
for k, v in env_vars.items():
    if any(c in v for c in [' ', '#', '"', "'"]):
        v = '"' + v.replace('"', '\\"') + '"'
    lines.append(f"{k}={v}")

with open("/var/www/html/.env", "w") as f:
    f.write("\n".join(lines) + "\n")

print("==> .env written OK")
print(f"    APP_KEY: {'SET' if env_vars['APP_KEY'] else 'MISSING'}")
print(f"    DB_HOST: {env_vars['DB_HOST'] or 'EMPTY'}")
print(f"    DB_DATABASE: {env_vars['DB_DATABASE'] or 'EMPTY'}")
PYEOF

# 3. Limpiar y recachear
echo "==> Rebuilding cache..."
php artisan config:clear 2>/dev/null || true
php artisan route:clear  2>/dev/null || true
php artisan view:clear   2>/dev/null || true
php artisan config:cache
php artisan route:cache
php artisan view:cache

[ ! -L /var/www/html/public/storage ] && php artisan storage:link 2>/dev/null || true

# 4. Migraciones + seeder en background
(
    echo "==> [bg] Waiting for DB..."
    N=0
    until php artisan db:show --no-interaction > /dev/null 2>&1; do
        N=$((N+1))
        [ "$N" -ge 30 ] && echo "==> [bg] DB timeout" && break
        sleep 3
    done
    echo "==> [bg] Migrating..."
    php artisan migrate --force && echo "==> [bg] Migrate OK" || echo "==> [bg] Migrate FAILED"
    echo "==> [bg] Seeding admin user..."
    php artisan db:seed --class=AdminUserSeeder --force && echo "==> [bg] Seed OK" || echo "==> [bg] Seed skipped/failed"
) &

# 5. Arrancar Apache
echo "==> Starting Apache on port 10000..."
exec apache2-foreground
