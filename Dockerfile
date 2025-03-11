
# Utilisation de l'image PHP avec Apache
FROM php:8.1-apache

# Activer les modules Apache nécessaires
RUN a2enmod rewrite

# Installer les extensions PHP nécessaires pour MySQL
RUN docker-php-ext-install pdo pdo_mysql

# Définir le répertoire de travail
WORKDIR /var/www/html

# Définir les permissions pour l'utilisateur www-data (Apache)
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

# Exécuter Apache en tant que www-data
USER www-data

# Exposer le port 80 pour Apache
EXPOSE 80

# Démarrer Apache
CMD ["apache2-foreground"]
