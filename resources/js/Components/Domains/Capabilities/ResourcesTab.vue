<template>
    <CardForm>
        <template #header>
            <div class="flex gap-2 items-center py-4">
                <BaseIcon class="bg-forest-400 text-mono-100 rounded-lg" :path="mdiCrowd" size="24" h="h-10" w="w-10" />

                <div>
                    <p class="text-forest-400 text-xl font-bold">
                        Recursos asociados
                    </p>
                    <p class="text-sm font-light text-slate-800 dark:text-slate-300">
                        Académicos, imágenes y archivos asociados
                    </p>
                </div>
            </div>
        </template>

        <CardSection title="Académico(s) titulares" description="Académico relacionados con la capacidad tecnológica"
            :hasDivider="false">
            <AcademicRecords :academics="capability?.academics" />
        </CardSection>

        <CardSection title="Imágenes relacionadas" description="Imágenes relacionadas con la capacidad tecnológica">
            <ImageSwiper :photos="capability?.photos" showEmpty :slides="2" />
        </CardSection>

        <CardSection title="Archivos relacionados" description="Archivos relacionados con la capacidad tecnológica">
            <FilesTable :files="capability?.files" />
        </CardSection>
    </CardForm>
</template>

<script setup>
import AcademicRecords from '../Academics/AcademicRecords.vue';
import BaseIcon from '@/Components/BaseIcon.vue';
import CardForm from '@/Components/CardForm.vue';
import CardSection from '@/Components/CardSection.vue';
import FilesTable from '@/Components/FilesTable.vue';
import ImageSwiper from '@/Components/ImageSwiper.vue';
import { mdiCrowd } from '@mdi/js';
import { computed, inject, unref } from 'vue';

const props = defineProps({
    data: {
        type: Object,
        required: false,
    },
});

const injectData = inject('capability', null);

const capability = computed(() => {
    return props.data || unref(injectData) || {};
});
</script>