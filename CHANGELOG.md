# Changelog

All notable changes to this project will be documented in this file.  
This project adheres to [Semantic Versioning](https://semver.org/).

---
## [v0.0.5] - Configured Nginx for SSL and HTTP to HTTPS Redirection
- Configured Nginx to handle SSL certificate installation automatically using Certbot.
- Set up redirection from HTTP to HTTPS for secure traffic.
- Integrated Certbot renewal mechanism with cron job for automatic SSL certificate renewal.
- Allowed domain settings to be configured in the `.env` file for dynamic Nginx configuration based on environment variables.

---
## [v0.0.4] - Added API Test Coverage for Telegram
- Developed comprehensive test cases for Telegram API interactions.
- Covered scenarios including valid and invalid access tokens, missing parameters, and successful message dispatch.
- Ensured alignment with `TelegramApiResource` response structure.

---
## [v0.0.3] - Added API Access Token Validation Middleware
- Implemented `CheckApiAccessToken` middleware to validate access tokens.
- Utilized `TelegramApiResource` for consistent JSON response formatting.
- Fixed issues with JSON response field order.
___

## [v0.0.2] - Set Up Laravel Framework

### Added
- Installed and configured Laravel framework for the development environment.
- Set up necessary dependencies and configurations for Laravel to work with Docker.
- Added initial `.env` configuration for Laravel environment.

---

## [v0.0.1] - SSL Automation and Initial Setup

### Added
- Implemented SSL automation for secure connections using Let's Encrypt.
- Integrated Docker and Laravel framework setup for development and production environments.
- Created initial project structure, including `docker-compose.yml` and `Dockerfile` for managing containers.
