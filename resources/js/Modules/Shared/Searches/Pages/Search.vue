<template>
    <HeadLogo :title="title" />

    <LayoutAuthenticated>
        <SectionTitleLineWithButton :icon="mdiLayersSearch" :title="title" main />

        <div class="relative grid grid-cols-1 gap-y-4 xl:grid-cols-4 xl:gap-4">
            <AsideFilters @apply-filters="applyFilters" @clearFilters="clearFilters" :filters="filters"
                :filterOptions="filterOptions" />

            <ResultList @open-modal="openModal" :isLoading="isLoading" :hasActiveSearch="hasActiveSearch"
                :results="results" :search="filters.keywords" />
        </div>
    </LayoutAuthenticated>

    <ResultDetailModal @close="closeModal" :show="isOpen" :isLoading="isLoadingModal" :initialData="initialData"
        :resultDetails="resultDetails" />
</template>

<script setup>
import AsideFilters from '../Components/AsideFilters.vue';
import HeadLogo from '@/Components/HeadLogo.vue';
import LayoutAuthenticated from '@/Layouts/LayoutAuthenticated.vue';
import ResultList from '../Components/ResultList.vue';
import ResultDetailModal from '@/Components/Domains/Searches/ResultDetailModal.vue';
import SectionTitleLineWithButton from '@/Components/SectionTitleLineWithButton.vue';
import { mdiLayersSearch } from '@mdi/js';
import { useFilters } from '../Composables/useFilters';
import { useResultModal } from '@/Hooks/useResultModal';
import { computed } from 'vue';

const props = defineProps({
    title: {
        type: String,
        required: true,
    },
    routeName: {
        type: String,
        required: true,
    },
    economicSectors: {
        type: Object,
        required: true
    },
    filters: {
        type: Object,
        required: true
    },
    municipalities: {
        type: Object,
        required: true
    },
    oecdSectors: {
        type: Object,
        required: true
    },
    researchAreas: {
        type: Object,
        required: true
    },
    results: {
        type: Object,
        required: true
    },
    sniLevels: {
        type: Object,
        required: true
    },
    techLevels: {
        type: Object,
        required: true
    },
    intellectualProperties: {
        type: Object,
        required: true
    }
});

const filterOptions = computed(() => ({
    economicSectors: props.economicSectors,
    municipalities: props.municipalities,
    oecdSectors: props.oecdSectors,
    researchAreas: props.researchAreas,
    sniLevels: props.sniLevels,
    techLevels: props.techLevels,
    intellectualProperties: props.intellectualProperties
}));

const { filters, clearFilters, applyFilters, isLoading, hasActiveSearch } = useFilters(props.filters, props.routeName);
const { openModal, closeModal, isOpen, initialData, isLoading: isLoadingModal, resultDetails } = useResultModal(props);
</script>