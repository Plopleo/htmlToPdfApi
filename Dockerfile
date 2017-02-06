FROM php:7.1-apache

MAINTAINER "Yannis Touili" <yannis@copromatic.com>

RUN apt-get update && apt-get install -y \
    git \
    unzip \
    ghostscript wkhtmltopdf

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN a2enmod rewrite

COPY ./vhost/htmltopdf.conf /etc/apache2/sites-available/.

RUN  rm /etc/apache2/sites-enabled/000-default.conf && \
     ln -s /etc/apache2/sites-available/htmltopdf.conf /etc/apache2/sites-enabled/.

RUN docker-php-ext-install pdo pdo_mysql

RUN usermod -u 1000 www-data

WORKDIR /var/www/datacopro