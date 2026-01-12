<template>
    <HeadLogo :title="title" />
    <loading v-model:active="isLoading" :can-cancel="false" :is-full-page="true" loader="dots" color="#283C2A" />
    <LayoutMain>
        <SectionTitleLineWithButton :icon="mdiHandCoin" :title="title" main />

        <SearchBar @apply-filters="applyFilters" @clear-filters="clearFilters" v-model:search="filters.search"
            v-model:rows="filters.rows" :routeName="routeName" :total="requirements.meta.total" />

        <RequirementRecords @open-form="openForm" :requirements="requirements" :routeName="routeName" />
        <ValidityForm @close="close" :record="record" :routeName="routeName" :show="isOpen" />
    </LayoutMain>
</template>
<script setup>
import LayoutMain from "@/Layouts/LayoutMain.vue";
import SectionTitleLineWithButton from "@/Components/SectionTitleLineWithButton.vue";
import {
    mdiHandCoin,
} from "@mdi/js";
import HeadLogo from "@/Components/HeadLogo.vue";
import { useFilters } from "@/Hooks/useFilters";
import SearchBar from "@/Components/SearchBar.vue";
import RequirementRecords from "../Components/RequirementRecords.vue";
import { useModal } from "@/Hooks/useModal";
import ValidityForm from "@/Components/ValidityForm.vue";
import { provide, ref } from "vue";
import { usePageTracker } from '@/Hooks/usePageTracker';

const props = defineProps({
    title: {
        type: String,
        required: true,
    },
    requirements: {
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