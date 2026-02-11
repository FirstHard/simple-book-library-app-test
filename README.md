# Book Library REST API

Simple REST API application for managing a book library.

This project demonstrates a RESTful API built with Laravel and a demo frontend built with Vue.

## Tech Stack

- PHP 8.4
- Laravel 12
- MySQL
- Vue 3
- Axios
- PHPUnit
- Swagger (OpenAPI)
- Docker

## Project Structure

book-library-app-test/
├── backend/ # Laravel API
├── frontend/ # Vue frontend
├── docker/ # Docker configs
├── README.md
├── TODO.md
├── CHANGELOG.md


## Setup (Local)

```bash
cd backend
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan serve
```

## API
Base URL (example):
http://book-library-app.test/api

Swagger UI will be available at:
/api/documentation

## Tests

```bash
cd backend
php artisan test
```
