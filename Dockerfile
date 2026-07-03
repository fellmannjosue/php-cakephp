# Runtime PHP con Apache para CakePHP (framework real).
FROM php:8.3-apache

# Dependencias del sistema + extensiones comunes (necesarias para composer install)
RUN apt-get update && apt-get install -y --no-install-recommends \
        unzip git libzip-dev libicu-dev libonig-dev \
    && docker-php-ext-install zip intl pdo_mysql mbstring \
    && rm -rf /var/lib/apt/lists/*

RUN a2enmod rewrite
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html
COPY . .
RUN composer install --no-dev --optimize-autoloader --no-interaction --ignore-platform-reqs

# DocumentRoot -> webroot/ (front controller de CakePHP) y permisos de escritura
RUN { \
      echo '<VirtualHost *:80>'; \
      echo '  DocumentRoot /var/www/html/webroot'; \
      echo '  <Directory /var/www/html/webroot>'; \
      echo '    AllowOverride All'; \
      echo '    Require all granted'; \
      echo '    DirectoryIndex index.php'; \
      echo '  </Directory>'; \
      echo '</VirtualHost>'; \
    } > /etc/apache2/sites-available/000-default.conf \
 && chmod -R 777 tmp logs

EXPOSE 80
