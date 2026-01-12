<template>
    <div class="w-full">
        <h2 class="mb-2 text-lg font-medium text-heading">
            {{ title }}
        </h2>
        <slot />

        <BaseDivider v-if="hasDivider" />
    </div>
</template>
<script setup>
import BaseDivider from '@/Components/BaseDivider.vue';

defineProps({
    title: {
        type: String,
        required: true
    },
    hasDivider: {
        type: Boolean,
        default: true
    }
})
</script>