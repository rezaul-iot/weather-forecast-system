# Base image with PHP and Apache
FROM php:8.1-apache

# Enable Apache rewrite module if needed
RUN a2enmod rewrite

# Copy all files to the Apache root
COPY . /var/www/html/

# (Optional) Set working directory
WORKDIR /var/www/html

# Expose the default Apache port
EXPOSE 80
