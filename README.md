# College Management System API

A RESTful API built with Laravel for managing a college system with three roles: Admin, Teacher, and Student.

## Tech Stack
- PHP 8.3
- Laravel 11
- MySQL
- Laravel Sanctum (Authentication)

## Features

### Admin
- Manage departments (CRUD)
- Manage courses (CRUD)
- Manage users (create teachers & students)

### Teacher
- View assigned courses
- Assign and update student grades

### Student
- Enroll in courses
- View enrolled courses
- View grades

## Installation

1. Clone the repository
```bash
git clone https://github.com/ahmedmandouh101/college-management-api.git
cd college-management-api
```

2. Install dependencies
```bash
composer install
```

3. Copy environment file
```bash
cp .env.example .env
php artisan key:generate
```

4. Configure database in `.env`
```env
DB_DATABASE=college_management
DB_USERNAME=root
DB_PASSWORD=
```

5. Run migrations
```bash
php artisan migrate
```

6. Start the server
```bash
php artisan serve
```

## API Endpoints

### Auth
| Method | Endpoint | Description |
|--------|----------|-------------|
| POST | /api/register | Register a new user |
| POST | /api/login | Login |
| POST | /api/logout | Logout |

### Admin
| Method | Endpoint | Description |
|--------|----------|-------------|
| GET | /api/departments | List all departments |
| POST | /api/departments | Create department |
| PUT | /api/departments/{id} | Update department |
| DELETE | /api/departments/{id} | Delete department |
| GET | /api/courses | List all courses |
| POST | /api/courses | Create course |
| PUT | /api/courses/{id} | Update course |
| DELETE | /api/courses/{id} | Delete course |
| GET | /api/users | List all users |
| POST | /api/users | Create teacher/student |
| DELETE | /api/users/{id} | Delete user |

### Teacher
| Method | Endpoint | Description |
|--------|----------|-------------|
| GET | /api/my-courses | View assigned courses |
| POST | /api/grades | Assign grade to student |

### Student
| Method | Endpoint | Description |
|--------|----------|-------------|
| POST | /api/enroll | Enroll in a course |
| GET | /api/my-enrollments | View enrolled courses |
| GET | /api/my-grades | View grades |

## Authentication
This API uses Laravel Sanctum for authentication. Include the token in the request header:
```
Authorization: Bearer your_token_here
```