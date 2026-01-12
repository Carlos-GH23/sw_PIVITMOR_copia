<template>
    <div class="grid gap-4 md:grid-cols-2">
        <div v-for="academic in academics" :key="academic.id"
            class="flex items-center gap-4 p-4 bg-gray-50 rounded-lg border border-gray-200">
            <div v-if="academic.photo" class="w-16 h-16 rounded-full overflow-hidden flex-shrink-0">
                <img :src="academic.photo.url || academic.photo.path" :alt="academic.name"
                    class="w-full h-full object-cover" />
            </div>
            <div v-else class="w-16 h-16 rounded-full bg-white flex items-center justify-center flex-shrink-0 border">
                <BaseIcon :path="mdiAccount" class="w-8 h-8 text-forest-400" />
            </div>
            <div class="flex-1">
                <p class="font-semibold text-gray-900">{{ academic.name }}</p>
                <p v-if="academic.academic_position" class="text-sm text-gray-600">
                    {{ academic.academic_position.name }}
                </p>
            </div>
        </div>
    </div>
</template>

<script setup>
import BaseIcon from '@/Components/BaseIcon.vue';
import { mdiAccount } from '@mdi/js';

defineProps({
    academics: {
        type: Array,
        required: true
    }
});
</script>