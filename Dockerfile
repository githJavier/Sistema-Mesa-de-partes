FROM php:8.2-apache

RUN docker-php-ext-install mysqli pdo pdo_mysql

# Asegura un único MPM activo (prefork) — evita "More than one MPM loaded"
RUN a2dismod mpm_event mpm_worker 2>/dev/null || true && \
    a2enmod mpm_prefork && \
    a2enmod rewrite

COPY .docker/apache/vhost.conf /etc/apache2/sites-available/000-default.conf

COPY . /var/www/html/

RUN mkdir -p /var/www/html/logs && \
    chown -R www-data:www-data /var/www/html && \
    find /var/www/html -type d -exec chmod 755 {} \; && \
    find /var/www/html -type f -exec chmod 644 {} \;

EXPOSE 80
