<template>
    <div class="p-4 space-y-4 mb-6 bg-white shadow-sm border border-mono-100 rounded-lg">
        <div class="flex flex-col xl:flex-row items-center gap-4 xl:space-y-0 space-y-2">
            <FormControl class="w-full" v-model="filters.search" :icon="mdiMagnify" placeholder="Buscar oportunidades"
                rounded-full ctrlKFocus />
            <BaseButton :icon="mdiFilter" label="Filtros de oportunidad" color="lightDark" @click="$emit('openFilters')"
                rounded-full class="w-full md:w-auto" :small="false" />
        </div>

        <div class="flex justify-between md:justify-end items-center gap-6">
            <button @click="$emit('clearFilters')"
                class="text-forest-100 hover:text-forest-400 hover:underline font-medium transition-colors cursor-pointer">
                Limpiar filtros
            </button>

            <div class="flex items-center space-x-2">
                <span class="text-sm text-gray-500 dark:text-gray-400">{{ totalResults }} resultados</span>
                <div class="w-2 h-2 bg-green-400 rounded-full animate-pulse"></div>
            </div>
        </div>
    </div>
</template>

<script setup>
import BaseButton from '@/Components/BaseButton.vue';
import FormControl from '@/Components/FormControl.vue';
import { mdiFilter, mdiMagnify } from '@mdi/js';

defineProps({
    filters: {
        type: Object,
        required: true
    },
    totalResults: {
        type: Number,
        required: true
    }
});
</script>