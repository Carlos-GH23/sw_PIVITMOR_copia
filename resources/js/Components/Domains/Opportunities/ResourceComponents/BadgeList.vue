<template>
    <div class="flex flex-wrap gap-2">
        <Badge v-for="item in items" :key="item.id" variant="soft" color="forest">
            {{ item.name }}
        </Badge>
    </div>
</template>

<script setup>
import Badge from '@/Components/Badge.vue';

defineProps({
    items: {
        type: Array,
        required: true
    }
});
</script>