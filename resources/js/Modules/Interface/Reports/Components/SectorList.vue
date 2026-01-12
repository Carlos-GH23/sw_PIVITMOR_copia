<template>
    <ul class="max-w-md space-y-1 text-gray-800 list-disc list-inside dark:text-gray-400">
        <li v-for="(sector, i) in visibleSectors" :key="i">
            <span>{{ sector }}</span>
        </li>
        <li v-if="hasMore" class="list-none ml-[-1rem] pl-4">
            <button class="hover:text-forest-100 cursor-pointer text-sm" @click="showAll = !showAll">
                {{ showAll ? 'Ver menos...' : `Ver más...` }}
            </button>
        </li>
    </ul>
</template>

<script setup>
import { ref, computed } from 'vue';

const props = defineProps({
    sectors: {
        type: Array,
        required: true,
    },
    maxVisible: {
        type: Number,
        default: 2,
    },
});

const showAll = ref(false);

const visibleSectors = computed(() => {
    if (showAll.value) return props.sectors;
    return props.sectors.slice(0, props.maxVisible);
});

const hasMore = computed(() => props.sectors.length > props.maxVisible);
</script>