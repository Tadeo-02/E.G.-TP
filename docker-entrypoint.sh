#!/bin/bash
set -e

# Install PHPMailer dependencies if vendor/ doesn't exist
if [ ! -d "/var/www/html/vendor" ]; then
    echo "Installing Composer dependencies..."
    cd /var/www/html
    composer install --no-interaction --no-dev --optimize-autoloader
fi

# Start Apache in foreground
exec apache2-foreground
