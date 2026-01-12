<template>
    <div class="flex border-t-2 border-gray-200 items-center justify-between py-6 px-3 transition-colors duration-200 hover:cursor-pointer"
        :class="isActive ? 'bg-gray-100' : 'hover:bg-gray-100'">
        <span class="font-medium text-gray-900">{{ label }}</span>
        <div v-if="!$slots.default" class="flex items-center space-x-2">
            <span v-if="count > 0" class="bg-forest-100 text-white text-xs px-2 py-1 rounded-full">
                {{ count }}
            </span>
            <BaseIcon size="20" w="w-6" h="h-6" :path="mdiChevronRight" />
        </div>
        <slot />
    </div>
</template>

<script setup>
import BaseIcon from '@/Components/BaseIcon.vue';
import { mdiChevronRight } from '@mdi/js';

const props = defineProps({
    label: {
        type: String,
        required: true,
    },
    count: {
        type: Number,
        default: null,
    },
    isActive: {
        type: Boolean,
        default: false,
    },
});
</script>