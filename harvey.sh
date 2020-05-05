#!/bin/sh
source /harvey/.harvey

# INSTALL
cd src || harvey_fail
composer self-update || harvey_fail
composer install -q --no-ansi --no-interaction --no-scripts --no-suggest --no-progress --prefer-dist || harvey_fail

# TEST
./vendor/bin/phplint ./src --exclude=vendor || harvey_fail
