#!/bin/sh

set -e

echo "🚀 Starting Laravel application..."

if [ ! -f vendor/autoload.php ]; then
    echo "⚠️ Vendor dependencies not found, installing..."
    composer install --optimize-autoloader
fi

echo "⏳ Waiting for PostgreSQL..."
while ! nc -z postgres 5432; do
  sleep 1
done
echo "✅ PostgreSQL is ready!"

echo "⏳ Waiting for Redis..."
while ! nc -z redis 6379; do
  sleep 1
done
echo "✅ Redis is ready!"

if [ ! -f .env ]; then
    echo "📄 Creating .env file..."
    if [ -f .env.example ]; then
        cp .env.example .env
    else
        echo "APP_NAME=Laravel" > .env
        echo "APP_ENV=local" >> .env
        echo "APP_DEBUG=true" >> .env
        echo "APP_KEY=" >> .env
    fi
fi

if grep -q '^APP_KEY=$' .env || ! grep -q '^APP_KEY=base64:' .env; then
    echo "🔑 Generating application key..."
    php artisan key:generate --force
fi

echo "🗄️ Running database migrations..."
php artisan migrate --force

echo "🌱 Seeding database..."
php artisan db:seed --force

echo "🧹 Clearing cache..."
php artisan optimize:clear

echo "🚀 Starting Laravel development server..."
exec php artisan serve --host=0.0.0.0 --port=9000