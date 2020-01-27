# Laraview

[![Build Status](https://travis-ci.org/Justintime50/laraview.svg?branch=master)](https://travis-ci.org/Justintime50/laraview)
[![MIT Licence](https://badges.frapsoft.com/os/mit/mit.svg?v=103)](https://opensource.org/licenses/mit-license.php)

Laraview is a simple Laravel blog supporting multiple users, posts, and comments. Laraview draws its inspiration from [Medium](https://medium.com) and [Gatsby](https://www.gatsbyjs.org), using simplistic design - allowing you to quickly deploy a self-hosted blog in just a few simple steps.

Laraview is intended to remain lean. Currently, there is no support for photo storage (all files must be linked externally) and there is a single dependency aside from Laravel.

## Install

```bash
# Copy the env file and db init file, then edit both before continuing. The DB values must match in both files
cp src/.env.example src/.env
cp init-db.env.example init-db.env

# Start the Docker containers
docker-compose up -d

# Generate a Laravel key
docker exec -it laraview php artisan key:generate

# Run database migrations once the database container is up and able to access connections
docker exec -it laraview php artisan migrate
```

## Usage

The default login is `admin@laraview.com` and `password`. Currently, only this user can register as an admin. **Make sure to update the email/password after first login!**

### Install in Subfolder (Optional)

There is a guide on how to do this [here](https://serversforhackers.com/c/nginx-php-in-subdirectory).

### Traefik (optional)

The `docker-compose` file in this project uses Traefik for routing web traffic to it. You can either toss those references or follow the guide [here](https://github.com/Justintime50/multisite-docker-server) about configuring Traefik for this project.

## Development & Testing

### PHP Standards Fixer

PHP coding standards can be fixed automatically by running: 

```bash
php-cs-fixer fix laravel --verbose --show-progress=estimating
```

### Seeding Database

You can seed the database with dummy data by running the following:

```bash
docker exec -it laraview php artisan db:seed
```

### Testing

PHP linting and Docker build testing is handled via [Travis](https://travis-ci.org/Justintime50/laraview).
