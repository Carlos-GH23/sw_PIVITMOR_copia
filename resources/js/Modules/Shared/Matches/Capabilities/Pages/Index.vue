<template>
    <HeadLogo :title="title" />

    <LayoutMain>
        <SectionTitleLineWithButton :icon="mdiOffer" :title="title" main />

        <SearchBar @apply-filters="applyFilters" @clear-filters="clearFilters" v-model:search="filters.search"
            v-model:rows="filters.rows" :total="matches.total" />

        <MatchRecords @open-form="openForm" :routeName="routeName" :matches="matches" />
        <EvaluationForm @close="closeForm" :match="match" :onAccept="onAccept" :onReject="onReject" :show="isOpen" />
    </LayoutMain>

    <loading v-model:active="isLoading" :can-cancel="false" :is-full-page="true" loader="dots" color="#283C2A" />
</template>

<script setup>
import MatchRecords from '../Components/MatchRecords.vue';
import HeadLogo from '@/Components/HeadLogo.vue';
import EvaluationForm from '../Components/EvaluationForm.vue';
import LayoutMain from '@/Layouts/LayoutMain.vue';
import SearchBar from '@/Components/SearchBar.vue';
import SectionTitleLineWithButton from '@/Components/SectionTitleLineWithButton.vue';
import { mdiOffer } from '@mdi/js';
import { useFilters } from '@/Hooks/useFilters';
import { useMatch } from '../Composables/useMatch';
import { provide } from 'vue';

const props = defineProps({
    title: {
        type: String,
        required: true,
    },
    matches: {
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

const { filters, clearFilters, applyFilters, isLoading, sortByColumn, setLoading } = useFilters(props.filters, props.routeName);
const { isOpen, match, openForm, closeForm, onAccept, onReject, } = useMatch(props.routeName, setLoading);

provide('filters', filters);
provide('sortByColumn', sortByColumn);
</script>