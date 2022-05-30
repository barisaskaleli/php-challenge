#!/bin/bash

if [ ! -f "vendor/autoload.php" ]; then
    composer install
fi

if [ ! -f ".env" ]; then
    cp .env.example .env
fi

role=${CONTAINER_ROLE:-app}

if [ "$role" = "app" ]; then
    php artisan migrate --seed
    php artisan key:generate
    php artisan cache:clear
    php artisan config:clear
    php artisan route:clear
    php artisan vendor:publish --provider="Laravel\Sanctum\SanctumServiceProvider"
elif [ "$role" = "queue" ]; then
    echo "Running the queue ... "
    php /var/www/artisan horizon
elif [ "$role" = "scheduler" ]; then
    echo "Running the scheduler ... "
    php /var/www/artisan schedule:work
fi

php artisan serve --port=$PORT --host=0.0.0.0 --env=.env
exec docker-php-entrypoint "$@"
