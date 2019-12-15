#!/bin/bash

cd laravel || exit
docker-compose up --build -d
docker exec -it laraview php artisan key:generate
docker exec -it laraview php artisan migrate
history -c
