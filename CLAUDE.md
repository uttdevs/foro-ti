# Foro TI — Dev Reference

## Commands
- `docker compose up -d` — start all services
- `docker compose exec app php artisan migrate` — run migrations
- `docker compose exec app php artisan db:seed --class=AdminSeeder` — create admin user
- `npm run dev` — Vite dev server (local development outside Docker)
- `npm run build` — compile frontend assets

## Admin Access
- URL: `/admin/login`
- Email: `admin@foroti.com`
- Password: `CambiaEstaClave123`

## Architecture
Single-page React app served through a Blade shell (`spa.blade.php`).
Registration is a 2-step flow: Blade form → React taller selection with DB-level locking.
