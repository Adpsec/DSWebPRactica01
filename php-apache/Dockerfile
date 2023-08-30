# Utiliza una imagen base de PHP con Apache
FROM php:7.2-apache

# Instala el cliente PostgreSQL
RUN apt-get update && apt-get install -y libpq-dev && docker-php-ext-install pdo pdo_pgsql

# Copia tu archivo PHP al directorio del sitio web en el contenedor
COPY index.php /var/www/html/

# Puerto en el que Apache escuchará
EXPOSE 80


