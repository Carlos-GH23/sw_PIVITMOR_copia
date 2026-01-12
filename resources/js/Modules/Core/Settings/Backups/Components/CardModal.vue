<template>
    <button
        class="h-auto py-6 flex flex-col items-center gap-3 bg-card hover:bg-mono-100 hover:cursor-pointer rounded-lg border-2 border-border text-card-foreground transition-colors">
        <component :is="icon" class="w-5 h-5 text-forest-400" />

        <div class="text-center">
            <div class="font-semibold text-base text-forest-400">{{ label }}</div>
            <div class="text-xs font-normal">{{ description }}</div>
        </div>
    </button>
</template>

<script setup>
defineProps({
    label: String,
    description: String,
    icon: Function
});
</script>