#!/usr/bin/env sh

php vendor/bin/phpstan analyse --configuration phpstan.neon app bin tests www
