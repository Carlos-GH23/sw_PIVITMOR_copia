<template>
    <HeadLogo :title="title" />
    <loading v-model:active="isLoading" :can-cancel="false" :is-full-page="true" loader="dots" color="#283C2A" />
    <LayoutMain>
        <SectionTitleLineWithButton :icon="mdiBullhorn" :title="title" main />
        <SearchBar @apply-filters="applyFilters" @clear-filters="clearFilters" v-model:search="filters.search"
            :routeName="routeName" title=" " :total="notices?.meta?.total || 0" />

        <NoticeRecords :routeName="routeName" :notices="notices" :filters="filters" :sortByColumn="sortByColumn" />
    </LayoutMain>
</template>

<script setup>
import NoticeRecords from '../Components/NoticeRecords.vue';
import HeadLogo from '@/Components/HeadLogo.vue';
import LayoutMain from '@/Layouts/LayoutMain.vue';
import SectionTitleLineWithButton from '@/Components/SectionTitleLineWithButton.vue';
import { mdiBullhorn } from '@mdi/js';
import SearchBar from '@/Components/SearchBar.vue';
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
    notices: {
        type: Object,
        required: true,
    },
    filters: {
        type: Object,
        required: false
    }
});


const { filters, clearFilters, applyFilters, isLoading, sortByColumn } = useFilters(props.filters, props.routeName);
</script>