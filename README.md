# Resep Makanan
Backend untuk program resep makanan yang dibuat menggunakan laravel

## Installation
### 1. [RUN] COPY FILE ENV
```bash
cp .env.example .env
```
### 2. [RUN] INSTALL VENDOR MODULE PAKE COMPOSER
```
composer install
```
### 3. [RUN] GENERATE KEY DI ENV
```
php artisan key:generate
```
### 4. [RUN] SYMLINK STORAGE
```
php artisan storage:link
```
### 5. SETTING DATABASE (PGSQL) && SET ENV

### 6. [RUN] MIGRATE DATABASE

```
php artisan migrate
```
### 7. [RUN] TESTING

```
php artisan test
```
### 8. [RUN] SERVE
```
php artisan serve
```