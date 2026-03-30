FROM php:7.4-apache

# mysqli install
RUN docker-php-ext-install mysqli

# Apache mod_rewrite activation
RUN a2enmod rewrite