# CHANGELOG

## v0.5.2 (2021-08-18)

* Fixes a bug that did not properly round corners on post banner images depending on screen size (closes #54)

## v0.5.1 (2021-04-22)

* Bug fix to correct URLs on RSS feed entries

## v0.5.0 (2021-04-22)

* Added an RSS feed `/feed` where you can retrieve the most recent  `50` posts via RSS. Perfect for staying up to date with the latest posts or automating blog entries via other feeds.
* Dependency bumps

## v0.4.4 (2021-04-02)

* Fixes a bug that doesn't allow non-admins to see posts
* Fixes a bug that did not preserve old value of `post status` field when there were validation errors

## v0.4.3 (2021-02-12)

* Switches to Laravel Mix for JS and CSS assets which improves load times and dependencies

## v0.4.2 (2021-02-12)

* Updates database seeders
    * Adds comments
    * Adds categories
    * Updates previously broken seeds from database changes
    * Added seeding to GitHub Actions so we can know if seeds break in the future

## v0.4.1 (2021-02-12)

* Various bug fixes (closes #26)
    * Admins can now access their draft posts without an error being thrown
    * There is now a unique check in place for post slug names that now ignores the post being updated and only checks against other posts
    * Fixed a development bug where data wasn't seeded correctly for categories and rollbacks wouldn't remove that data
    * The dark mode theme had text the same color as the background on the admin page which has been fixed
    * Reading time and categories now have visual fallbacks if they are not set properly

## v0.4.0 (2021-02-09)

* Fixed slugify integration and dependencies
* Switched from Travis CI to GitHub Actions
* Remove `composer.phar` from repo (storing binaries in git is bad) and use updated Docker image that contains composer installed
* Bumped dependencies
* Added missing changelog

## v0.3.0 (2020)

* Added themes (dark mode)
* Added ability to save drafts
* Added more admin features
* Bug fixes

## v0.2.0 (2019)

* Added comments
* Added markdown editor
* Added images, author bio
* Added admin features

## v0.1.0 (2019)

* Initial release
* Create blog posts
