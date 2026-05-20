# Installation

## Composer

```bash
composer install
```

## Vite / Node Modules

```bash
npm install
```

## Environment Configuration

```bash
cp .env.example .env

php artisan key:generate

php artisan storage:link
```

## Database Migration and Seeders

Create a database and add the required variables to the `.env` file.

```bash
php artisan migrate --seed

php artisan db:seed --class=MenuSeeder
```

## Admin Panel Credentials

```txt
Email: admin@admin.com
Password: 12345678
```
