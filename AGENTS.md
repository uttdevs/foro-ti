# Foro TI — Agent Guidelines

## Stack
- **Backend**: Laravel 13 / PHP 8.3 / MariaDB
- **Frontend**: React 19 SPA (Vite 8, Tailwind v4, React Router v7)
- **Admin panel**: Blade templates (auth-protected)
- **PDF export**: barryvdh/laravel-dompdf

## Environment
- Development runs via Docker Compose (`docker compose up -d`)
- App: port 8000 | phpMyAdmin: port 8080 | MariaDB: port 3307

## Key Paths
- React SPA entry: `resources/js/spa/main.jsx`
- Blade views: `resources/views/`
- Routes: `routes/web.php`
- Models: `app/Models/`
- Controllers: `app/Http/Controllers/`

## Important Notes
- Business tables (`carreras`, `talleres`, `asistentes_foro`) have NO migrations — schema comes from SQL dump
- `public/III Congreso/` contains ~260 MB of unused photos — excluded from Docker builds
- Email is disabled (`MAIL_MAILER=array`); requires SMTP config for production
