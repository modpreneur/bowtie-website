FROM php:7-apache

MAINTAINER Luke Vlcek <luke@modpreneur.com>

# Install PHP5 and modules along with composer binary
RUN apt-get clean \
    && apt-get update \
    && apt-get -y install curl git libcurl4-openssl-dev wget zlib1g-dev

RUN docker-php-ext-install curl json mbstring opcache zip

# prepare php and apache
RUN rm -rf /etc/apache2/sites-available/* /etc/apache2/sites-enabled/*

ADD docker/php.ini /usr/local/etc/php/
ADD docker/000-default.conf /etc/apache2/sites-available/000-default.conf

WORKDIR /var/app

EXPOSE 80

# Install composer
RUN sh composer_install.sh

# Install app
ADD . /var/app

# Fix permissions
RUN chmod 0777 -R temp/ \
    && chmod 0777 -R log/ \
    && chmod 0777 -R www/temp/

RUN php composer.phar install --no-scripts --optimize-autoloader

# enable apache and mod rewrite
RUN a2ensite 000-default.conf \
    && a2enmod expires \
    && a2enmod rewrite \
    && service apache2 restart