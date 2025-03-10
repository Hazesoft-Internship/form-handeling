FROM php:8.2-fpm

# Install mysqli extension
RUN docker-php-ext-install mysqli

# Copy application files
COPY . /var/www/html

# Set working directory
WORKDIR /var/www/html
