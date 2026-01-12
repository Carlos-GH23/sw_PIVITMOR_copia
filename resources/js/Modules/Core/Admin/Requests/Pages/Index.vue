<template>
    <HeadLogo :title="title" />
    <loading v-model:active="isLoading" :can-cancel="false" :is-full-page="true" loader="dots" color="#283C2A" />
    <LayoutMain>
        <SectionTitleLineWithButton :icon="mdiBookEducation" :title="title" main />
        <SearchBar @apply-filters="applyFilters" @clear-filters="clearFilters" v-model:search="filters.search"
            v-model:rows="filters.rows" :routeName="routeName" :total="organizationRegistrations.meta.total">
            <template #filters>
                <FormField class="order-2 sm:order-1" label="Tipo de Organización">
                    <FormControl v-model="filters.organization_type" @change="applyFilters(true)" 
                        placeholder="Seleccione un tipo" :options="props.organizationTypes" />
                </FormField>
            </template>
        </SearchBar>

        <RequestRecords @open-modal="openModal" :requests="organizationRegistrations" />

        <ReusableModal :show="showModal" :registration="selectedItem" @close="closeModal" @update-status="updateStatus" />
    </LayoutMain>
</template>

<script setup>
import { ref, provide } from 'vue';
import HeadLogo from '@/Components/HeadLogo.vue';
import LayoutMain from '@/Layouts/LayoutMain.vue';
import SectionTitleLineWithButton from '@/Components/SectionTitleLineWithButton.vue';
import SearchBar from '@/Components/SearchBar.vue';
import FormField from "@/Components/FormField.vue";
import FormControl from "@/Components/FormControl.vue";
import RequestRecords from '../Components/RequestRecords.vue';
import ReusableModal from '../Components/OrganizationStatusModal.vue';
import { useFilters } from "@/Hooks/useFilters";
import { router } from '@inertiajs/vue3';
import { mdiBookEducation } from '@mdi/js';

const props = defineProps({
    title: {
        type: String,
        required: true,
    },
    organizationRegistrations: {
        type: Object,
        required: true,
        default: () => ({}),
    },
    organizationTypes: {
        type: Array,
        required: true,
        default: () => [],
    },
    routeName: {
        type: String,
        required: true,
    },
    filters: {
        type: Object,
        required: true,
    },
});

const { filters, clearFilters, applyFilters, isLoading, sortByColumn } = useFilters(props.filters, props.routeName);

if (filters.organization_type === undefined) {
    filters.organization_type = null;
}

provide('filters', filters);
provide('sortByColumn', sortByColumn);

const showModal = ref(false);
const selectedItem = ref(null);

const openModal = (item) => {
    selectedItem.value = item;
    showModal.value = true;
};

const closeModal = () => {
    showModal.value = false;
    selectedItem.value = null;
};

const updateStatus = (data) => {
    if (!selectedItem.value) return;
    
    router.post(
        route('requests.update-status', selectedItem.value.id),
        data,
        {
            preserveScroll: true,
            preserveState: true,
            onSuccess: () => {
                closeModal();
            },
        }
    );
};
</script>