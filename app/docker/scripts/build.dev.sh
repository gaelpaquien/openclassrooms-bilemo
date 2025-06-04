#!/bin/bash

cd /var/www

echo "Starting building app in DEV environment..."

echo "Installing dependencies..."
composer install || exit 1

echo "Setting up database...."
php bin/console doctrine:database:create --env=dev --if-not-exists || exit 1
php bin/console doctrine:schema:create --env=dev || exit 1
echo "yes" | php bin/console doctrine:fixtures:load --env=dev || exit 1

echo "Generating JWT keys..."
if [ ! -d config/jwt ]; then
  mkdir -p config/jwt || exit 1
fi
JWT_PASSPHRASE=$(grep 'JWT_PASSPHRASE' .env.local | cut -d '=' -f 2)
openssl genpkey -out config/jwt/private.pem -aes256 -algorithm rsa -pkeyopt rsa_keygen_bits:4096 -pass pass:"$JWT_PASSPHRASE" || exit 1
openssl pkey -in config/jwt/private.pem -out config/jwt/public.pem -pubout -passin pass:"$JWT_PASSPHRASE" || exit 1

echo "Clearing cache..."
symfony console cache:clear --env=dev || exit 1

echo "Building app completed successfully!"

exec "$@"