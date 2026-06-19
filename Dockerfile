FROM php:8.2-apache

RUN docker-php-ext-install mysqli pdo pdo_mysql

# Fuerza un único MPM (prefork). Elimina los .load de event/worker para que
# no quede "More than one MPM loaded" sin importar el estado de la imagen base.
RUN a2dismod mpm_event mpm_worker 2>/dev/null; \
    rm -f /etc/apache2/mods-enabled/mpm_event.* \
          /etc/apache2/mods-enabled/mpm_worker.*; \
    a2enmod mpm_prefork && \
    a2enmod rewrite && \
    echo "=== MPM modules enabled ===" && \
    ls -l /etc/apache2/mods-enabled/ | grep mpm && \
    apache2ctl -M 2>&1 | grep -i mpm

COPY .docker/apache/vhost.conf /etc/apache2/sites-available/000-default.conf

COPY . /var/www/html/

RUN mkdir -p /var/www/html/logs && \
    chown -R www-data:www-data /var/www/html && \
    find /var/www/html -type d -exec chmod 755 {} \; && \
    find /var/www/html -type f -exec chmod 644 {} \;

EXPOSE 80
