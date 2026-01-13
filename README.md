# Laravel 11 + Inertia.js + Vue 3 Starter Template

Un template limpio de Laravel 11 con Inertia.js y Vue 3, que incluye un módulo completo de seguridad (Usuarios, Roles, Permisos, Módulos).

## Características

- ✅ Laravel 11
- ✅ Inertia.js 2.0
- ✅ Vue 3 con Composition API
- ✅ Pinia para state management
- ✅ TailwindCSS 4
- ✅ PrimeVue components
- ✅ Módulo de seguridad completo (Spatie Permission)
- ✅ Autenticación con Laravel Breeze
- ✅ Sanctum para API authentication

## Requisitos

- PHP 8.2 o superior
- Composer
- Node.js y NPM
- MySQL/MariaDB

## Instalación

1. **Clonar el repositorio**
   ```bash
   git clone <tu-repositorio>
   cd sw_PIVITMOR
   ```

2. **Instalar dependencias**
   ```bash
   composer install
   npm install
   ```

3. **Configurar entorno**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Configurar base de datos**

   Edita el archivo `.env` y configura tu base de datos:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=tu_base_de_datos
   DB_USERNAME=tu_usuario
   DB_PASSWORD=tu_contraseña
   ```

5. **Ejecutar migraciones y seeders**
   ```bash
   php artisan migrate:refresh --seed
   ```

6. **Iniciar el servidor de desarrollo**

   En una terminal:
   ```bash
   npm run dev
   ```

   En otra terminal:
   ```bash
   php artisan serve
   ```

7. **Acceder a la aplicación**

   Abre tu navegador en `http://localhost:8000`

   **Credenciales por defecto:**
   - Email: `admin@admin.com`
   - Password: `password`

## Estructura del Proyecto

### Backend

```
app/
├── Http/
│   └── Controllers/
│       ├── Auth/           # Controladores de autenticación
│       └── Security/       # Módulo de seguridad
├── Models/
│   ├── User.php           # Modelo de usuario
│   └── Module.php         # Modelo de módulos
└── Providers/
```

### Frontend

```
resources/
└── js/
    ├── Modules/           # Páginas organizadas por dominio
    │   ├── Core/         # Dashboard y páginas principales
    │   ├── Domains/      # Módulos de negocio
    │   ├── Interface/    # Páginas de interfaz
    │   └── Shared/       # Páginas compartidas
    ├── Components/       # Componentes Vue reutilizables
    ├── Layouts/          # Layouts de la aplicación
    ├── stores/           # Estado global con Pinia
    └── Utils/            # Utilidades y helpers
```

## Módulo de Seguridad

El proyecto incluye un módulo completo de seguridad con:

### Roles por defecto

1. **Super Admin** - Acceso completo al sistema
2. **Admin** - Acceso administrativo limitado
3. **User** - Acceso básico de usuario

### Permisos

Los permisos están organizados por recurso:
- `users.*` - Gestión de usuarios
- `roles.*` - Gestión de roles
- `permissions.*` - Gestión de permisos
- `modules.*` - Gestión de módulos

### Rutas del módulo de seguridad

- `/users` - Gestión de usuarios
- `/roles` - Gestión de roles
- `/permissions` - Gestión de permisos
- `/modules` - Gestión de módulos

## Comandos Útiles

```bash
# Desarrollo
npm run dev              # Servidor de desarrollo Vite
npm run build           # Build de producción

# Tests
php artisan test        # Ejecutar tests

# Formateo de código
./vendor/bin/pint       # Formatear código PHP

# Base de datos
php artisan migrate:refresh --seed    # Reiniciar BD y seeders
php artisan db:seed                   # Solo seeders

# Limpiar cachés
php artisan optimize:clear            # Limpiar todos los cachés
```

## Desarrollo

Este template está listo para que comiences a desarrollar tu aplicación. El frontend está completamente configurado con componentes, layouts y utilidades que puedes usar como base.

### Agregar nuevos módulos

1. Crea tus controladores en `app/Http/Controllers/`
2. Crea tus modelos en `app/Models/`
3. Agrega tus rutas en `routes/web.php`
4. Crea tus páginas Vue en `resources/js/Modules/Domains/`

### Personalización

- Modifica los componentes en `resources/js/Components/`
- Ajusta los layouts en `resources/js/Layouts/`
- Configura TailwindCSS en `tailwind.config.js`
- Personaliza PrimeVue en `resources/js/app.js`

## Licencia

Este proyecto es de código abierto bajo la licencia MIT.
