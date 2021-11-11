<div align="center">

# Glass

Minimalist blog featuring syntax highlighting, images, comments, themes, RSS, and SEO out of the box.

[![Build Status](https://github.com/Justintime50/glass/workflows/build/badge.svg)](https://github.com/Justintime50/glass/actions)
[![Licence](https://img.shields.io/github/license/justintime50/glass)](LICENSE)

<img src="https://raw.githubusercontent.com/justintime50/assets/main/src/glass/showcase.png" alt="Showcase">

</div>

Glass draws its simplistic design inspiration from [Medium](https://medium.com) and [Gatsby](https://www.gatsbyjs.org). Glass allows you to quickly deploy a self-hosted blog in just a few simple steps.

**Features**

* Custom image support per post
* Comments (can be enabled/disabled)
* Syntax highlighting for code snippets
* Themes to style your blog instance
* RSS feed so users can easily stay up-to-date with the latest posts `/feed`
* SEO built right in with custom tags per post
* Admin panel to manage posts, comments, and users

## Install

```bash
# Copy the env file and db init file, then edit both before continuing. The DB values must match in both files
cp src/.env-example src/.env
cp database.env-example database.env

# Start the dev environment (assumes you have Traefik setup)
docker-compose up -d

# Generate a Laravel key
cd src && php artisan key:generate

# Run database migrations once the database container is up and able to access connections
docker exec -it glass-glass-1 php artisan migrate
```

### Install in Subfolder (Optional)

There is a guide on how to do this [here](https://serversforhackers.com/c/nginx-php-in-subdirectory).

## Usage

### Default Login

The default login is `admin@glass.com` and `password`. **Make sure to update the email/password after first login!**

Visit `glass.localhost` in a browser to get started.

### Deploy to Production

```bash
# Deploy the project to production
docker-compose -f docker-compose.yml -f docker-compose-prod.yml up -d
```

## Development

```bash
# Install dev dependencies
cd src && composer install -q --no-ansi --no-interaction --no-scripts --no-suggest --no-progress --prefer-dist

# Run tests
composer test

# Lint the PHP files
composer lint
# Lint the SASS files
npm run lint

# Compile SASS and Javascript during development
npm run dev

# Compile for production
npm run prod

# Watch for CSS and Javascript changes
npm run watch
```

### Seeding Database

You can seed the database with 5 dummy users and 5 dummy posts by running the following:

```bash
docker exec -it glass-glass-1 php artisan db:seed
```
