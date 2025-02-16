# Use official PHP image as base
FROM php:8.1-apache

# Install dependencies for Laravel
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libzip-dev \
    git \
    unzip \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd zip pdo pdo_mysql


# Enable Apache mod_rewrite for Laravel
RUN a2enmod rewrite

# Set working directory
WORKDIR /var/www/html

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Ensure correct permissions before running Composer
RUN chown -R www-data:www-data /var/www/html && chmod -R 775 /var/www/html

# Expose port 80 for the container
EXPOSE 80

