FROM php@sha256:f8816038aecbd2bcd2f29c662687cccb1151f9ee588f61e331be1fb12ad787d9

RUN docker-php-ext-install mysqli pdo pdo_mysql

RUN a2enmod rewrite

COPY .docker/apache/vhost.conf /etc/apache2/sites-available/000-default.conf

COPY . /var/www/html/

RUN mkdir -p /var/www/html/logs && \
    chown -R www-data:www-data /var/www/html && \
    find /var/www/html -type d -exec chmod 755 {} \; && \
    find /var/www/html -type f -exec chmod 644 {} \;

EXPOSE 80
