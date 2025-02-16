#!/bin/bash

docker-compose down -v

if [ $? -eq 0 ]; then
    echo "Containers stopped successfully."
else
    echo "Error: Failed to stop containers."
fi
