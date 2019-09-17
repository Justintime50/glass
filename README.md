# Laraview
Laraview is a simple Laravel blog supporting multiple users, posts, and comments. Laraview draws its inspiration from [Medium](https://medium.com) and [Gatsby](https://www.gatsbyjs.org), using simplistic design - allowing you to quickly deploy a self-hosted blog in just a few simple steps.

Laraview is intended to remain lean. Currently, there is no support for photo storage (all files must be linked externally) and there is a single dependency aside from Laravel.

## Installation
Laraview is deployed via Docker and can be proxied through Traefik (which is included, you can reconfigure Laraview to work without Traefik). It runs on basic MySQL, PHP and Nginx containers. The first user registered will become the admin user of the blog (see `gotchas` below).

### Database

You must manually add a first user and manually configure a single `settings` entry in the `settings` table.

### Install in Subfolder (Optional)

There is a guide on how to do this [here](https://serversforhackers.com/c/nginx-php-in-subdirectory).

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
docker-compose build

docker-compose up -d
```

4) Migrate and create the database (do so inside the Docker container):
```
php artisan migrate
```

## Gotchas

### Admins
Currently, the only admin user is whatever user has `user->id = 1`. All other users will become normal users, able to comment but not create posts etc. Additional admin permissions coming later.

## Dependencies
For an exhaustive list of dependencies, see the [composer.json](/composer.json) file.
- [Parsedown](https://github.com/erusev/parsedown) - A simple markdown parser.
