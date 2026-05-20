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

## Create Sail Alias

Add the following alias to your shell configuration (`~/.zshrc`, `~/.bashrc`, etc.):

```bash
alias sail='sh $([ -f sail ] && echo sail || echo vendor/bin/sail)'
```

Apply changes:

```bash
source ~/.zshrc
```

## Start Docker Containers

```bash
sail up -d
```

Wait a few seconds for MySQL to initialize:

```bash
sleep 15
```

## Database Migration and Seeders

Create a database and add the required variables to the `.env` file.

```bash
sail artisan migrate --seed

sail artisan db:seed --class=MenuSeeder
```

## Run Vite

```bash
sail npm run dev
```

## Admin Panel Credentials

```txt
Email: admin@admin.com
Password: 12345678
```
