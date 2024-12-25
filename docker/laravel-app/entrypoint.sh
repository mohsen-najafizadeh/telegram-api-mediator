#!/bin/bash

# Exit on any error
set -e

# Trap errors to exit gracefully
trap 'echo "An error occurred. Exiting..."; exit 1' ERR

#set PHP_FPM config
sed -i 's/listen = 127.0.0.1:9000/listen = 0.0.0.0:9000/' /usr/local/etc/php-fpm.d/www.conf

# Set appropriate permissions for directories and files
find /var/www/html -type d -exec chmod 755 {} \;
find /var/www/html -type f -exec chmod 644 {} \;

# Run the composer install command
composer install --no-interaction --optimize-autoloader

# Set permissions for the vendor folder
chown -R www-data:www-data /var/www/html/vendor
chmod -R 775 /var/www/html/vendor

# Set permissions for other folders like storage and bootstrap/cache
chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache
chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Execute the main command (to continue the process)
exec "$@"
