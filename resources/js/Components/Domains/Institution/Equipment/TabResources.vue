<template>
    <CardForm>
        <template #header>
            <div class="flex gap-2 items-center py-4">
                <BaseIcon class="bg-forest-400 text-mono-100 rounded-lg" :path="mdiImageMultiple" size="24" h="h-10"
                    w="w-10" />
                <div>
                    <p class="text-forest-400 text-xl font-bold">
                        Recursos
                    </p>
                    <p class="text-sm font-light text-slate-800 dark:text-slate-300">
                        Imágenes y archivos relacionados con el equipamiento
                    </p>
                </div>
            </div>
        </template>

        <CardSection title="Imágenes relacionadas"
            description="Imágenes relacionadas con el equipamiento de la instalación" :hasDivider="false">
            <ImageSwiper :photos="equipment?.photos" :slides="2" showEmpty />
        </CardSection>

        <CardSection title="Archivos relacionados"
            description="Archivos relacionados con el equipamiento de la instalación">
            <FilesTable :files="equipment?.files" />
        </CardSection>
    </CardForm>
</template>

<script setup>
import BaseIcon from '@/Components/BaseIcon.vue';
import CardForm from '@/Components/CardForm.vue';
import CardSection from '@/Components/CardSection.vue';
import FilesTable from '@/Components/FilesTable.vue';
import ImageSwiper from '@/Components/ImageSwiper.vue';
import { mdiImageMultiple } from '@mdi/js';
import { computed, inject } from 'vue';

const props = defineProps({
    hasBorder: {
        type: Boolean,
        default: false,
    },
    data: {
        type: Object,
        required: false,
    },
});

const injectData = inject('equipment', null);

const equipment = computed(() => {
    return props.data || injectData || {};
});
</script>
