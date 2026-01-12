<template>
    <CardBox>
        <div>
            <div class="flex items-start justify-between mb-3">
                <p class="text-sm text-foreground leading-tight text-forest-400">{{ title }}</p>
                <BaseIcon :path="icon" class="w-5 h-5 text-forest-400" size="24" />
            </div>
            <slot name="content" />
            <p class="text-xs line-clamp-1">
                <slot name="footer" />
            </p>
        </div>
    </CardBox>
</template>
<script setup>
import CardBox from '@/Components/CardBox.vue';
import BaseIcon from '@/Components/BaseIcon.vue';

defineProps({
    title: {
        type: String,
        required: true,
    },
    icon: {
        type: String,
        required: true,
    },
});
</script>