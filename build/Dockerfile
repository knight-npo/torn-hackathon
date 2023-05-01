FROM composer:2.5.5 as build

WORKDIR /tmp

COPY composer.json composer.json
COPY composer.lock composer.lock

RUN composer install \
    --ignore-platform-reqs \
    --no-interaction \
    --no-plugins \
    --no-scripts \
    --prefer-dist

FROM php:8.2.5-apache

RUN apt update && apt install -y cron
RUN a2enmod rewrite
RUN docker-php-ext-install pdo pdo_mysql

RUN mkdir -p /home/root/logs
RUN mkdir -p /var/www/html/compilation_cache
RUN chown www-data:www-data /var/www/html/compilation_cache
RUN chmod 1777 /var/www/html/compilation_cache

COPY --from=build /tmp/vendor/ /var/www/html/vendor/
COPY cron/cron /home/root/cron

COPY app /var/www/html/app
COPY public /var/www/html/public
COPY .htaccess /var/www/html/
COPY index.php /var/www/html/

RUN crontab /home/root/cron
CMD env | grep -E 'DB_|API_' | xargs -I {} echo "export {}" >> ~/.profile && \
    service cron start && apache2-foreground
