<template>
    <div class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100 dark:from-gray-900 dark:to-gray-800">
        <!-- Navigation -->
        <nav class="bg-white dark:bg-gray-800 shadow-sm">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex items-center">
                        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">
                            Laravel Starter
                        </h1>
                    </div>
                    <div class="flex items-center space-x-4">
                        <Link v-if="!$page.props.auth.user" :href="route('login')"
                            class="text-gray-700 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white">
                            Iniciar sesión
                        </Link>
                        <Link v-if="!$page.props.auth.user" :href="route('register')"
                            class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md">
                            Registrarse
                        </Link>
                        <Link v-if="$page.props.auth.user" :href="route('dashboard')"
                            class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md">
                            Dashboard
                        </Link>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Hero Section -->
        <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
            <div class="text-center">
                <h2 class="text-5xl font-extrabold text-gray-900 dark:text-white mb-4">
                    Bienvenido a tu Aplicación Laravel
                </h2>
                <p class="text-xl text-gray-600 dark:text-gray-300 mb-8">
                    Starter template con Laravel 11, Inertia.js, Vue 3 y TailwindCSS
                </p>

                <div class="flex justify-center space-x-4">
                    <Link v-if="!$page.props.auth.user" :href="route('register')"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-lg text-lg font-semibold">
                        Comenzar
                    </Link>
                    <Link v-if="$page.props.auth.user" :href="route('dashboard')"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-lg text-lg font-semibold">
                        Ir al Dashboard
                    </Link>
                    <a href="https://laravel.com/docs" target="_blank"
                        class="bg-gray-200 hover:bg-gray-300 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-900 dark:text-white px-8 py-3 rounded-lg text-lg font-semibold">
                        Documentación
                    </a>
                </div>
            </div>

            <!-- Features -->
            <div class="mt-20 grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md">
                    <div class="text-blue-600 dark:text-blue-400 text-3xl mb-4">🚀</div>
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">
                        Laravel 11
                    </h3>
                    <p class="text-gray-600 dark:text-gray-300">
                        La última versión del framework PHP más popular para desarrollo web moderno.
                    </p>
                </div>

                <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md">
                    <div class="text-green-600 dark:text-green-400 text-3xl mb-4">⚡</div>
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">
                        Vue 3 + Inertia.js
                    </h3>
                    <p class="text-gray-600 dark:text-gray-300">
                        Framework JavaScript reactivo con el poder de las aplicaciones de una sola página.
                    </p>
                </div>

                <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md">
                    <div class="text-purple-600 dark:text-purple-400 text-3xl mb-4">🔐</div>
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">
                        Módulo de Seguridad
                    </h3>
                    <p class="text-gray-600 dark:text-gray-300">
                        Sistema completo de autenticación con roles y permisos usando Spatie.
                    </p>
                </div>
            </div>
        </main>

        <!-- Footer -->
        <footer class="bg-white dark:bg-gray-800 mt-20 border-t border-gray-200 dark:border-gray-700">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
                <p class="text-center text-gray-600 dark:text-gray-400">
                    &copy; {{ new Date().getFullYear() }} Laravel Starter. Todos los derechos reservados.
                </p>
            </div>
        </footer>
    </div>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';
</script>
