# Farm Supply Inventory System

[![Deploy to Render](https://render.com/images/deploy-to-render-button.svg)](https://render.com/deploy?repo=https://github.com/Darkneth08/farm-inventory-system)

A web-based inventory and operations system built for farm supply businesses. This project helps teams manage products, stock, suppliers, warehouses, branches, customer orders, POS activity, reports, and super admin controls from one place.

## Overview

This system was designed to support day-to-day farm supply operations with a cleaner workflow for both customers and internal staff.

Main modules include:

- Customer portal for browsing products, placing orders, saving favorites, tracking updates, and leaving reviews
- Staff workspace for POS checkout, stock checks, and receiving workflows
- Operations tools for products, categories, suppliers, warehouses, branches, promotions, and stock adjustments
- Reports for inventory movement, low stock, expiring stock, sales, and inventory value
- Super admin tools for user management, audit logs, login activity, security reporting, and backup export

## Key Features

- Role-based access control for `customer`, `staff`, `manager`, `admin`, and `super_admin`
- Token-based authentication using Laravel Sanctum
- POS checkout with warehouse-aware inventory handling
- Inventory summary, batch tracking, aging view, and low-stock monitoring
- Supplier and warehouse management
- Branch and shared inventory visibility
- Customer favorites, notifications, product requests, and reviews
- Audit logging and super admin reporting tools
- Responsive UI for public, customer, staff, and admin views

## Tech Stack

- PHP 8.2
- Laravel 12
- Laravel Sanctum
- Vue 3
- Vite
- Tailwind CSS 4
- Bootstrap 5
- Laravel DOMPDF

## Project Structure

- `app/` - application logic, models, controllers, middleware, and support classes
- `routes/api.php` - API endpoints for auth, customer, staff, admin, and super admin modules
- `resources/views/` - Blade-based UI, landing page, and shared interface partials
- `resources/js/` - frontend scripts and Vue entry points
- `database/migrations/` - database schema history
- `tests/` - unit and feature tests
- `docs/` - ERD and documentation files

## Getting Started

### Requirements

- PHP 8.2 or newer
- Composer
- Node.js and npm
- A database connection such as SQLite or MySQL

### Installation

1. Clone the repository:

```bash
git clone https://github.com/Darkneth08/farm-inventory-system.git
cd farm-inventory-system
```

2. Install backend dependencies:

```bash
composer install
```

3. Create your environment file:

macOS / Linux:

```bash
cp .env.example .env
```

Windows PowerShell:

```powershell
Copy-Item .env.example .env
```

4. Generate the application key:

```bash
php artisan key:generate
```

5. Configure your database in `.env`

For SQLite local development, create `database/database.sqlite` and set:

```env
DB_CONNECTION=sqlite
```

6. Run migrations:

```bash
php artisan migrate
```

7. Install frontend dependencies:

```bash
npm install
```

8. Build frontend assets:

```bash
npm run build
```

9. Start the application:

```bash
php artisan serve
```

### Development Mode

To run the local development workflow:

```bash
composer run dev
```

### Running Tests

```bash
php artisan test
```

## Documentation

- ERD source: `docs/Farm_Supply_Inventory_System_ERD_Labeled.drawio`
- ERD notes: `docs/Farm_Supply_Inventory_System_ERD.md`
- Final project rubric guide: `docs/FINAL_PROJECT_RUBRIC_GUIDE.md`
- Render deployment guide: `docs/RENDER_DEPLOYMENT.md`

## Demo Accounts

These seeded accounts are available after running `php artisan db:seed`:

- Super admin: `superadmin@farm.com` / `password`
- Admin: `admin@farm.com` / `password`
- Manager: `manager@farm.com` / `password`
- Staff: `staff@farm.com` / `password`
- Customer: `customer@farm.com` / `password`

## Deployment

This repository includes Docker and Render Blueprint support:

- `Dockerfile`
- `.dockerignore`
- `render.yaml`
- `docker/render-start.sh`

For Render, create a Blueprint from this GitHub repository. The free demo Blueprint provisions a Docker web service, uses SQLite inside the service, runs migrations, seeds demo data, and starts Laravel on Render's assigned port.

## Author

**Kenneth Borja**

- GitHub: [Darkneth08](https://github.com/Darkneth08)

## Notes

This repository is published as a public project and portfolio work. Local environment files, database files, and private development artifacts are excluded from version control.
