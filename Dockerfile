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
COPY --from=composer:2.7.6 /usr/bin/composer /usr/bin/composer

COPY . .

# Ensure necessary directories exist and set permissions
RUN chown -R www-data:www-data /var/www/html \
    && chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache \
    && chmod -R 775 /var/www/html/storage \
    && chmod -R 775 /var/www/html/bootstrap/cache

# Install Laravel dependencies
RUN composer install --no-dev --prefer-dist --verbose --no-progress\
    && composer clear-cache

# Ensure vendor permissions are correct
RUN chown -R www-data:www-data /var/www/html/vendor \
    && chmod -R 775 /var/www/html/vendor

# Expose port
EXPOSE 9000

# Start PHP-FPM
CMD ["php-fpm"]
