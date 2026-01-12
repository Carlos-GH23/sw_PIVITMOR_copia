<template>
    <div class="bg-white dark:bg-slate-800 rounded-lg shadow p-4 border-l-4" :class="borderColorClass">
        <p class="text-sm text-gray-500 dark:text-gray-400">{{ title }}</p>
        <p class="text-2xl font-bold mt-1" :class="textColorClass">{{ value }}</p>
    </div>
</template>

<script setup>
import { computed } from 'vue';

const props = defineProps({
    title: {
        type: String,
        required: true,
    },
    value: {
        type: [String, Number],
        required: true,
    },
    color: {
        type: String,
        default: 'blue',
    },
});

const colorMap = {
    blue: {
        border: 'border-blue-500',
        text: 'text-blue-600 dark:text-blue-400',
    },
    green: {
        border: 'border-green-500',
        text: 'text-green-600 dark:text-green-400',
    },
    red: {
        border: 'border-red-500',
        text: 'text-red-600 dark:text-red-400',
    },
    yellow: {
        border: 'border-yellow-500',
        text: 'text-yellow-600 dark:text-yellow-400',
    },
    forest: {
        border: 'border-forest-500',
        text: 'text-forest-600 dark:text-forest-400',
    },
};

const borderColorClass = computed(() => colorMap[props.color]?.border || colorMap.blue.border);
const textColorClass = computed(() => colorMap[props.color]?.text || colorMap.blue.text);
</script>