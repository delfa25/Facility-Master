FROM php:8.2-cli

RUN apt-get update && apt-get install -y \
    unzip git libpq-dev libzip-dev curl \
    && docker-php-ext-install pdo pdo_mysql zip

COPY --from=composer:2.6 /usr/bin/composer /usr/bin/composer

WORKDIR /app
COPY . .

RUN composer install --no-dev --optimize-autoloader

# Droits sur storage et cache
RUN chmod -R 775 storage bootstrap/cache

# Installer les dépendances Laravel
RUN composer install --no-dev --optimize-autoloader

# Droits sur storage et cache
RUN chmod -R 775 storage bootstrap/cache

# --- AJOUT : définir les variables env pour build ---
ENV APP_ENV=production
ENV APP_DEBUG=false
ENV APP_KEY=base64:D+aegDt8iNcO68prCyMGMWOYmETqA+7QhsHFyRMnPpY=
ENV DB_CONNECTION=mysql
ENV DB_HOST=mysql.railway.internal
ENV DB_PORT=3306
ENV DB_DATABASE=railway
ENV DB_USERNAME=root
ENV DB_PASSWORD=fPMnlhOpTVAdgWLnSlEWDXNjAgeoKTUx


# Compiler assets Laravel
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - && \
    apt-get install -y nodejs && \
    npm install && npm run build

EXPOSE 8000
CMD php artisan serve --host 0.0.0.0 --port 8000
