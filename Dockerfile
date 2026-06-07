FROM php:8.2-apache

# Install mysqli extension for PHP to connect to MySQL
RUN docker-php-ext-install mysqli && docker-php-ext-enable mysqli

# Enable Apache mod_rewrite for nice URLs (optional but good practice)
RUN a2enmod rewrite

# Copy all project files into the container's web root
COPY . /var/www/html/

# Expose port 80 to the web
EXPOSE 80
