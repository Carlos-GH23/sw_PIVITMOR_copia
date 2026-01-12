<template>
    <loading v-model:active="isLoading" :can-cancel="false" :is-full-page="true" loader="dots" color="#283C2A" />
    <CardBox class="border-forest-100/20 mb-4">
        <div class="mb-4">
            <div class="flex justify-between items-center">
                <div class="flex items-center">
                    <BaseIcon class="text-forest-400" :path="mdiHistory" size="24" h="h-10" w="w-10" />
                    <h3 class="text-forest-400 text-xl font-bold">
                        Historial de Versiones
                    </h3>
                </div>

                <BaseButton @click="openSettingsForm" color="light" label="Ajustes" :icon="mdiCog" />
            </div>
            <span class="text-sm font-light text-slate-800 dark:text-slate-300">
                Vea y administre todas las versiones publicadas de la política de privacidad. Restaure versiones
                anteriores según sea necesario.
            </span>
        </div>
    </CardBox>

    <CardBox class="border-forest-100/20 space-y-4">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-xl font-semibold text-gray-800 dark:text-white flex items-center">
                <BaseIcon :path="mdiFilterSettings" />
                Filtros de Búsqueda
            </h2>
            <div class="flex items-center space-x-2">
                <span class="text-sm text-gray-500 dark:text-gray-400">{{ privacityCompliances?.meta?.total || 0 }}
                    resultados</span>
                <div class="w-2 h-2 bg-success-400 rounded-full animate-pulse"></div>
            </div>
        </div>
        <div class="flex flex-col gap-2 lg:flex-row">
            <div class="flex flex-col sm:flex-row gap-2 md:basis-4/5">
                <FormField id="rows" labelFor="rows" label="Registros">
                    <FormControl @change="applyFilters(true)" placeholder="Elige un número" :options="rowsPerPage"
                        v-model="filters.rows" :icon="mdiNumeric" />
                </FormField>

                <FormField class="w-full" label="Búsqueda">
                    <FormControl @change="applyFilters(true)" type="search" ctrlKFocus :icon="mdiMagnify"
                        v-model="filters.search" placeholder="Ingresa un parámetro de búsqueda" />
                </FormField>
            </div>
            <div class="flex gap-2 h-10 sm:justify-center md:basis-1/5 lg:justify-evenly lg:mt-7 bgred">
                <BaseButton @click="clearFilters" label="Limpiar filtros" color="lightDark" :icon="mdiBroom" small
                    class="grow" />
                <BaseButton @click="openPrivacyForm" label="Agregar" color="info" :icon="mdiPlus" small class="grow" />
            </div>
        </div>

        <PrivacyVersionRecords :privacityCompliances="props.privacityCompliances" :sortByColumn="sortByColumn"
            :filters="filters" />
    </CardBox>

    <PrivacyFormModal :show="isPrivacyFormOpen" @close="closePrivacyForm" :props="props" />
    <SettingsFormModal :show="isSettingsFormOpen" @close="closeSettingsForm" :props="props" />
</template>

<script setup>
import BaseIcon from '@/Components/BaseIcon.vue';
import BaseButton from '@/Components/BaseButton.vue';
import CardBox from '@/Components/CardBox.vue';
import FormField from '@/Components/FormField.vue';
import FormControl from '@/Components/FormControl.vue';
import PrivacyVersionRecords from './PrivacyVersionRecords.vue';
import { mdiCog, mdiHistory, mdiMagnify, mdiNumeric, mdiPlus, mdiBroom, mdiFilterSettings } from '@mdi/js';
import { useModal } from '@/Hooks/useModal';
import PrivacyFormModal from './PrivacyFormModal.vue';
import SettingsFormModal from './SettingsFormModal.vue';
import { useFilters } from '@/Hooks/useFilters';
import { router } from "@inertiajs/vue3";

const props = defineProps({
    routeName: {
        type: String,
        required: true,
    },
    filters: {
        type: Object,
        required: false,
    },
    privacityCompliances: {
        type: Object,
        required: true,
    },
    consentConfigurations: {
        type: Object,
        required: true,
    },
});
const canEnable = () => verifyPermission('users.institutionProfile.enable');

const clearFilters = () => {
    router.get(route(`${props.routeName}index`), filters, {
        preserveScroll: true,
        preserveState: true,
        replace: true,
    });
};
const { isOpen: isPrivacyFormOpen, open: openPrivacyForm, close: closePrivacyForm } = useModal();
const { isOpen: isSettingsFormOpen, open: openSettingsForm, close: closeSettingsForm } = useModal();
const { filters, applyFilters, isLoading, sortByColumn } = useFilters(props.filters, props.routeName);

const rowsPerPage = ["5", "10", "50"];

</script>