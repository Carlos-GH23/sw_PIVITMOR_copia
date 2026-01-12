<template>
    <div class="flex flex-col justify-center items-center text-center">
        <img :src="icon" class="w-14 h-14 aspect-square object-contain" loading="lazy" />
        <div class="text-3xl font-bold text-mono-400 mb-2">{{ amount }}+</div>
        <div class="text-sm text-gray-600">{{ category }}</div>
    </div>
</template>

<script setup>
defineProps({
    amount: Number,
    category: String,
    icon: String,
})
</script>