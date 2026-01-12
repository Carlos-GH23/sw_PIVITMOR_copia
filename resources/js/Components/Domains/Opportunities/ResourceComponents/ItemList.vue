<template>
    <div class="space-y-2">
        <div v-for="item in items" :key="item.id" class="p-4 bg-gray-50 rounded-lg border border-gray-200">
            <p class="font-semibold text-gray-900">{{ item.name }}</p>
            <p v-if="item.description" class="text-sm text-gray-600 mt-1">
                {{ item.description }}
            </p>
        </div>
    </div>
</template>

<script setup>
defineProps({
    items: {
        type: Array,
        required: true
    }
});
</script>