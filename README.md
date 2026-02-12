# Book Library REST API

Simple REST API application for managing a book library.

This project demonstrates a RESTful API built with Laravel and a demo frontend built with Vue.  
It also includes Docker setup for local development.

---

## Tech Stack

- PHP 8.4
- Laravel 12
- MySQL
- Vue 3
- Axios
- PHPUnit
- Swagger (OpenAPI)
- Docker

---

## Project Structure

```
book-library-app-test/
├── backend/         # Laravel API
├── frontend/        # Vue frontend demo
├── docker/          # Docker configurations
├── README.md
├── TODO.md
├── CHANGELOG.md
```

---

## Setup (Local Development without Docker)

1. Clone the repository:

```bash
git clone <repo-url>
cd book-library-app-test/backend
```

2. Install dependencies:

```bash
composer install
npm install
```

3. Copy environment file and generate app key:

```bash
cp .env.example .env
php artisan key:generate
```

4. Configure `.env` for your database:

```dotenv
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=book_library
DB_USERNAME=root
DB_PASSWORD=root
```

5. Run migrations and seed the database:

```bash
php artisan migrate --seed
```

6. Start backend and frontend:

```bash
php artisan serve
cd ../frontend
npm run dev
```

7. Access:

- Backend API: `http://localhost:8000/api/books`  
- Swagger UI: `http://localhost:8000/api/documentation`  
- Vue demo: `http://localhost:5173/`

---

## Setup (Docker)

1. Build and start containers:

```bash
docker compose up -d --build
```

2. Run migrations and seed database inside the app container:

```bash
docker compose exec app php artisan migrate --seed
```

3. Access:

- Backend API: `http://localhost:8000/api/books`  
- Swagger UI: `http://localhost:8000/api/documentation`  
- Vue demo: `http://localhost:5173/`

---

## API Endpoints (Example)

| Method | Endpoint          | Description        |
|--------|-------------------|--------------------|
| GET    | /api/books        | List all books     |
| POST   | /api/books        | Create a new book  |
| GET    | /api/books/{id}   | Get a book by ID   |
| PATCH  | /api/books/{id}   | Update a book      |
| DELETE | /api/books/{id}   | Delete a book      |

Swagger UI provides full documentation and testing capabilities.

---

## Frontend Demo

- Vue 3 demo with components:
  - `BookList` (list + pagination + delete/edit)
  - `BookForm` (create/edit)
- Axios is used to communicate with backend API
- Pagination and editing functionality included

---

## Tests

Run PHPUnit tests for API:

```bash
cd backend
php artisan test
```

---

## Docker Notes

- Containers included:
  - `app` (Laravel)
  - `db` (MySQL)
  - `nginx` (reverse proxy)
  - `frontend` (Vue demo)
- Network: `app-network`
- Volumes: `dbdata` for MySQL
- Health check and startup ordering handled via `depends_on`

---

## Contributing / Gitflow

- `main` — production
- `dev` — active development
- `feature/*` — feature branches
- Commit format: `feat(scope): description`, `fix(scope): description`, `docs(scope): description`

---

## References

- Swagger: `/api/documentation`
- Axios: frontend calls `http://localhost:8000/api/books`

