#!/bin/bash

cd src || exit
docker-compose up -d --build
docker exec -it laraview php artisan key:generate
docker exec -it laraview php artisan migrate
