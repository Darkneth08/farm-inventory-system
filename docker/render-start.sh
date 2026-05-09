#!/usr/bin/env sh
set -eu

if [ -n "${APP_KEY:-}" ] && ! printf '%s' "$APP_KEY" | grep -q '^base64:'; then
    export APP_KEY="base64:$APP_KEY"
fi

if [ -z "${APP_URL:-}" ] && [ -n "${RENDER_EXTERNAL_HOSTNAME:-}" ]; then
    export APP_URL="https://$RENDER_EXTERNAL_HOSTNAME"
fi

if [ -z "${ASSET_URL:-}" ] && [ -n "${APP_URL:-}" ]; then
    export ASSET_URL="$APP_URL"
fi

php artisan config:clear
php artisan view:clear
php artisan migrate --force

if [ "${RUN_DEMO_SEEDER:-true}" = "true" ]; then
    php artisan db:seed --force
fi

php artisan config:cache
php artisan view:cache

exec php artisan serve --host=0.0.0.0 --port="${PORT:-10000}"
