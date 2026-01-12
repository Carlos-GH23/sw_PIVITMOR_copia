<template>
    <div class="mb-6 bg-yellow-50 border border-yellow-200 rounded-lg p-4">
        <div class="flex items-start gap-3">
            <BaseIcon :path="mdiShieldLock" class="w-5 h-5 text-yellow-600 flex-shrink-0 mt-0.5" />
            <div>
                <p class="text-sm text-yellow-900 font-medium mb-1">
                    Necesidad del sector privado
                </p>
                <p class="text-sm text-yellow-800">
                    Esta necesidad ha sido registrada por una Empresa de Base Tecnológica
                    (EBT). La información de contacto no se muestra por razones de
                    confidencialidad. Se muestran únicamente los detalles técnicos
                    relevantes para posibles colaboradores.
                </p>
            </div>
        </div>
    </div>
</template>

<script setup>
import BaseIcon from '@/Components/BaseIcon.vue';
import { mdiShieldLock } from '@mdi/js';
</script>