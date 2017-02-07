FROM php:7.1-apache

MAINTAINER "Yannis Touili" <yannis@copromatic.com>

RUN docker-php-ext-install pdo pdo_mysql
RUN a2enmod rewrite

RUN apt-get update && apt-get install -y \
    git \
    unzip \
    ghostscript wkhtmltopdf

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

COPY ./vhost/htmltopdf.conf /etc/apache2/sites-available/.
COPY ./vhost/localtime.ini /usr/local/etc/php/conf.d

RUN  rm /etc/apache2/sites-enabled/000-default.conf && \
     ln -s /etc/apache2/sites-available/htmltopdf.conf /etc/apache2/sites-enabled/.


RUN usermod -u 1000 www-data

WORKDIR /var/www/datacopro