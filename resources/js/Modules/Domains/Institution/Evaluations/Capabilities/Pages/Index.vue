<template>
    <HeadLogo :title="title" />

    <LayoutMain>
        <SectionTitleLineWithButton :icon="mdiHandCoin" :title="title" main />

        <SearchBar @apply-filters="applyFilters" @clear-filters="clearFilters" v-model:search="filters.search"
            v-model:rows="filters.rows" :total="capabilities.meta.total" />

        <CapabilityRecords :routeName="routeName" :capabilities="capabilities" />
    </LayoutMain>

    <loading v-model:active="isLoading" :canCancel="false" :isFullPage="true" loader="dots" color="#283C2A" />
</template>

<script setup>

import HeadLogo from "@/Components/HeadLogo.vue";
import CapabilityRecords from "../Components/CapabilityRecords.vue";
import LayoutMain from "@/Layouts/LayoutMain.vue";
import SearchBar from "@/Components/SearchBar.vue";
import SectionTitleLineWithButton from "@/Components/SectionTitleLineWithButton.vue";
import { useFilters } from "@/Hooks/useFilters";
import { mdiHandCoin } from "@mdi/js";
import { provide } from "vue";

const props = defineProps({
    title: {
        type: String,
        required: true,
    },
    capabilities: {
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