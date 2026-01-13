<template>
    <LayoutAuthenticated>
        <div class="p-6">
            <!-- Welcome Card -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-2xl font-bold mb-2">
                        ¡Bienvenido, {{ page.props.auth.user.name }}!
                    </h3>
                    <p class="text-gray-600 dark:text-gray-400">
                        Has iniciado sesión correctamente en tu aplicación Laravel.
                    </p>
                </div>
            </div>

            <!-- Stats Grid -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <!-- User Info Card -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-blue-500 rounded-md p-3">
                                <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Usuario</p>
                                <p class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                                    {{ page.props.auth.user.email }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Roles Card -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-green-500 rounded-md p-3">
                                <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Roles</p>
                                <p class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                                    {{ roleNames }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Status Card -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-purple-500 rounded-md p-3">
                                <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Estado</p>
                                <p class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                                    {{ page.props.auth.user.is_active ? 'Activo' : 'Inactivo' }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">
                        Acciones Rápidas
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                        <!-- Profile Link -->
                        <Link :href="route('profile.edit')"
                            class="flex items-center p-4 bg-gray-50 dark:bg-gray-700 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-600 transition">
                            <svg class="h-8 w-8 text-blue-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <div>
                                <p class="font-semibold text-gray-900 dark:text-gray-100">Mi Perfil</p>
                                <p class="text-sm text-gray-500 dark:text-gray-400">Ver y editar</p>
                            </div>
                        </Link>

                        <!-- Users Link (if has permission) -->
                        <Link v-if="page.props.auth.can['users.index']" :href="route('users.index')"
                            class="flex items-center p-4 bg-gray-50 dark:bg-gray-700 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-600 transition">
                            <svg class="h-8 w-8 text-green-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                            </svg>
                            <div>
                                <p class="font-semibold text-gray-900 dark:text-gray-100">Usuarios</p>
                                <p class="text-sm text-gray-500 dark:text-gray-400">Gestionar</p>
                            </div>
                        </Link>

                        <!-- Roles Link (if has permission) -->
                        <Link v-if="page.props.auth.can['roles.index']" :href="route('roles.index')"
                            class="flex items-center p-4 bg-gray-50 dark:bg-gray-700 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-600 transition">
                            <svg class="h-8 w-8 text-purple-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                            </svg>
                            <div>
                                <p class="font-semibold text-gray-900 dark:text-gray-100">Roles</p>
                                <p class="text-sm text-gray-500 dark:text-gray-400">Gestionar</p>
                            </div>
                        </Link>

                        <!-- Permissions Link (if has permission) -->
                        <Link v-if="page.props.auth.can['permissions.index']" :href="route('permissions.index')"
                            class="flex items-center p-4 bg-gray-50 dark:bg-gray-700 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-600 transition">
                            <svg class="h-8 w-8 text-orange-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                            </svg>
                            <div>
                                <p class="font-semibold text-gray-900 dark:text-gray-100">Permisos</p>
                                <p class="text-sm text-gray-500 dark:text-gray-400">Gestionar</p>
                            </div>
                        </Link>
                    </div>
                </div>
            </div>
        </div>
    </LayoutAuthenticated>
</template>

<script setup>
import LayoutAuthenticated from '@/Layouts/LayoutAuthenticated.vue';
import { Link, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';

const page = usePage();

const roleNames = computed(() => {
    const roles = Object.keys(page.props.auth.roles || {});
    return roles.length > 0 ? roles.join(', ') : 'Sin roles';
});
</script>
