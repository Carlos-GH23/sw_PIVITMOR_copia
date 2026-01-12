<template>
    <div
        class="flex flex-col items-center md:flex-row md:justify-between xl:hidden gap-4 border border-forest-50/40 rounded-lg p-4">
        <h3 class="md:text-lg">Realiza una búsqueda por filtros para tener resultados específicos</h3>

        <Sheet>
            <SheetTrigger as-child>
                <BaseButton class="w-full md:w-auto" :icon="mdiFilterCog" color="darklight" label="Mostrar Filtros" />
            </SheetTrigger>
            <SheetContent side="left" class="overflow-y-auto">
                <SheetHeader>
                    <SheetTitle class="text-2xl text-forest-400">Filtrar resultados</SheetTitle>
                    <SheetDescription>Refina los resultados según tus necesidades</SheetDescription>
                </SheetHeader>

                <div class="p-4">
                    <FiltersForm :filters="filters" :filter-options="filterOptions" />
                </div>

                <SheetFooter class="sm:flex-row justify-end gap-4">
                    <BaseButton @click="$emit('clearFilters')" color="darklight" label="Limpiar" />
                    <BaseButton @click="$emit('applyFilters')" color="info" label="Aplicar filtros" />
                </SheetFooter>
            </SheetContent>
        </Sheet>
    </div>

    <div
        class="hidden xl:block border-2 border-forest-50/40 rounded-lg p-4 sticky top-12 self-start max-h-[calc(100vh-1rem)] overflow-y-auto">
        <div class="sticky -top-4 z-30 h-16 bg-white flex items-center justify-between mb-4">
            <h2 class="font-semibold text-2xl">Filtros</h2>
            <div class="space-x-2">
                <BaseButton @click="$emit('applyFilters')" color="info" label="Aplicar" />
                <BaseButton @click="$emit('clearFilters')" color="white" label="Limpiar" />
            </div>
        </div>

        <FiltersForm :filters="filters" :filter-options="filterOptions" />
    </div>
</template>

<script setup>
import BaseButton from '@/Components/BaseButton.vue';
import FiltersForm from './FiltersForm.vue';
import {
    Sheet,
    SheetContent,
    SheetDescription,
    SheetFooter,
    SheetHeader,
    SheetTitle,
    SheetTrigger,
} from '@/Components/ui/sheet';
import { mdiFilterCog } from '@mdi/js';

defineProps({
    filters: {
        type: Object,
        required: true
    },
    filterOptions: {
        type: Object,
        required: true
    }
});

const emit = defineEmits([
    'applyFilters',
    'clearFilters'
]);

</script>
