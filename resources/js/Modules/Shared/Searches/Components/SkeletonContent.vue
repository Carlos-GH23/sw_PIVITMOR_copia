<template>
    <div class="border rounded-lg border-forest-50/40">
        <div class="pb-2 pt-5 px-5">
            <div class="flex justify-between items-start mb-4">
                <Skeleton class="w-28 h-5 rounded-full" />
                <Skeleton class="w-16 h-5 rounded-full" />
            </div>

            <div class="flex flex-col text-xs text-slate-500 gap-1">
                <Skeleton class="w-28 h-2 mb-2" />
                <Skeleton class="w-full h-4 mb-1" />
                <Skeleton class="w-28 h-4" />
            </div>

            <div class="mt-4 space-y-2">
                <Skeleton class="w-full h-2" />
                <Skeleton class="w-full h-2" />
                <Skeleton class="w-full h-2" />
            </div>

            <div class="flex flex-row mt-4 gap-2">
                <Skeleton class="w-28 h-3 rounded-full" />
                <Skeleton class="w-28 h-3 rounded-full" />
                <Skeleton class="w-28 h-3 rounded-full" />
            </div>
        </div>

        <Separator class="bg-slate-100" />

        <div class="px-5 py-3 bg-slate-50/50 flex justify-end items-center mt-auto">
            <div class="h-6 w-28 bg-mono-100 rounded"></div>
        </div>
    </div>
</template>

<script setup>
import Separator from '@/Components/ui/separator/Separator.vue';
import Skeleton from '@/Components/ui/skeleton/Skeleton.vue';
</script>
