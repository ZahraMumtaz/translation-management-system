# Project Setup

## Overview
This project is set up using Docker, with a pre-configured PHP environment and required dependencies. The setup includes `Dockerfile`, `docker-compose.yml`,`.dockerignore`, `start.sh` and `stop.sh` file.

## Docker Configuration
- The **Dockerfile** configures the PHP environment with all required dependencies.
- The container exposes **port 80**.

## Docker Compose
- The `docker-compose.yml` file defines all necessary services.
- The Laravel project image is named **laravel_app**.

## Entry Point
- The entry point for the project is `start.sh`, which includes all required Laravel Artisan commands.
- To start the project, run the following command in the terminal:
  ```bash
  ./start.sh
  ```
- Wait for the required dependencies to install.
- The project will be served at **127.0.0.1:8000**.

## Stopping the Project
- To stop the project, run the following command:
  ```bash
  ./stop.sh

- Wait for the required dependencies to install.
- The project will be served at **127.0.0.1:8000**.

## Environment Configuration
- The **outside** `.env` file contains database credentials configured inside container for sql image.
- The **inside** `.env` file should have the same credentials for database.
- Update the `.env` file accordingly to ensure correct database configuration.

**Point To Note**
Command to migrate and seed may take time as the `TranslationSeeder` creatng 100K records as per the requirement

### .env File Configuration
```plaintext
DB_CONNECTION=mysql
DB_HOST=db
DB_PORT=3306
DB_DATABASE=translationManagement
DB_USERNAME=newuser
DB_PASSWORD=newpassword
DB_ROOT_PASSWORD=root
```

## Troubleshooting
If the project does not start or encounters issues, try running the following commands manually:

```bash
docker-compose up --build
```

To view created images:
```bash
docker ps -a
```

If the image is successfully built but composer dependencies cause issues, run:
```bash
docker exec -it laravel_app bash
composer install
php artisan migrate --seed
php artisan serve
```

Monitor logs to identify potential issues.

## Health Check Endpoint
Once the project is running successfully, verify it by hitting the health check endpoint:
```plaintext
http://localhost:8000/api/health
```
Expected response:
```json
{
  "status": "ok",
  "message": "API is UP and running"
}
```

## Endpoints
The base URL for the API is: 
```http://127.0.0.1:8000```
For a detailed list of API endpoints, request formats, responses, and authentication requirements, please refer to the Postman API documentation:
[API Documentation](https://documenter.getpostman.com/view/8411947/2sAYXEFJuC)
