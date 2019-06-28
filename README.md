# Laraview
This is a simple Laravel Blog deployed via Docker (proxied through Traefik) running on MySQL and Nginx. 

Drawing on inspiration from [Medium's](medium.com) simplistic design, quickly deploy a self-hosted blog to your server. 

## Installation

### Traefik
Change to the traefik directory and run `docker-compose up -d` in either the `insecure` or `ssl` directory. Configure the `traefik.toml` file in the `ssl` directory if using Traefik to create SSL certs.

### MySQL
Copy the `init-db.env.example` file and save it as `init-db.env`. This will initialize the MySQL database with the information provided. These items will need to match what's in the `/laravel/.env` file.

### Laravel
Setup your .env variables. Use the .env.example template file for the basic setup. These are found in the laravel folder. The DB host must be the DB Docker container name.

1) Install project dependencies. Navigate to the directory of the project.

```
$ php composer.phar install

OR

$ composer install
```

2) Generate a Laravel Key
```
$ php artisan key:generate
```

3) Start up docker containers
```
$ docker-compose up -d
```

4) Migrate and create the database (do so inside the Docker container)
```
$ php artisan migrate
```
