<template>
    <div class="bg-mono-300/20">
        <div class="text-mono-400 max-w-7xl mx-auto 
            space-y-10 sm:space-y-14 lg:space-y-20 
            px-4 sm:px-6 lg:px-8 
            py-12 sm:py-14 lg:py-18">
            <slot />
        </div>
        <Layer v-if="hasLayer" />
    </div>
</template>
<script setup>
import Layer from '@/Components/Layer.vue';

defineProps({
    hasLayer: {
        type: Boolean,
        default: true
    }
})
</script>