#!/bin/bash
set -e

php artisan migrate --force -vvv

apache2-foreground
