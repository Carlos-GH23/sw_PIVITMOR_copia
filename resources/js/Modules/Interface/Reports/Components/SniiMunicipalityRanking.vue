<template>
    <div class="overflow-y-auto h-96 pr-2">
        <div v-if="!data || data.length === 0" class="flex items-center justify-center h-full text-neutral-500 text-sm">
            <CardBoxComponentEmpty/>
        </div>
        <div v-else class="space-y-3">
            <div v-for="(item, index) in data" :key="index"
                class="flex items-center justify-between p-3 bg-neutral-50 rounded-lg border border-neutral-100">
                <div class="flex items-center gap-3">
                    <span
                        class="flex items-center justify-center w-6 h-6 rounded-full bg-neutral-200 text-xs font-medium text-neutral-600">
                        {{ index + 1 }}
                    </span>
                    <span class="text-sm font-medium text-neutral-700 capitalize">
                        {{ item.municipality }}
                    </span>
                </div>
                <div class="flex items-center gap-2">
                    <span class="text-sm font-bold text-primary-700">
                        {{ item.count }}
                    </span>
                    <span class="text-xs text-neutral-500">SNII</span>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import CardBoxComponentEmpty from '@/Components/CardBoxComponentEmpty.vue';

defineProps({
    data: {
        type: Array,
        default: () => []
    }
});
</script>
