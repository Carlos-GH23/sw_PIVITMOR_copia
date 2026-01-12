<template>
    <HeadLogo :title="title" />
    <loading v-model:active="isLoading" :can-cancel="false" :is-full-page="true" loader="dots" color="#283C2A" />
    <LayoutMain>
        <SectionTitleLineWithButton :icon="mdiFileCertificate" :title="title" main />

        <SearchBar @apply-filters="applyFilters" @clear-filters="clearFilters" v-model:search="filters.search"
            v-model:rows="filters.rows" :routeName="routeName" title="certificación" :total="certifications?.meta?.total || 0" />

        <CertificationRecords :routeName="routeName" :certifications="certifications" :sortByColumn="sortByColumn" :filters="filters" />
    </LayoutMain>
</template>
<script setup>
import CertificationRecords from '../Components/CertificationRecords.vue';
import HeadLogo from '@/Components/HeadLogo.vue';
import LayoutMain from '@/Layouts/LayoutMain.vue';
import SearchBar from '@/Components/SearchBar.vue';
import SectionTitleLineWithButton from '@/Components/SectionTitleLineWithButton.vue';
import { mdiFileCertificate } from '@mdi/js';
import { useFilters } from '@/Hooks/useFilters';


const props = defineProps({
    title: {
        type: String,
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
    certifications: {
        type: Object,
        required: true
    }
});

const { filters, clearFilters, applyFilters, isLoading, sortByColumn } = useFilters(props.filters, props.routeName);


</script>