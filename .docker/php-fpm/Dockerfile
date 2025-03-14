# Utilisation d'une image PHP avec Nginx et Composer
FROM php:8.2-fpm

# Installation des dépendances requises
RUN apt-get update && apt-get install -y default-mysql-client \
    netcat-openbsd \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    zip \
    git \
    curl \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd pdo pdo_mysql opcache


RUN mkdir -p /var/www/storage /var/www/bootstrap/cache \
    && chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache


# Définir le répertoire de travail
WORKDIR /var/www

# Copier le code source de l'application Laravel
COPY . .

# Exposer le port
EXPOSE 9000

# Lancer PHP-FPM
CMD ["php-fpm"]