FROM php:8.2-apache

RUN apt-get update && apt-get install -y \
    libonig-dev \
    && docker-php-ext-install mysqli mbstring pdo_mysql \
    && docker-php-ext-enable mysqli mbstring

RUN a2enmod rewrite

RUN apt-get clean && rm -rf /var/lib/apt/lists/*
