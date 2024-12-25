FROM nginx:latest

# Install Certbot and required tools
RUN apt-get update && apt-get install -y \
    cron \
    certbot \
    python3-certbot-nginx \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Copy the entrypoint script
COPY ./entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh

# Expose ports for HTTP and HTTPS
EXPOSE 80
EXPOSE 443

# Set the entrypoint script
ENTRYPOINT ["/entrypoint.sh"]
