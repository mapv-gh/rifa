# Usar una imagen oficial de PHP con Apache
FROM php:8.2-apache

# Copiar los archivos de tu proyecto al servidor
COPY . /var/www/html/

# Configurar el puerto que usa Render (importante)
ENV PORT=8080
RUN sed -i "s/80/\${PORT}/g" /etc/apache2/sites-available/000-default.conf /etc/apache2/ports.conf

# Dar permisos
RUN chown -R www-data:www-data /var/www/html