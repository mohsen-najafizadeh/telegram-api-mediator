# Base image: PHP with FPM (lightweight)
FROM php:8.3-fpm-alpine

# Install necessary PHP extensions
RUN apk update && apk add --no-cache \
    libzip-dev \
    zip \
    && docker-php-ext-configure zip \
    && docker-php-ext-install zip pdo_mysql

# Install Composer
COPY --from=composer:2.7.6 /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www

# Copy application files
COPY . .

RUN COMPOSER_ALLOW_SUPERUSER=1

# Ensure necessary directories exist and set permissions
RUN chown -R www-data:www-data /var/www/html \
    && chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache \
    && chmod -R 775 /var/www/storage \
    && chmod -R 775 /var/www/bootstrap/cache

# Install Laravel dependencies
RUN composer install --no-dev --prefer-dist \
    && composer clear-cache

# Ensure vendor permissions are correct
RUN chown -R www-data:www-data /var/www/vendor \
    && chmod -R 775 /var/www/vendor

# Expose port
EXPOSE 9000

# Start PHP-FPM
CMD ["php-fpm"]
