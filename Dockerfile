# Usamos la imagen base
FROM php:8.2-apache

# 1. Instalamos la extensión para MySQL (ESTO ES LO NUEVO QUE NECESITAS)
RUN docker-php-ext-install mysqli && docker-php-ext-enable mysqli

# 2. Habilitamos mod_rewrite (para tu .htaccess)
RUN a2enmod rewrite

# 3. Copiamos los archivos
COPY . /var/www/html/

# 4. Configuración del puerto de Render
ENV PORT=8080
RUN sed -i "s/80/\${PORT}/g" /etc/apache2/sites-available/000-default.conf /etc/apache2/ports.conf

# 5. Permisos
RUN chown -R www-data:www-data /var/www/html