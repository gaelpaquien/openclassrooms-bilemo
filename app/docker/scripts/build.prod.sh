#!/bin/bash

cd /var/www

echo "Starting building app in PROD environment..."

if [ ! -f .env.local ]; then
  echo "Creating .env.local from .env..."
  cp .env .env.local || exit 1
fi

echo "Installing dependencies..."
composer install --no-dev --optimize-autoloader --classmap-authoritative --no-interaction || exit 1

echo "Optimizing environment variables..."
composer dump-env prod || exit 1

echo "Setting up database...."
php bin/console doctrine:database:create --env=prod --if-not-exists --no-interaction || exit 1
php bin/console doctrine:schema:update --env=prod --force --no-interaction || exit 1
php bin/console doctrine:migrations:migrate --env=prod --no-interaction || exit 1

echo "Generating JWT keys..."
if [ ! -d config/jwt ]; then
  mkdir -p config/jwt || exit 1
fi
JWT_PASSPHRASE=$(grep 'JWT_PASSPHRASE' .env.local | cut -d '=' -f 2)
openssl genpkey -out config/jwt/private.pem -aes256 -algorithm rsa -pkeyopt rsa_keygen_bits:4096 -pass pass:"$JWT_PASSPHRASE" || exit 1
openssl pkey -in config/jwt/private.pem -out config/jwt/public.pem -pubout -passin pass:"$JWT_PASSPHRASE" || exit 1

echo "Clearing cache..."
php bin/console cache:clear --env=prod --no-interaction || exit 1

echo "Warming up cache..."
php bin/console cache:warmup --env=prod --no-interaction || exit 1

echo "Building app completed successfully!"

exec "$@"