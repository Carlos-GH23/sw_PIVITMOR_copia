<template>
    <div class="col-span-3 flex flex-col justify-between min-h-[400px]"
        :class="{ 'border-2 border-forest-50/40 rounded-lg items-center justify-center': !hasResults && !isLoading }">

        <div v-if="isLoading" class="grid sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-2 gap-4">
            <SkeletonContent v-for="item in 8" :key="item" />
        </div>

        <div v-else-if="hasResults" class="grid sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-2 gap-4">
            <ResultCard @open-modal="$emit('openModal', $event)" v-for="result in results.data"
                :key="`${result.id}_${result.resource_type}`" :data="result" />
        </div>

        <CardBoxComponentEmpty v-else imageClasses="w-48 h-48" :type="hasActiveSearch ? 'notFound' : 'idle'" />

        <div v-if="hasResults">
            <Pagination :links="results.links" :total="results.total" :to="results.to" :from="results.from" />
        </div>
    </div>
</template>

<script setup>
import CardBoxComponentEmpty from '@/Components/CardBoxComponentEmpty.vue';
import Pagination from '@/Components/Pagination.vue';
import ResultCard from './ResultCard.vue';
import SkeletonContent from './SkeletonContent.vue';
import { computed } from 'vue';

const props = defineProps({
    isLoading: {
        type: Boolean,
        required: true
    },
    hasActiveSearch: {
        type: Boolean,
        required: true
    },
    results: {
        type: Object,
        required: true
    },
    search: {
        type: String,
        required: false,
        default: ''
    }
});

const hasResults = computed(() => props.results.data.length > 0);
</script>