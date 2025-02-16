#!/bin/bash

# Build and start the containers in detached mode
docker-compose up --build -d

docker exec -it laravel_app bash -c "
    composer install && \
    php artisan config:clear && \
    php artisan cache:clear && \
    php artisan route:clear && \
    php artisan view:clear && \
    chmod -R 775 storage/ && \
    chmod -R 775 public/ && \
    php artisan storage:link && \
    php artisan key:generate && \
    php artisan migrate --seed
"

# Start the Laravel development server
docker exec -it laravel_app bash -c "php artisan serve --host=0.0.0.0 --port=8000"
