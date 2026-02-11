# Usamos la imagen oficial de PHP con Apache
FROM php:8.2-apache

# 1. Habilitamos mod_rewrite (ESTO ES LO QUE TE FALTA)
RUN a2enmod rewrite

# 2. Copiamos tus archivos al servidor
COPY . /var/www/html/

# 3. Configuramos el puerto para que Render no se queje
ENV PORT=8080
RUN sed -i "s/80/\${PORT}/g" /etc/apache2/sites-available/000-default.conf /etc/apache2/ports.conf

# 4. Ajustamos permisos para evitar errores de escritura
RUN chown -R www-data:www-data /var/www/html