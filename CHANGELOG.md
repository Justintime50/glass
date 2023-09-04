# CHANGELOG

## Next Release

- Completely overhauls all routes to follow RESTful practices
- Swap `updated_at` to `created_at` timestamps for posts and comments
- Removes the unusable "Remember Me" checkbox on the login page
- Added prompts before deletion on the admin page for categories and posts
- Fixes a 403 issue for the default image preview when editing a post
- Fixes a bug that didn't properly validation reCAPTCHA on user registration
- Fixes the styling of tables on any theme other than `light` to properly show the theme colors (admin panel)

## v0.14.0 (2023-04-05)

- Upgrades from Laravel 9 to 10
- Migrates from Webpack to Vite
- Fixes admin page category table pagination
- Fixes post comment avatar paths
- Bumps all dependencies

## v0.13.0 (2023-02-19)

- Adds an image gallery selection to the create and edit post screens. Previously, you'd need to visit the Image Library, copy the image name, go back to your post, paste in the image name to a field, and be on your way (closes #68)
- Fixes a bug where retrieving posts by category didn't work due to a variable name error
- Adds better factories and seeders including posts now getting assigned a random user, each post containing comments, and better under-the-hood config for seeders
- Removes `user_id` from Category model
- Various other improvements and bug fixes

## v0.12.1 (2022-09-17)

- Slug URL fields no longer replace apostrophes with dashes but instead just remove them for better slugs with apostrophes

## v0.12.0 (2022-07-19)

- Dynamically generate an articles reading time instead of expecing authors to come up with this and store it in the database. (This will require a database migration to remove the `reading_time` column from the `posts` table)

## v0.11.0 (2022-06-21)

- Switches from file based sessions to database sessions (must migrate DB)
- Completely overhauls the storage system for images and consolidates logic while protecting against incorrect instance setup
  - Fixes a bug that prevented the `/images` page from loading on a new Glass instance due to a missing required directory
  - Renames the `public/post-images` directory to `public/images/posts` (you will need to migrate your images manually)
  - Renames the `public/avatars` directory to `public/images/avatars` (you will need to migrate your images manually)
- Complete image overhaul (closes #68)
  - The image library page now properly scales images to a more uniform size
  - Adds the ability to download images from the image library page
- Complete category overhaul (closes #67)
  - Enforces unique category names
  - Adds the ability to filter post results by category (clicking the category name on a single post or selecting a category from the bottom of the posts page)
  - Adds the ability to update category names
- Removes the ability for the authenticated user to delete themselves or alter their role
- Adds the ability to update your own password
- Incorporates the `Pineapple` CSS and JS library for easier development

## v0.10.0 (2022-03-24)

- Migrates from Bootstrap 4 to 5, removes Lodash, jQuery, Vue, and other unused frontend dependencies
- Adds `sentry` integration

## v0.9.0 (2022-02-27)

- Bumped Laravel from v6 to v9
- Bumped PHP from 7.4 to 8.1
- Bumped all dependencies
- Fixes a bug where creating a user would fail in dev mode or with no recaptcha key specified due to a syntax error

## v0.8.0 (2022-01-17)

- Adds `ReCaptcha` to user signups if `NOCAPTCHA_SECRET` and `NOCAPTCHA_SITEKEY` env variables are set when `APP_ENV` is `production`
- Reworks themes, adds a new `dark` theme as well as a `amethyst` theme
- Bumps dependencies
- Reworks the instructions for starting the service along with introducing a `setup` script
- Added various new `composer ...` convenience commands

## v0.7.0 (2021-11-11)

- Rebrands the project from `Laraview` to `Glass`, this also includes the database name and user. It's highly encouraged to backup your database prior to upgrading and re-import your data after a fresh installation or manually change the database users and names

## v0.6.0 (2021-11-04)

- Adds database replication where a main database accepts writes and a replica is read from (overhauls the required env variables to properly set this up)
- Scales production deployments to 2 instances of the blog container

## v0.5.2 (2021-08-18)

- Fixes a bug that did not properly round corners on post banner images depending on screen size (closes #54)
- Adds SASS linting and lints SASS files

## v0.5.1 (2021-04-22)

- Bug fix to correct URLs on RSS feed entries

## v0.5.0 (2021-04-22)

- Added an RSS feed `/feed` where you can retrieve the most recent `50` posts via RSS. Perfect for staying up to date with the latest posts or automating blog entries via other feeds.
- Dependency bumps

## v0.4.4 (2021-04-02)

- Fixes a bug that doesn't allow non-admins to see posts
- Fixes a bug that did not preserve old value of `post status` field when there were validation errors

## v0.4.3 (2021-02-12)

- Switches to Laravel Mix for JS and CSS assets which improves load times and dependencies

## v0.4.2 (2021-02-12)

- Updates database seeders
  - Adds comments
  - Adds categories
  - Updates previously broken seeds from database changes
  - Added seeding to GitHub Actions so we can know if seeds break in the future

## v0.4.1 (2021-02-12)

- Various bug fixes (closes #26)
  - Admins can now access their draft posts without an error being thrown
  - There is now a unique check in place for post slug names that now ignores the post being updated and only checks against other posts
  - Fixed a development bug where data wasn't seeded correctly for categories and rollbacks wouldn't remove that data
  - The dark mode theme had text the same color as the background on the admin page which has been fixed
  - Reading time and categories now have visual fallbacks if they are not set properly

## v0.4.0 (2021-02-09)

- Fixed slugify integration and dependencies
- Switched from Travis CI to GitHub Actions
- Remove `composer.phar` from repo (storing binaries in git is bad) and use updated Docker image that contains composer installed
- Bumped dependencies
- Added missing changelog

## v0.3.0 (2020)

- Added themes (dark mode)
- Added ability to save drafts
- Added more admin features
- Bug fixes

## v0.2.0 (2019)

- Added comments
- Added markdown editor
- Added images, author bio
- Added admin features

## v0.1.0 (2019)

- Initial release
- Create blog posts
