<template>
    <div
        class="gradient-card border-0 shadow-xl hover:shadow-2xl transition-all duration-300 hover:-translate-y-2 group">
        <div class="p-8 text-center min-h-[450px] flex flex-col justify-between">
            <div class="w-16 h-16 rounded-full flex items-center justify-center mx-auto
                mb-6 group-hover:scale-110 group-hover:bg-wine-50 transition-all duration-300" :class="color">
                <BaseIcon class="text-wine-50 group-hover:text-white " size="36" w="w-14" h="h-14" :path="icon" />
            </div>

            <h3 class="text-xl font-bold text-card-foreground mb-4 font-space-grotesk">{{ title }}</h3>

            <p class="text-muted-foreground mb-6 leading-relaxed">{{ description }}</p>

            <div class="space-y-2 mb-8">
                <div v-for="benefit in benefits" :key="benefit"
                    class="flex items-center justify-center gap-2 text-sm text-mono-400">
                    <div class="w-1.5 h-1.5 bg-forest-50 rounded-full" />
                    {{ benefit }}
                </div>
            </div>

            <Link href="#registerView"
                class="flex justify-center w-full rounded p-2 bg-forest-300 group-hover:bg-wine-400 hover:cursor-pointer group-hover:text-mono-100 transition-colors duration-300">
                <span class="text-center text-white">{{ buttonText }}</span>
                <BaseIcon class="ml-2 text-white group-hover:translate-x-1 transition-transform duration-300" :path="mdiArrowRight"/>
            </Link>
        </div>
    </div>
</template>

<script setup>
import BaseIcon from '@/Components/BaseIcon.vue';
import { mdiArrowRight } from '@mdi/js';
import { Link } from "@inertiajs/vue3";

defineProps({
    title: String,
    description: String,
    icon: String,
    buttonText: String,
    color: String,
    benefits: Array,
})
</script>

<style scoped>
.gradient-card {
    background: linear-gradient(145deg, #ffffff 0%, #f8fafc 100%);
}
</style>