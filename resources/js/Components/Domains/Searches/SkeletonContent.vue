<template>
    <div class="h-[calc(100vh-10rem)]">
        <div class="w-full grid grid-cols-3 gap-4 mb-6">
            <Skeleton class="h-10 w-full rounded-md" />
            <Skeleton class="h-10 w-full rounded-md" />
            <Skeleton class="h-10 w-full rounded-md" />
        </div>
        <div class="space-y-3 animate-pulse">
            <Skeleton class="h-40 w-full" />
            <Skeleton class="h-40 w-full" />
            <Skeleton class="h-40 w-full" />
            <Skeleton class="h-40 w-full" />
        </div>
    </div>
</template>

<script setup>
import Skeleton from '@/Components/ui/skeleton/Skeleton.vue';
</script>
