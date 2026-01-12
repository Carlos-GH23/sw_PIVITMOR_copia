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
                        Carga de archivos
                    </p>
                </div>
            </div>
        </template>
        <CardSection title="Imágenes relacionadas" description="Imágenes relacionadas con el servicio tecnológico"
            :hasDivider="false">
            <ImageSwiper :photos="technologyService?.photos" :slides="2" showEmpty />
        </CardSection>

        <CardSection title="Archivos relacionados" description="Archivos relacionados con el servicio tecnológico">
            <FilesTable :files="technologyService?.files" />
        </CardSection>
    </CardForm>
</template>

<script setup>
import BaseIcon from '@/Components/BaseIcon.vue';
import CardForm from '@/Components/CardForm.vue';
import CardSection from '@/Components/CardSection.vue';
import FilesTable from '@/Components/FilesTable.vue';
import ImageSwiper from '@/Components/ImageSwiper.vue';
import { mdiCrowd } from '@mdi/js';
import { inject } from 'vue';

const technologyService = inject('technologyService');
</script>
