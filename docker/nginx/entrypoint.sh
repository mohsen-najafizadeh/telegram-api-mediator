#!/bin/bash

# Trap signals to gracefully exit
trap "exit" SIGHUP SIGINT SIGTERM

# Validate DOMAIN and EMAIL
if [ -z "$DOMAIN" ] || [ -z "$EMAIL" ]; then
    echo "Error: DOMAIN and EMAIL environment variables must be set."
    exit 1
fi
# Validate PHP_FPM_HOST and PHP_FPM_PORT]
if [ -z "$PHP_FPM_HOST" ] || [ -z "$PHP_FPM_PORT" ]; then
    echo "Error: PHP_FPM_HOST and PHP_FPM_PORT environment variables must be set."
    exit 1
fi

# Step 1: Generate initial Nginx configuration for HTTP with Certbot route

# Create directory for Certbot validation files
mkdir -p /var/www/certbot

# Paths and configurations
NGINX_CONFIG_PATH="/etc/nginx/conf.d/default.conf"
WEBROOT_PATH="/var/www/html"
CERT_DIR="/etc/letsencrypt/live"

cat <<EOF > $NGINX_CONFIG_PATH
server {
    listen 80;
    server_name $DOMAIN;

    # Route for Certbot validation
    location /.well-known/acme-challenge/ {
        root /var/www/certbot;
    }

    # Main application route
    location / {
        try_files \$uri \$uri/ /index.php?\$query_string;
    }

    # PHP-FPM settings
    location ~ \.php\$ {
        include fastcgi_params;
        fastcgi_pass $PHP_FPM_HOST:$PHP_FPM_PORT;
        fastcgi_index index.php;
        fastcgi_param SCRIPT_FILENAME \$document_root\$fastcgi_script_name;
    }

    location ~ /\.ht {
        deny all;
    }
}
EOF

# Start Nginx to handle HTTP requests
nginx &

# Step 2: Obtain SSL certificate with Certbot
echo "Attempting to obtain SSL certificate for $DOMAIN..."
if certbot certonly --webroot --webroot-path=/var/www/certbot --non-interactive --agree-tos --email "$EMAIL" -d "$DOMAIN"; then
    echo "SSL certificate successfully obtained."
else
    echo "Error: Failed to obtain SSL certificate."
    exit 1
fi

# Step 3: Update Nginx configuration for HTTPS
cat <<EOF > $NGINX_CONFIG_PATH
server {
    listen 80;
    server_name $DOMAIN;

    # Redirect HTTP to HTTPS
    return 301 https://\$host\$request_uri;
}

server {
    listen 443 ssl;
    server_name $DOMAIN;

    root $WEBROOT_PATH/public;
    index index.php index.html;

    ssl_certificate $CERT_DIR/$DOMAIN/fullchain.pem;
    ssl_certificate_key $CERT_DIR/$DOMAIN/privkey.pem;

    # Main application route
    location / {
        try_files \$uri \$uri/ /index.php?\$query_string;
    }

    # PHP-FPM settings
    location ~ \.php\$ {
        include fastcgi_params;
        fastcgi_pass $PHP_FPM_HOST:$PHP_FPM_PORT;
        fastcgi_index index.php;
        fastcgi_param SCRIPT_FILENAME \$document_root\$fastcgi_script_name;
    }

    location ~ /\.ht {
        deny all;
    }
}
EOF

# Reload Nginx with the updated configuration
echo "Reloading Nginx with HTTPS configuration..."
nginx -s reload

# Start cron service
service cron start

# Schedule certificate renewal
echo "Scheduling certificate renewal every 12 hours..."
echo "0 */12 * * * certbot renew --quiet && nginx -s reload" | crontab -

# Start cron in the foreground
echo "Starting cron job for certificate renewal..."
cron -f

# Keep the container running
echo "Nginx is running. Logs are being displayed..."
tail -f /var/log/nginx/access.log /var/log/nginx/error.log
