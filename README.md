<div align="center">

# Glass

Minimalist blog featuring WYSIWYG editor, syntax highlighting, images, comments, themes, RSS, and SEO out of the box.

[![CI Status](https://github.com/Justintime50/glass/workflows/ci/badge.svg)](https://github.com/Justintime50/glass/actions)
[![Coverage Status](https://img.shields.io/codecov/c/github/justintime50/glass)](https://app.codecov.io/github/Justintime50/glass)
[![Version](https://img.shields.io/github/v/tag/justintime50/glass)](https://github.com/justintime50/glass/releases)
[![Licence](https://img.shields.io/github/license/justintime50/glass)](LICENSE)

<img src="https://raw.githubusercontent.com/justintime50/assets/main/src/glass/showcase.png" alt="Showcase">

</div>

Glass draws its simplistic design inspiration from [Medium](https://medium.com) and [Gatsby](https://www.gatsbyjs.org) - striving for minimalism and elegance like a pane of Glass. Glass allows you to quickly deploy a self-hosted blog in just a few simple steps.

## Features

- WYSIWYG editor - renders rich text, images, code snippets, YouTube and Twitter embeds
- Custom image support per post (local storage or S3 configurable)
- Comments (can be enabled/disabled)
  - Comment email notifications to admins
- Syntax highlighting for code snippets (use single or triple backticks)
- Themes to style your blog instance
- RSS feed so users can easily stay up-to-date with the latest posts via `/feed`
- SEO out of the box with custom tags per post
- Admin panel to manage posts, comments, categories, and users
- ReCaptcha on user signup by populating the `NOCAPTCHA_SECRET` and `NOCAPTCHA_SITEKEY` env variables in production

## Install

```bash
# Copy the env files, and edit as needed
cp src/.env-example src/.env && cp .env-example .env

# Run the setup script which will bootstrap all the requirements, spin up the service, and migrate the database
just setup
```

## Usage

Visit `glass.localhost` in a browser to get started.

### Default Login

The default login is `admin@glass.com` and `password`. **Make sure to update the email/password after first login!**

## Development

```bash
# Get a comprehensive list of development tools
just --list
```
