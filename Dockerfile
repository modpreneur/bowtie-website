FROM php:5.6-apache

MAINTAINER Luke Vlcek <luke@modpreneur.com>

# Install PHP5 and modules along with composer binary
RUN apt-get update
RUN apt-get -y install \
    curl \
    git \
    libcurl4-openssl-dev

RUN docker-php-ext-install curl json mbstring opcache

# prepare php and apache
RUN rm -rf /etc/apache2/sites-available/* /etc/apache2/sites-enabled/*

ENV APP_DOCUMENT_ROOT /var/app/www
ENV APACHE_RUN_USER www-data
ENV APACHE_RUN_GROUP www-data
ENV APACHE_LOG_DIR /var/log/apache2

ADD docker/php.ini /usr/local/etc/php/
ADD docker/000-default.conf /etc/apache2/sites-available/000-default.conf

WORKDIR /var/app
EXPOSE 80 443

# Install composer
RUN curl -sS https://getcomposer.org/installer | php \
    && cp composer.phar /usr/bin/composer

# Install app
RUN rm -rf /var/app/*
ADD . /var/app

# Fix permissions
RUN mkdir -p temp/ \
    && mkdir -p log/ \
    && chmod 0777 -R temp/ \
    && chmod 0777 -R log/

# enable apache and mod rewrite
RUN a2ensite 000-default.conf \
    && a2enmod expires \
    && a2enmod rewrite \
    && service apache2 restart