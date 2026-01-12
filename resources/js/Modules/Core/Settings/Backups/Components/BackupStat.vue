<template>
    <div class="p-4 bg-card border border-border rounded-lg">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-forest-400">{{ label }}</p>
                <p class="text-lg font-light">{{ description }}</p>
            </div>
            <component :is="icon" class="w-8 h-8 text-forest-400" />
        </div>
    </div>
</template>

<script setup>
defineProps({
    label: String,
    description: String | Number,
    icon: Function
});
</script>