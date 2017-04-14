FROM php:5.6-apache

MAINTAINER "Yannis Touili" <yannis@copromatic.com>

RUN docker-php-ext-install pdo pdo_mysql
RUN a2enmod rewrite

RUN apt-get update && apt-get install -y \
    git \
    unzip \
    ghostscript \
    xvfb \
    wget vim \
    libxrender1

RUN wget http://download.gna.org/wkhtmltopdf/0.12/0.12.4/wkhtmltox-0.12.4_linux-generic-amd64.tar.xz &&\
    tar xf wkhtmltox-0.12.4_linux-generic-amd64.tar.xz -C /home &&\
    ln -s /home/wkhtmltox/bin/wkhtmltopdf /usr/bin/wkhtmltopdf &&\
    rm wkhtmltox-0.12.4_linux-generic-amd64.tar.xz

RUN echo '#!/bin/bash\nxvfb-run -a --server-args="-screen 0, 1024x768x24" /usr/bin/wkhtmltopdf --dpi 1200 --zoom 1.28 -q $*' > /usr/bin/wkhtmltopdf.sh && \
    chmod a+x /usr/bin/wkhtmltopdf.sh && \
    ln -s /usr/bin/wkhtmltopdf.sh /usr/local/bin/wkhtmltopdf

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

COPY ./vhost/htmltopdf.conf /etc/apache2/sites-available/.
COPY ./vhost/htmltopdf.ini /usr/local/etc/php/conf.d

RUN  rm /etc/apache2/sites-enabled/000-default.conf && \
     ln -s /etc/apache2/sites-available/htmltopdf.conf /etc/apache2/sites-enabled/.

RUN usermod -u 1000 www-data

WORKDIR /var/www/htmlToPdfApi
