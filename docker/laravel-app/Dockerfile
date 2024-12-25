# Base image: PHP with FPM (lightweight)
FROM php:8.3-fpm-alpine

# Set working directory
WORKDIR /var/www/html

# Install necessary PHP extensions
RUN apk update && apk add --no-cache \
    libzip-dev \
    zip \
    && docker-php-ext-configure zip \
    && docker-php-ext-install zip pdo_mysql

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set Composer to allow superuser mode
ENV COMPOSER_ALLOW_SUPERUSER=1

# Copy application files
COPY --chown=www-data:www-data ../../ .

# Change ownership of files to www-data (or the user Nginx uses)
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 775 /var/www/html

# Copy the entrypoint.sh script into the container
COPY entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh

# Set the entrypoint script
ENTRYPOINT ["/bin/sh", "/entrypoint.sh"]

# Start PHP-FPM
CMD ["sh", "-c", "php-fpm"]
