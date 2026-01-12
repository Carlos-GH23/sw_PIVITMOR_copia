<template>
    <HeadLogo :title="title" />
    <loading v-model:active="isLoading" :can-cancel="false" :is-full-page="true" loader="dots" color="#283C2A" />
    <LayoutMain>
        <SectionTitleLineWithButton :icon="mdiAccountWrench" :title="title" main />

        <SearchBar @apply-filters="applyFilters" @clear-filters="clearFilters" v-model:search="filters.search"
            v-model:rows="filters.rows" :total="technologyServices.meta.total" />

        <TechnologyServiceRecords :routeName="routeName" :technologyServices="technologyServices" />

    </LayoutMain>
</template>
<script setup>

import HeadLogo from "@/Components/HeadLogo.vue";
import LayoutMain from "@/Layouts/LayoutMain.vue";

import SearchBar from "@/Components/SearchBar.vue";
import SectionTitleLineWithButton from "@/Components/SectionTitleLineWithButton.vue";
import { useFilters } from "@/Hooks/useFilters";
import { mdiAccountWrench } from "@mdi/js";
import TechnologyServiceRecords from "../Components/TechnologyServiceRecords.vue";
import { provide } from "vue";

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

provide('filters', filters);
provide('sortByColumn', sortByColumn);
</script>
