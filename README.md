<h3 align="center">Laraview</h3>
<p align="center">Laraview is a simple Laravel blog supporting multiple users, posts, and comments. Laraview draws its inspiration from [Medium's](medium.com) simplistic design, allowing you to quickly deploy a self-hosted blog in just a few steps.</p>

#

## Installation
Laraview is deployed via Docker and can be proxied through Traefik (which is included, you can reconfigure Laraview to work without Traefik). It runs on basic MySQL, PHP and Nginx containers.

### Traefik (optional)
Change to the traefik directory and run `docker-compose up -d` in either the `insecure` or `ssl` directory. Configure the `traefik.toml` file in the `ssl` directory if using Traefik to create SSL certs.

### MySQL
Copy the `init-db.env.example` file and save it as `init-db.env`. This will initialize the MySQL database with the information provided on the first build. These items will need to match what's in the `/laravel/.env` file.

### Laravel
Setup your `.env` variables. Use the `.env.example` template file for the basic setup. These are found in the laravel folder. NOTE: The DB host must be the DB Docker container name.

1) Install project dependencies. Navigate to the directory of the project and run:

```
php composer.phar install

OR

composer install
```

2) Generate a Laravel key:
```
php artisan key:generate
```

3) Start up docker containers:
```
docker-compose up -d
```

4) Migrate and create the database (do so inside the Docker container):
```
php artisan migrate
```

## Dependencies
For an exhaustive list of dependencies, see the [composer.json](/composer.json) file.
- [Parsedown](https://github.com/erusev/parsedown) - A simple markdown parser.