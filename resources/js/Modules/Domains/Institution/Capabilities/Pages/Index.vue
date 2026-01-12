<template>
    <HeadLogo :title="title" />
    <loading v-model:active="isLoading" :canCancel="false" :isFullPage="true" loader="dots" color="#283C2A" />
    <LayoutMain>
        <SectionTitleLineWithButton :icon="mdiOffer" :title="title" main />

        <SearchBar @apply-filters="applyFilters" @clear-filters="clearFilters" v-model:search="filters.search"
            v-model:rows="filters.rows" :routeName="routeName" title="oferta" :total="capabilities.meta.total" />

        <CapabilityRecords @open-form="openForm" :capabilities="capabilities" :routeName="routeName" />

        <ValidityForm @close="close" :record="record" :routeName="routeName" :show="isOpen" />
    </LayoutMain>
</template>

<script setup>
import CapabilityRecords from '../Components/CapabilityRecords.vue';
import HeadLogo from '@/Components/HeadLogo.vue';
import LayoutMain from '@/Layouts/LayoutMain.vue';
import SearchBar from '@/Components/SearchBar.vue';
import SectionTitleLineWithButton from '@/Components/SectionTitleLineWithButton.vue';
import ValidityForm from '@/Components/ValidityForm.vue';
import { mdiOffer } from '@mdi/js';
import { useFilters } from '@/Hooks/useFilters';
import { useModal } from '@/Hooks/useModal';
import { provide, ref } from 'vue';
import { usePageTracker } from '@/Hooks/usePageTracker';

const props = defineProps({
    title: {
        type: String,
        required: true,
    },
    capabilities: {
        type: Object,
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