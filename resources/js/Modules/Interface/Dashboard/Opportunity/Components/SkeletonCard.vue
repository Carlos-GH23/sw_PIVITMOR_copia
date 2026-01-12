<template>
    <div class="grid lg:grid-cols-2 xl:grid-cols-3 gap-6">
        <div v-for="item in 6" class="relative border border-gray-200 rounded-lg">
            <div class="h-36 sm:h-44 md:h-48 lg:h-52 w-full">
                <Skeleton class="w-full h-full" />
            </div>
            <Skeleton class="absolute top-3 left-3 w-20 h-6 rounded-full" />

            <div class="flex-1 p-4 flex flex-col">
                <Skeleton class="w-32 py-2.5 h-6 rounded-full mb-2 sm:mb-3" />
                <Skeleton class="w-full py-2.5 h-14 rounded-full" />
            </div>
        </div>
    </div>
</template>

<script setup>
import Skeleton from '@/Components/ui/skeleton/Skeleton.vue';
</script>
