#!/bin/sh

php artisan migrate

printenv | grep -v "no_proxy" >> /etc/environment
#Extra line added in the script to run all command line arguments
exec "$@";

