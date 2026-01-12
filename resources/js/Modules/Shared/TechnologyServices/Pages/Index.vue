<template>
    <HeadLogo :title="title" />
    <loading v-model:active="isLoading" :can-cancel="false" :is-full-page="true" loader="dots" color="#283C2A" />
    <LayoutMain>
        <SectionTitleLineWithButton :icon="mdiServer" :title="title" main />

        <SearchBar @apply-filters="applyFilters" @clear-filters="clearFilters" v-model:search="filters.search"
            v-model:rows="filters.rows" :routeName="routeName" title="servicio tecnológico" :total="technologyServices?.meta?.total || 0" />

        <ServiceRecords @open-form="openForm" :routeName="routeName" :technologyServices="technologyServices" />

        <ValidityForm @close="close" :record="record" :routeName="routeName" :show="isOpen" />
    </LayoutMain>
</template>

<script setup>
import ServiceRecords from '../Components/ServiceRecords.vue';
import HeadLogo from '@/Components/HeadLogo.vue';
import LayoutMain from '@/Layouts/LayoutMain.vue';
import SearchBar from '@/Components/SearchBar.vue';
import SectionTitleLineWithButton from '@/Components/SectionTitleLineWithButton.vue';
import ValidityForm from '@/Components/ValidityForm.vue';
import { mdiServer } from '@mdi/js';
import { useFilters } from '@/Hooks/useFilters';
import { useModal } from '@/Hooks/useModal';
import { provide, ref } from 'vue';
import { usePageTracker } from '@/Hooks/usePageTracker';

const props = defineProps({
    title: {
        type: String,
        required: true,
    },
    technologyServices: {
        type: Object,
        default: () => ({}),
        required: true,
    },
    routeName: {
        type: String,
        required: true,
    },
    filters: {
        type: Object,
        required: true
    },
});

const { filters, clearFilters, applyFilters, isLoading, sortByColumn } = useFilters(props.filters, props.routeName);
const { isOpen, open, close } = useModal();
const record = ref({});

const openForm = (item) => {
    record.value = item;
    open();
};

provide('filters', filters);
provide('sortByColumn', sortByColumn);

usePageTracker();
</script>