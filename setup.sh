#!/bin/bash

cd src || exit
docker-compose up --build -d
docker exec -it laraview php artisan key:generate
sleep 10 # wait for DB container to spin up
docker exec -it laraview php artisan migrate
