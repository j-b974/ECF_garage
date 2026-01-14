# Étape 1 : Utiliser l'image Node.js 18 pour construire les assets front-end
FROM node:18 AS node_build

# Définir le répertoire de travail pour Node.js selon la structure réelle du projet
WORKDIR /var/www/public

# Copier les fichiers nécessaires pour l'installation des dépendances Node.js
COPY ./public/package.json ./public/package-lock.json ./

# Installer les dépendances Node.js
RUN npm install

# Copier les fichiers source du front-end nécessaires pour le build
COPY ./public ./

# lance le build ici

# Utiliser une image PHP officielle avec Apache
FROM php:8.4.16-apache-bookworm

# Configuration Apache
RUN a2enmod rewrite

# Configuration de l'environnement
ENV APACHE_DOCUMENT_ROOT=/var/www/public

# Dépendances système
RUN apt-get update && apt-get install -y \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libpng-dev \
    libwebp-dev \
    libonig-dev \
    libzip-dev \
    unzip \
    git \
    curl \
    imagemagick \
    libmagickwand-dev \
    libpq-dev \
    pkg-config \
    --no-install-recommends \
    && rm -rf /var/lib/apt/lists/*

# Extensions PHP de base
RUN docker-php-ext-install \
    pdo_mysql \
    mbstring \
    zip \
    exif \
    pcntl

# Extension GD
RUN docker-php-ext-configure gd \
    --with-freetype \
    --with-jpeg \
    --with-webp \
    && docker-php-ext-install gd

# Extension Imagick
RUN pecl install imagick \
    && docker-php-ext-enable imagick

# Installation de Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN composer --version

# Copie des fichiers de l'application dans le conteneur
COPY . /var/www/

# Copier les assets construits depuis l'étape node_build
COPY --from=node_build /var/www/public ./public

# remplace la configuration de apache
COPY ./ServerGarage.conf /etc/apache2/sites-available/000-default.conf

# Configuration du propriétaire des fichiers
RUN chown -R www-data:www-data /var/www/
# Installation des dépendances avec Composer

RUN cd /var/www/ &&  composer install --no-dev --prefer-dist --no-interaction --no-progress --no-scripts

# change emplacement curseur commande
WORKDIR /var/www/

#
ENTRYPOINT ["bash", "docker.sh"]

#Exposition du port 80
EXPOSE 80

# Commande pour exécuter Apache
CMD ["apache2-foreground"]
