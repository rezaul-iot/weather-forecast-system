FROM php:8.1-apache

# Install PHP extensions for MySQL
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Enable Apache rewrite module (optional)
RUN a2enmod rewrite

# Copy your project files
COPY . /var/www/html/

# Set working directory (optional)
WORKDIR /var/www/html

# Expose default port
EXPOSE 80
