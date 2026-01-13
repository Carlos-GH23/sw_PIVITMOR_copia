# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project Overview

This is a clean Laravel 11 starter template using Inertia.js with Vue 3 for the frontend. The project includes a complete security module (Users, Roles, Permissions, Modules) with authentication and authorization using Spatie Laravel Permission.

**Key Technologies:**
- **Backend**: Laravel 11 (PHP 8.2+), Inertia.js 2.0, Laravel Sanctum, Spatie Permission
- **Frontend**: Vue 3, Pinia, TailwindCSS 4, PrimeVue, Vite
- **Database**: MySQL/MariaDB (configured via .env)

## Common Commands

### Development Setup
```bash
# Install dependencies
composer install
npm install

# Setup environment
cp .env.example .env
php artisan key:generate

# Database setup
php artisan migrate:refresh --seed
# Default user: admin@admin.com / password

# Start development server
npm run dev

# In a separate terminal, serve the application
php artisan serve
```

### Development Workflow
```bash
# Run development server (Vite)
npm run dev

# Build for production
npm run build

# Run tests
php artisan test

# Run specific test file
php artisan test tests/Feature/YourTestFile.php

# Code formatting
./vendor/bin/pint

# Clear caches
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan optimize:clear
```

### Database Operations
```bash
# Run migrations
php artisan migrate

# Rollback migrations
php artisan migrate:rollback

# Refresh and seed database
php artisan migrate:refresh --seed

# Seed only
php artisan db:seed

# Create new migration
php artisan make:migration create_table_name
```

## Architecture

### Backend Structure

**Clean MVC Pattern**: The application follows Laravel's standard MVC architecture with a complete security module.

- **Controllers** (`app/Http/Controllers/`):
  - `Auth/` - Authentication controllers (ProfileController)
  - `Security/` - Security module controllers (UserController, RoleController, PermissionController, ModuleController)
  - `Controller.php` - Base controller

- **Models** (`app/Models/`):
  - `User.php` - User model with Spatie Permission traits
  - `Module.php` - Application modules model

- **Migrations** (`database/migrations/`):
  - Users table
  - Password reset tokens
  - Failed jobs
  - Personal access tokens (Sanctum)
  - Permission tables (Spatie)
  - Modules table

- **Seeders** (`database/seeders/`):
  - `ModuleSeeder` - Seeds application modules
  - `PermissionSeeder` - Seeds permissions for security module
  - `RoleSeeder` - Seeds roles (Super Admin, Admin, User)
  - `UserSeeder` - Seeds default admin user

### Frontend Structure

**Modular Vue Architecture**: Frontend is organized in domain modules using Inertia.js.

- **Entry Point**: `resources/js/app.js` - Sets up Vue 3, Inertia, Pinia, and plugins
- **Pages**: `resources/js/Modules/` - Organized by domain:
  - `Core/` - Core application pages (Dashboard, etc.)
  - `Domains/` - Business domain pages (ready for your modules)
  - `Interface/` - UI-related components and pages
  - `Shared/` - Shared pages and utilities

- **Components**: `resources/js/Components/` - Reusable Vue components
- **Layouts**: `resources/js/Layouts/` - Layout components for different page types
- **Stores**: `resources/js/stores/` - Pinia state management
- **Utilities**: `resources/js/Utils/` - Helper functions
- **Configs**: `resources/js/Configs/` - Frontend configuration files

### Key Features

1. **Security Module**: Complete RBAC system with Users, Roles, Permissions, and Modules
2. **Authentication**: Laravel Breeze with Inertia.js
3. **Authorization**: Spatie Laravel Permission for role-based access control
4. **API Authentication**: Laravel Sanctum for SPA authentication

### Routing

- **Web Routes** (`routes/web.php`): Main application routes with authentication
  - Dashboard
  - Profile management
  - Security module (modules, permissions, roles, users)

- **API Routes** (`routes/api.php`): API endpoints with Sanctum authentication
  - User endpoint

- **Auth Routes** (`routes/auth.php`): Authentication routes from Laravel Breeze

- **Public Routes** (`routes/public.php`): Public-facing routes (welcome page)

### Security & Permissions

- Uses Spatie Laravel Permission for RBAC
- Three default roles:
  - **Super Admin**: Full system access
  - **Admin**: Limited administrative access
  - **User**: Basic user access
- Permissions organized by resource (users, roles, permissions, modules)
- Middleware for authentication and authorization

## Code Conventions

- **Backend**: Follow PSR-12 coding standards, use Laravel Pint for formatting
- **Frontend**: Vue 3 Composition API preferred
- **Controllers**: Keep thin, use resource controllers when possible
- **Models**: Keep focused on relationships and accessors
- **Routes**: Use resource routes for CRUD operations

## Testing Notes

- Tests located in `tests/Feature/` and `tests/Unit/`
- Uses PHPUnit
- Run with `php artisan test`

## Default Credentials

After running `php artisan migrate:refresh --seed`:
- **Email**: admin@admin.com
- **Password**: password
- **Role**: Super Admin
