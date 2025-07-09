FROM php:5.6.40-apache
RUN sed -i -e 's/deb.debian.org/archive.debian.org/g' \
           -e 's|security.debian.org|archive.debian.org/|g' \
           -e '/stretch-updates/d' /etc/apt/sources.list

RUN apt-get -y update && apt-get install -y --allow-unauthenticated libpq-dev
RUN docker-php-ext-install pgsql pdo pdo_pgsql
RUN a2enmod rewrite 

WORKDIR /var/www/html
COPY . /var/www/html

EXPOSE 80