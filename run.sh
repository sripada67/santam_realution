#!/bin/sh

php artisan migrate
#Extra line added in the script to run all command line arguments
exec "$@";

