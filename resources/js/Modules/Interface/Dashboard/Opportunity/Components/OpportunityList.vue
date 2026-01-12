<template>
    <div v-if="isLoading || isRestoring">
        <RestoringLoader v-if="isRestoring" />
        <SkeletonCard />
    </div>

    <div v-else-if="opportunities.data.length > 0" class="grid lg:grid-cols-2 xl:grid-cols-3 gap-6">
        <OpportunityCard @open-details="$emit('openDetails', $event)" v-for="item in opportunities.data"
            :key="`${item.resource_type}-${item.id}`" :item="item" />
    </div>

    <CardBoxComponentEmpty v-else imageClasses="w-48 h-48" :type="hasActiveSearch ? 'notFound' : 'idle'" />

    <Pagination v-if="opportunities.data.length > 0 && !isRestoring" :links="opportunities.links"
        :total="opportunities.total" :from="opportunities.from" :to="opportunities.to" />
</template>

<script setup>
import CardBoxComponentEmpty from '@/Components/CardBoxComponentEmpty.vue';
import OpportunityCard from './OpportunityCard.vue';
import Pagination from '@/Components/Pagination.vue';
import RestoringLoader from './RestoringLoader.vue';
import SkeletonCard from './SkeletonCard.vue';
import { hasActiveFilters } from "@/Helpers/filter";
import { computed } from 'vue';

const props = defineProps({
    opportunities: {
        type: Object,
        required: true
    },
    filters: {
        type: Object,
        required: true
    },
    isLoading: {
        type: Boolean,
        required: true
    },
    isRestoring: {
        type: Boolean,
        required: true
    }
});

defineEmits(['openDetails']);

const hasActiveSearch = computed(() => {
    return hasActiveFilters(props.filters, ['page']);
});
</script>
