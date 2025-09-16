# Utiliser l'image PHP officielle avec Composer
FROM php:8.2-cli

# Installer extensions PHP nécessaires à Laravel
RUN apt-get update && apt-get install -y \
    unzip git libpq-dev libzip-dev \
    && docker-php-ext-install pdo pdo_mysql zip

# Installer Composer
COPY --from=composer:2.6 /usr/bin/composer /usr/bin/composer

# Copier le code
WORKDIR /app
COPY . .

# Installer dépendances Laravel
RUN composer install --no-dev --optimize-autoloader

# Compiler assets si nécessaire
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - && \
    apt-get install -y nodejs && \
    npm install && npm run build

# Exposer le port pour Artisan
EXPOSE 8000

# Commande de démarrage
CMD php artisan serve --host 0.0.0.0 --port 8000
