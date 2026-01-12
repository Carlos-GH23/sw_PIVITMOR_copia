<template>
    <HeadLogo :title="title" />
    <loading v-model:active="isLoading" :canCancel="false" :isFullPage="true" loader="dots" color="#283C2A" />
    <LayoutMain>
        <SectionTitleLineWithButton :icon="mdiAccountWrench" :title="title" main />

        <SearchBar @apply-filters="applyFilters" @clear-filters="clearFilters" v-model:search="filters.search"
            v-model:rows="filters.rows" :routeName="routeName" title="oferta laboral" :total="jobOffers?.meta?.total ?? 0" />

        <JobOfferRecords :routeName="routeName" :job-offers="jobOffers" />
    </LayoutMain>
</template>

<script setup>
import JobOfferRecords from '../Components/JobOfferRecords.vue';
import HeadLogo from '@/Components/HeadLogo.vue';
import LayoutMain from '@/Layouts/LayoutMain.vue';
import SearchBar from '@/Components/SearchBar.vue';
import SectionTitleLineWithButton from '@/Components/SectionTitleLineWithButton.vue';
import { mdiAccountWrench } from '@mdi/js';
import { useFilters } from '@/Hooks/useFilters';
import { provide } from 'vue';
import { usePageTracker } from '@/Hooks/usePageTracker';

const props = defineProps({
    title: {
        type: String,
        required: true,
    },
    jobOffers: {
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

provide('sortByColumn', sortByColumn);
provide('filters', filters);

usePageTracker();
</script>