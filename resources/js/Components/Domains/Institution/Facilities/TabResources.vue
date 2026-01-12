<template>
    <CardForm>
        <template #header>
            <div class="flex gap-2 items-center py-4">
                <BaseIcon class="bg-forest-400 text-mono-100 rounded-lg" :path="mdiCubeOutline" size="24" h="h-10"
                    w="w-10" />
                <div>
                    <p class="text-forest-400 text-xl font-bold">
                        Recursos e infraestructura
                    </p>
                    <p class="text-sm font-light text-slate-800 dark:text-slate-300">
                        Equipamiento, certificaciones, imágenes y archivos relacionados
                    </p>
                </div>
            </div>
        </template>

        <CardSection title="Equipamiento tecnológico"
            description="Infraestructura tecnológica relacionada con esta instalación" :hasDivider="false">
            <EquipmentRecords :equipments="facility?.equipments" />
        </CardSection>

        <CardSection title="Certificaciones" description="Certificaciones relacionadas con esta instalación">
            <CertificationRecords :certifications="facility?.certifications" />
        </CardSection>

        <CardSection title="Imágenes relacionadas" description="Imágenes relacionadas con la instalación especializada">
            <ImageSwiper :photos="facility?.photos" :slides="2" showEmpty />
        </CardSection>

        <CardSection title="Archivos relacionados" description="Archivos relacionados con la instalación especializada">
            <FilesTable :files="facility?.files" />
        </CardSection>
    </CardForm>
</template>

<script setup>
import BaseIcon from '@/Components/BaseIcon.vue';
import CardForm from '@/Components/CardForm.vue';
import CardSection from '@/Components/CardSection.vue';
import FilesTable from '@/Components/FilesTable.vue';
import ImageSwiper from '@/Components/ImageSwiper.vue';
import { mdiCubeOutline } from '@mdi/js';
import { computed, inject } from 'vue';
import EquipmentRecords from '../Equipment/EquipmentRecords.vue';
import CertificationRecords from '../Certifications/CertificationRecords.vue';

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

const injectData = inject('facility', null);

const facility = computed(() => {
    return props.data || injectData || {};
});
</script>
