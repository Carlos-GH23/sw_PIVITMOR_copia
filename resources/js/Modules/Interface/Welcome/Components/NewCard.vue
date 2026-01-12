<template>
    <div class="group hover:shadow-lg transition-all duration-300 border border-border/50">
        <div class="aspect-video overflow-hidden rounded-t-lg">
            <img loading="lazy" :src="photo?.path" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"
                alt="image" />
        </div>

        <div class="p-4 bg-white rounded-b-lg h-[350px]">
            <div class="flex justify-between">
                <span class="text-forest-400">{{ formatted_date?.human }}</span>
                <div class="flex items-center text-mono-400">
                    <BaseIcon :path="mdiClockOutline" />
                    {{ readingTime }} min. lectura
                </div>
            </div>
            <div class="mb-6">
                <h3 class="my-6 text-forest-400 text-xl md:line-clamp-2 lg:text-2xl h-16"> {{ title }} </h3>
                <p class="text-md text-mono-200 line-clamp-6 h-34"> {{ abstract }} </p>
            </div>

            <button @click="$emit('readMore')"
                class="group/button transition-colors cursor-pointer text-earth-200 hover:text-earth-300">
                Leer más
                <div class="bg-wine-50 h-[3px] w-0 group-hover/button:w-full transition-all duration-300"></div>
            </button>
        </div>
    </div>
</template>

<script setup>
import BaseIcon from '@/Components/BaseIcon.vue';
import { mdiClockOutline } from '@mdi/js';
import { useNew } from '../Composables/useNew';
const props = defineProps({
    id: Number,
    title: String,
    abstract: String,
    formatted_date: Object,
    photo: Object,
    notice_body: String,
});
const { readingTime } = useNew(props.notice_body);
</script>