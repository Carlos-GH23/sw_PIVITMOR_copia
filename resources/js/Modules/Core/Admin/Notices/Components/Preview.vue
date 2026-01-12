<template >
    <div class="group transition-all duration-300 border border-border/50">
        <div class="aspect-video overflow-hidden rounded-t-lg">
            <img loading="lazy" :src="getImage" class="w-full h-full object-cover transition-transform duration-300"
                alt="Vista previa de la imagen" />
        </div>

        <div class="p-4 bg-white">
            <div class="flex justify-between">
                <span class="text-forest-400">{{ formattedDate }}</span>
                <div class="flex items-center text-mono-400">
                    <BaseIcon :path="mdiClockOutline" />
                        {{ readingTime }} min. lectura
                </div>
            </div>
            <div class="mb-6">
                <h3 class="my-6 text-forest-400 text-xl md:line-clamp-2 lg:text-2xl"> {{ form.title ?? 'Sin titulo'}} </h3>
                <p class="h-24 text-md text-mono-200 line-clamp-6">{{ form.subtitle ?? 'Subtitulo/entradilla' }} </p>
            </div>
        </div>
    </div>
</template>

<script setup>
import BaseIcon from '@/Components/BaseIcon.vue';
import { mdiClockOutline } from '@mdi/js';
import { inject, computed } from 'vue';
import { useModal } from '../Composables/useModal.js';

const form = inject('form');

const { readingTime, formattedDate } = useModal(form.notice_body, form.creation_date);

const getImage = computed(() => {
    if (form.photo.file instanceof File) {
        return URL.createObjectURL(form.photo.file);
    }
    return form.photo ? form.photo.path : null;
});

</script>