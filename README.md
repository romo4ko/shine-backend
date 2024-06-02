# Shine

Backend for Shine app on Laravel + Admin Panel

## Installation

```bash
git clone 
composer install
```

Copy the .env file and change the database connection settings

```bash
cp .env.example .env
```

```bash
php artisan key:generate
```
```bash
php artisan migrate
```
```bash
php artisan db:seed DatabaseSeeder
```
```bash
php artisan storage:link
```
```bash
npm install
```
```bash
npm run dev
```

For development mode, use the command

```bash
npm run build
```

## Docker installation

```bash
make up
```

To open console:

```
make shell
```
