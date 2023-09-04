<div align="center">

# Glass

Minimalist blog featuring syntax highlighting, images, comments, themes, RSS, and SEO out of the box.

[![Build Status](https://github.com/Justintime50/glass/workflows/build/badge.svg)](https://github.com/Justintime50/glass/actions)
[![Coverage Status](https://coveralls.io/repos/github/Justintime50/glass/badge.svg?branch=main)](https://coveralls.io/github/Justintime50/glass?branch=main)
[![Version](https://img.shields.io/github/v/tag/justintime50/glass)](https://github.com/justintime50/glass/releases)
[![Licence](https://img.shields.io/github/license/justintime50/glass)](LICENSE)

<img src="https://raw.githubusercontent.com/justintime50/assets/main/src/glass/showcase.png" alt="Showcase">

</div>

Glass draws its simplistic design inspiration from [Medium](https://medium.com) and [Gatsby](https://www.gatsbyjs.org). Glass allows you to quickly deploy a self-hosted blog in just a few simple steps.

## Features

- Custom image support per post
- Comments (can be enabled/disabled)
- Syntax highlighting for code snippets
- Themes to style your blog instance
- RSS feed so users can easily stay up-to-date with the latest posts `/feed`
- SEO built right in with custom tags per post
- Admin panel to manage posts, comments, and users
- ReCaptcha on user signup by populating the `NOCAPTCHA_SECRET` and `NOCAPTCHA_SITEKEY` env variables in production

## Install

```bash
# Copy the env files, and edit as needed
cp src/.env-example src/.env && cp .env-example .env

# Run the setup script which will bootstrap all the requirements, spin up the service, and migrate the database
just setup
```

### Install in Subfolder (Optional)

There is a guide on how to do this [here](https://serversforhackers.com/c/nginx-php-in-subdirectory).

## Usage

Visit `glass.localhost` in a browser to get started.

### Default Login

The default login is `admin@glass.com` and `password`. **Make sure to update the email/password after first login!**

## Deploy

```bash
# Deploy the project locally
just run

# Deploy the project in production
just prod
```

## Development

```bash
# Get a comprehensive list of development tools
just --list
```
