#!/bin/bash

cd src || exit
docker-compose up -d --build
docker exec -it laraview php artisan key:generate
sleep 15 # wait for DB container to spin up
docker exec -it laraview php artisan migrate
