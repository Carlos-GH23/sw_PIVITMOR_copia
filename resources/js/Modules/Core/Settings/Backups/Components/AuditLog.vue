<template>
    <loading v-model:active="isLoading" :can-cancel="false" :is-full-page="true" loader="dots" color="#283C2A" />
    <CardBox class="space-y-4 border-gray-100">
        <div class="mb-4">
            <div class="flex items-center">
                <BaseIcon class="text-forest-400" :path="mdiFileDocumentOutline" size="24" h="h-10" w="w-10" />
                <h3 class="text-forest-400 text-xl font-bold">Auditoría y estado</h3>
            </div>
            <span class="text-sm font-light text-slate-800 dark:text-slate-300">
                Historial completo de operaciones de respaldo y restauración
            </span>
        </div>

        <div class="flex flex-col gap-2 lg:flex-row mb-4">
            <div class="w-full md:w-1/4">
                <FormField labelFor="rows" label="Registros">
                    <FormControl id="rows" placeholder="Elige un número" :options="rowsPerPage" v-model="filters.rows"
                        @change="applyFilters" :icon="mdiNumeric" />
                </FormField>
            </div>
            <div class="flex-1 w-full">
                <FormField label="Búsqueda">
                    <FormControl type="search" ctrlKFocus :icon="mdiMagnify" v-model="filters.search"
                        placeholder="Ingresa un parámetro de búsqueda" />
                </FormField>
            </div>
            <div class="flex gap-2 h-10 sm:justify-center md:basis-1/5 lg:justify-evenly lg:mt-7 bgred">
                <BaseButton @click="clearFilters" class="grow" :icon="mdiBroom" color="lightDark"
                    label="Limpiar filtros" small />
            </div>
        </div>

        <AuditRecords :backups="backups" :route-name="routeName" />
    </CardBox>
</template>

<script setup>
import BaseIcon from '@/Components/BaseIcon.vue';
import CardBox from '@/Components/CardBox.vue';
import FormControl from '@/Components/FormControl.vue';
import FormField from '@/Components/FormField.vue';
import AuditRecords from './AuditRecords.vue';
import { mdiBroom, mdiFileDocumentOutline, mdiMagnify, mdiNumeric } from '@mdi/js';
import { useFilters } from '@/Hooks/useFilters';
import BaseButton from '@/Components/BaseButton.vue';

const props = defineProps({
    backups: {
        type: Object,
        required: true,
    },
    filters: {
        type: Object,
        required: true,
    },
    routeName: {
        type: String,
        required: true,
    },
});

const { filters, isLoading, applyFilters, clearFilters } = useFilters(props.filters, props.routeName);

const rowsPerPage = ["5", "10", "50"];
</script>