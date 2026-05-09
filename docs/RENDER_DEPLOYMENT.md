# Render Deployment

This project is configured for Render using Docker and `render.yaml`.

## Deployment Method

Use Render Blueprint deployment:

1. Push this repository to GitHub.
2. Open Render Dashboard.
3. Click **New**.
4. Select **Blueprint**.
5. Connect `Darkneth08/farm-inventory-system`.
6. Confirm the `render.yaml` configuration.
7. Deploy.

The Blueprint creates:

- Docker web service: `farm-inventory-system`
- PostgreSQL database: `farm-inventory-db`

## Runtime Behavior

The Docker start script runs:

- `php artisan migrate --force`
- `php artisan db:seed --force`
- `php artisan config:cache`
- `php artisan view:cache`
- `php artisan serve --host=0.0.0.0 --port=$PORT`

The seeder is enabled by default so the deployed project has demo accounts for evaluation. Set `RUN_DEMO_SEEDER=false` in Render if you want to stop demo seeding later.

The start script also derives `APP_URL` and `ASSET_URL` from Render's `RENDER_EXTERNAL_HOSTNAME` when those variables are not set manually.

## Demo Credentials

- Super admin: `superadmin@farm.com` / `password`
- Admin: `admin@farm.com` / `password`
- Manager: `manager@farm.com` / `password`
- Staff: `staff@farm.com` / `password`
- Customer: `customer@farm.com` / `password`

## Manual Web Service Settings

If you create a Web Service manually instead of using Blueprint:

- Runtime: Docker
- Repository: `https://github.com/Darkneth08/farm-inventory-system`
- Branch: `main`
- Health check path: `/`
- Environment variables:
  - `APP_NAME=Farm Supply Inventory`
  - `APP_ENV=production`
  - `APP_DEBUG=false`
  - `APP_KEY=<output of php artisan key:generate --show>`
  - `APP_URL=<your Render URL>`
  - `ASSET_URL=<your Render URL>`
  - `LOG_CHANNEL=stderr`
  - `DB_CONNECTION=pgsql`
  - `DB_URL=<Render PostgreSQL internal connection string>`
  - `DATABASE_URL=<Render PostgreSQL internal connection string>`
  - `SESSION_DRIVER=database`
  - `CACHE_STORE=database`
  - `QUEUE_CONNECTION=database`
