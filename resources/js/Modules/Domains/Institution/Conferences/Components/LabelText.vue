<template>
    <div class="border-l-4 pl-4" :class="text ? 'border-wine-100' : 'border-slate-500'">
        <label class="text-sm font-medium text-forest-400">{{ label }}</label>
        <div v-html="text" class="ql-content leading-relaxed mt-1"></div>
    </div>
</template>

<script setup>
defineProps({
    label: String,
    text: String
});
</script>
