<template>
    <HeadLogo title="Dashboard" />
    <LayoutAuthenticated>
        <SectionTitleLineWithButton :icon="mdiMonitorDashboard" :title="title" :description="description" main
            :hisBreadCrumb="false" />

        <SearchBar @open-filters="openFilters" @clear-filters="clearFilters" :filters="filters"
            :totalResults="opportunities?.total" />

        <OpportunityList @open-details="openModal" :filters="filters" :isLoading="isLoading" :isRestoring="isRestoring"
            :opportunities="opportunities" />

        <FiltersModal @apply-filters="applyFilters" @close="closeFilters" v-model="filters"
            :intellectualProperties="intellectualProperties" :show="isOpenFilters" />

        <ResultDetailModal @close="closeModal" :show="isOpen" :isLoading="isLoadingModal" :initialData="initialData"
            :resultDetails="resultDetails" />
    </LayoutAuthenticated>
</template>

<script setup>
import HeadLogo from '@/Components/HeadLogo.vue';
import FiltersModal from '../Components/FiltersModal.vue';
import LayoutAuthenticated from '@/Layouts/LayoutAuthenticated.vue';
import OpportunityList from '../Components/OpportunityList.vue';
import ResultDetailModal from '@/Components/Domains/Searches/ResultDetailModal.vue';
import SearchBar from '../Components/SearchBar.vue';
import SectionTitleLineWithButton from '@/Components/SectionTitleLineWithButton.vue';
import { mdiMonitorDashboard } from '@mdi/js';
import { useFilters } from '../Composables/useFilters';
import { useResultModal } from '@/Hooks/useResultModal';

const props = defineProps({
    title: {
        type: String,
        required: true
    },
    description: {
        type: String,
        required: true
    },
    filters: {
        type: Object,
        required: true
    },
    routeName: {
        type: String,
        required: true
    },
    intellectualProperties: {
        type: Array,
        required: true
    },
    opportunities: {
        type: Object,
        required: true
    },
});

const { filters, isLoading, isRestoring, applyFilters, clearFilters, openFilters, closeFilters, isOpenFilters } = useFilters(props.filters, props.routeName);
const { openModal, closeModal, isOpen, initialData, isLoading: isLoadingModal, resultDetails } = useResultModal(props);

</script>
