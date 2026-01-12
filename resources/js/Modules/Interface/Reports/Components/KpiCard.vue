<template>
    <CardBox>
        <div>
            <div class="flex items-start justify-between mb-3">
                <p class="text-sm text-foreground leading-tight text-forest-400">{{ label }}</p>
                <BaseIcon :path="icon" class="w-5 h-5 text-forest-400" size="24" />
            </div>
            <span class="text-3xl font-bold py-2">{{ value }}</span>
            <p class="text-xs font-normal">{{ subtitle }}</p>
        </div>
    </CardBox>
</template>

<script setup>
import BaseIcon from '@/Components/BaseIcon.vue';
import CardBox from '@/Components/CardBox.vue';

defineProps({
    label: {
        type: String,
        required: true,
    },
    value: {
        type: [String, Number],
        required: true,
    },
    subtitle: {
        type: String,
        required: true,
    },
    icon: {
        type: String,
        required: true,
    },
});
</script>
