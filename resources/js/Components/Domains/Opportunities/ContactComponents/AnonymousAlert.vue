<template>
    <div class="bg-amber-50 border border-amber-200 rounded-lg p-6">
        <div class="flex items-start gap-3">
            <BaseIcon :path="mdiShieldLock" class="w-6 h-6 text-amber-600 flex-shrink-0" />
            <div>
                <h3 class="font-semibold text-amber-900 mb-2">Información Confidencial</h3>
                <p class="text-amber-800 text-sm leading-relaxed mb-3">
                    Esta necesidad tecnológica ha sido registrada por una Empresa de Base Tecnológica (EBT).
                    Por motivos de confidencialidad, no se muestra información de contacto directo.
                </p>
                <p class="text-amber-700 text-sm">
                    Para más información, contacte a través de la plataforma.
                </p>
            </div>
        </div>
    </div>
</template>

<script setup>
import BaseIcon from '@/Components/BaseIcon.vue';
import { mdiShieldLock } from '@mdi/js';
</script>