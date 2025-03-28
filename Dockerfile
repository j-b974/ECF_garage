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
FROM php:8.2-apache
# Configuration de l'environnement
ENV APACHE_DOCUMENT_ROOT=/var/www/public

# Installation des dépendances nécessaires
RUN apt-get update \
    && apt-get install -y --fix-missing\
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
        libmagickwand-dev --no-install-recommends \
        libpq-dev

# Installation des extensions PHP nécessaires
RUN docker-php-ext-install pdo_mysql mbstring zip exif pcntl

# Installer l'extension GD
RUN docker-php-ext-configure gd --with-freetype --with-jpeg --with-webp \
    && docker-php-ext-install -j$(nproc) gd

# Installer l'extension Imagick
RUN pecl install imagick
RUN docker-php-ext-enable imagick

# Installation de Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN composer --version

# Configuration Apache
RUN a2enmod rewrite

# Copie des fichiers de l'application dans le conteneur
COPY . /var/www/

# Copier les assets construits depuis l'étape node_build
COPY --from=node_build /var/www/public ./public

# remplace la configuration de apache
COPY ./ServerGarage.conf /etc/apache2/sites-available/000-default.conf

# Configuration du propriétaire des fichiers
RUN chown -R www-data:www-data /var/www/
# Installation des dépendances avec Composer

RUN cd /var/www/ && \
composer update --no-interaction --no-ansi && composer install --no-interaction --no-ansi

# change emplacement curseur commande
WORKDIR /var/www/

#
ENTRYPOINT ["bash", "docker.sh"]

#Exposition du port 80
EXPOSE 80

# Commande pour exécuter Apache
CMD ["apache2-foreground"]
