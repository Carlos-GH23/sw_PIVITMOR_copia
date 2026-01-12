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
                        Infraestructura tecnológica, recursos tecnológicos, recursos humanos, imágenes y archivos
                        asociados
                    </p>
                </div>
            </div>
        </template>

        <CardSection title="Infraestructura tecnológica"
            description="Infraestructura tecnológica relacionada con el servicio tecnológico" :hasDivider="false">
            <FacilityRecords :facilities="service.facilities" />
        </CardSection>

        <CardSection title="Recursos tecnológicos"
            description="Recursos tecnológicos relacionados con el servicio tecnológico">
            <EquipmentRecords :equipments="service.equipments" />
        </CardSection>

        <CardSection title="Recursos humanos" description="Recursos humanos relacionados con el servicio tecnológico">
            <AcademicRecords :academics="service?.academics" />
        </CardSection>

        <CardSection title="Imágenes relacionadas" description="Imágenes relacionadas con el servicio tecnológico">
            <ImageSwiper :photos="service?.photos" :slides="2" showEmpty />
        </CardSection>

        <CardSection title="Archivos relacionados" description="Archivos relacionados con el servicio tecnológico">
            <FilesTable :files="service?.files" />
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
import { computed, inject } from 'vue';
import AcademicRecords from '../Academics/AcademicRecords.vue';
import EquipmentRecords from '../Institution/Equipment/EquipmentRecords.vue';
import FacilityRecords from '../Institution/Facilities/FacilityRecords.vue';

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

const injectData = inject('service', null);

const service = computed(() => {
    return props.data || injectData || {};
});

</script>