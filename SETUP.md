# Telegram API Mediator
# Quick Start Guide: Run the Project with Docker Anywhere

---

## Prerequisites

Before starting, ensure you have the following installed:

- [Docker](https://www.docker.com/)
- [Docker Compose](https://docs.docker.com/compose/)

---

## Setup Instructions

### 1. Clone the Repository
```bash
git clone https://github.com/mohsen-najafizadeh/telegram-api-mediator.git
```
```bash
cd telegram-api-mediator
```

### 2. Configure Environment Variables

- Make a copy of the `.env.example` file and name it `.env`:
  ```bash
  cp .env.example .env
  ```
- Open the `.env` file and update the required environment variables. Example variables:
  ```env
  APP_ENV=local
  APP_DEBUG=false
  APP_URL=http://localhost
  ```

### 3. Local Environment Setup

Run the following command to start the local environment:
```bash
docker compose --profile local up --build
```

- Access the application at: `http://localhost`

### 4. Production Environment Setup

1. Update `.env` with production-specific variables:
   ```env
   APP_ENV=production
   APP_DEBUG=false
   APP_URL=https://production-domain.com
   EMAIL_FOR_SSL=your-email@example.com
   DOMAINS_FOR_SSL=your-production-domain.com
   ```

2. Start the production environment:
   ```bash
   docker compose --profile production up --build
   ```

3. Ensure Certbot generates SSL certificates successfully and that Nginx serves the application over HTTPS.

---

## Notes
- **Local Environment:**
    - No SSL is configured for local development.

- **Production Environment:**
    - Ensure that the domain(s) specified in `CERTBOT_DOMAINS` point to your server's public IP.
    - Certbot will fail if the domain does not resolve correctly.

- This setup has only been tested locally. Additional testing and adjustments may be needed for production environments.

---

## Troubleshooting

- If Certbot fails to generate certificates:
    - Check if the domain resolves to your server.
    - Ensure ports 80 and 443 are open in your firewall settings.

- If containers fail to start:
    - Use `docker compose logs <service-name>` to inspect logs for errors.

---

For further questions or issues, please refer to the repository's issue tracker or contact the maintainer.

