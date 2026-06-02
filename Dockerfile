# ── Base image: PHP 8.2 + Nginx + extensiones precompiladas para Laravel ──
FROM serversideup/php:8.2-fpm-nginx

# Cambiar a root para instalar dependencias del sistema
USER root

# Instalar extensión pgsql (no incluida por defecto en esta imagen)
RUN install-php-extensions pgsql pdo_pgsql

# Instalar Composer
COPY --from=composer:2.6 /usr/bin/composer /usr/bin/composer

# Instalar Node.js 20
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs \
    && rm -rf /var/lib/apt/lists/*

WORKDIR /var/www/html

# Copiar archivos de dependencias primero (aprovecha el cache de capas)
COPY --chown=www-data:www-data composer.json composer.lock ./
RUN composer install --no-dev --optimize-autoloader --no-scripts --no-interaction

COPY --chown=www-data:www-data package.json ./
RUN npm install

# Copiar el resto de la aplicación
COPY --chown=www-data:www-data . .

# Compilar assets y limpiar node_modules
RUN npm run build && rm -rf node_modules

# Finalizar autoload de composer con la app completa
RUN composer dump-autoload --optimize

# Permisos correctos
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache \
    && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Copiar entrypoint personalizado
COPY docker/entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh

EXPOSE 80

ENTRYPOINT ["/entrypoint.sh"]
