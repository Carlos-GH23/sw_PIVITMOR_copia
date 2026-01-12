<template>
    <div class="flex flex-wrap gap-2 mb-2 overflow-x-auto">
        <span v-for="(record, index) in visibleRecords" :key="index"
            class="px-3 py-1 text-xs font-semibold text-amber-700 bg-amber-50 rounded-full border border-amber-200 whitespace-nowrap overflow-hidden text-ellipsis flex-shrink-0">
            {{ record }}
        </span>
        <button v-if="hasMoreRecords" @click="$emit('show-all')"
            class="px-3 py-1 text-xs font-semibold text-amber-700 bg-amber-50 rounded-full border border-amber-200 cursor-pointer hover:bg-amber-100 flex-shrink-0 whitespace-nowrap">
            + {{ remainingCount }}
        </button>
    </div>
</template>

<script setup>
import { computed } from 'vue';

const props = defineProps({
    records: {
        type: Array,
        default: () => []
    },
    maxVisible: {
        type: Number,
        default: 3
    }
});

defineEmits(['show-all']);

const visibleRecords = computed(() => props.records.slice(0, props.maxVisible));
const hasMoreRecords = computed(() => props.records.length > props.maxVisible);
const remainingCount = computed(() => props.records.length - props.maxVisible);
</script>
