#!/bin/sh
set -e

mkdir -p \
    storage/framework/sessions \
    storage/framework/views \
    storage/framework/cache \
    storage/logs \
    bootstrap/cache

# The source volume may contain a package manifest generated with dev dependencies.
rm -f bootstrap/cache/*.php

chown -R www-data:www-data storage bootstrap/cache

exec "$@"
