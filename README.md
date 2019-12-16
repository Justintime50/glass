# Laraview

[![Build Status](https://travis-ci.org/Justintime50/laraview.svg?branch=master)](https://travis-ci.org/Justintime50/laraview)
[![MIT Licence](https://badges.frapsoft.com/os/mit/mit.svg?v=103)](https://opensource.org/licenses/mit-license.php)

Laraview is a simple Laravel blog supporting multiple users, posts, and comments. Laraview draws its inspiration from [Medium](https://medium.com) and [Gatsby](https://www.gatsbyjs.org), using simplistic design - allowing you to quickly deploy a self-hosted blog in just a few simple steps.

Laraview is intended to remain lean. Currently, there is no support for photo storage (all files must be linked externally) and there is a single dependency aside from Laravel.

## Installation

1) This project requires [Docker](https://www.docker.com/products/docker-desktop) and an account. Install and login to Docker.
2) Run `cp init-db.env.example init-db.env` and change the values to your preferred details. This will initialize the MySQL database with the information provided on the first build. These items will need to match what's in the `/laravel/.env` file.
3) `cd` into `/src` and run `cp .env.example .env` and setup your `.env` variables.
4) Run `./setup.sh` in the project's root directory.
5) You must manually add a first user and configure a `settings` entry in the `settings` table.

The first user registered will become the admin user of the blog (see `gotchas` below).

### Install in Subfolder (Optional)

There is a guide on how to do this [here](https://serversforhackers.com/c/nginx-php-in-subdirectory).

### Traefik (optional)

The `docker-compose` file in this project uses Traefik for routing web traffic to it. You can either toss those references or follow the guide [here](https://github.com/Justintime50/multisite-docker-server) about configuring Traefik for this project.

## Testing/Development

### Development PHP Fixer

PHP coding standards can be fixed automatically by running: 
```bash
php-cs-fixer fix laravel --verbose --show-progress=estimating
```

### Testing

PHP linting and Docker build testing is handled via [Travis](https://travis-ci.org/Justintime50/laraview).

## Gotchas

### Admins
Currently, the only admin user is whatever user has `user->id = 1`. All other users will become normal users, able to comment but not create posts etc. Additional admin permissions coming later.
