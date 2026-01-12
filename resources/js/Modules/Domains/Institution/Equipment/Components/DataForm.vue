<template>
    <div class="flex gap-2 items-center py-4">
        <BaseIcon class="bg-forest-400 text-mono-100 rounded-lg" :path="mdiInformation" size="24" h="h-10" w="w-10" />
        <div class="space-y-">
            <p class="text-xl font-bold">
                Información general
            </p>
            <p class=" text-sm font-light text-slate-800 dark:text-slate-300">
                Proporciona los datos básicos del equipamiento de la instalación.
            </p>
        </div>
    </div>

    <BaseDivider />

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 items-start">
        <div class="space-y-6 m-auto w-full">
            <FormField label="Nombre del equipamiento:" required :error="form.errors.name">
                <FormControl v-model="form.name" placeholder="Nombre del equipamiento" maxLength="250" />
            </FormField>
        </div>
        <div class="space-y-6 m-auto w-full">
            <FormField label="Tipo de equipamiento:" required :error="form.errors.equipment_type_id">
                <FormControl v-model="form.equipment_type_id" :options="equipmentTypes"
                    placeholder="Seleccione el tipo de equipamiento" />
            </FormField>
        </div>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-1 gap-6 items-start">
        <div class="md:col-span-2 mt-2">
            <FormField label="Descripción" :error="form.errors.description">
                <FormControl v-model="form.description" type="textarea" height="h-32" placeholder="Descripción..."
                    :counter="{ current: form.description?.length || 0 }" maxLength="2000" />
                    <template #tooltip>
                        <p>Proporcione una descripción detallada de la instalación.</p>
                    </template>
            </FormField>
        </div>
    </div>


    <FormField label="Academico responsable" required :error="form.errors.responsible_id">
        <FormControl v-model="form.responsible_id" :options="academics"
            placeholder="Seleccione el académico responsable" />
    </FormField>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 items-start">
        <FormField label="Departamento " required :error="form.errors.department_id">
            <FormControl v-model="form.department_id" :options="departments"
                placeholder="Seleccione la instalación asociada" />
        </FormField>

        <FormField label="Instalación " required :error="form.errors.facility_id">
            <FormControl v-model="form.facility_id" :options="facilities"
                placeholder="Seleccione la instalación asociada" />
        </FormField>
    </div>

    <BaseDivider />
    <div class="grid grid-cols-1 md:grid-cols-1 gap-6 items-start">

        <div class="grid grid-cols-1">
            <div class="flex items-center gap-2">
                <BaseIcon class="bg-forest-400 text-mono-100 rounded-lg" color="info" :path="mdiImageArea" size="24"
                    h="h-10" w="w-10" />
                <div class="space-y-">
                    <p class="text-xl font-bold">
                        Imagenes relacionadas
                    </p>
                    <p class=" text-sm font-light text-slate-800 dark:text-slate-300">
                        Agrega imágenes relacionadas con el equipamiento de la instalación.
                    </p>
                </div>
            </div>
            <ImageUploadCarousel :form="form" />
            <InputError :message="form.errors.photos" />
        </div>
    </div>

    <FileUpload :form="form" title="Archivos relacionados" description="Puedes subir archivos en formato PDF o DOCX."
        icon-classes="bg-forest-400 text-mono-100 rounded-lg" />
    <InputError :message="form.errors.files" />
</template>

<script setup>
import FormField from '@/Components/FormField.vue';
import FormControl from '@/Components/FormControl.vue';
import BaseIcon from '@/Components/BaseIcon.vue';
import { mdiInformation, mdiImageArea } from '@mdi/js';
import InputError from '@/Components/InputError.vue';
import 'swiper/css';
import 'swiper/css/effect-coverflow';
import 'swiper/css/navigation';
import 'swiper/css/pagination';
import { inject, ref, watch } from 'vue';
import BaseDivider from '@/Components/BaseDivider.vue';
import ImageUploadCarousel from '@/Components/ImageUploadCarousel.vue';
import FileUpload from '@/Components/FileUpload.vue';
import axios from 'axios';

const { equipmentTypes, academics } = defineProps({
    equipmentTypes: {
        type: Array,
        required: true,
    },
    academics: {
        type: Array,
        default: null,
    },
    departments: {
        type: Array,
        default: null,
    }
});

const form = inject('form');

const facilities = ref([]);

watch(() => form.department_id, (newDepartmentId, oldDepartmentId) => {
    if (oldDepartmentId !== undefined) {
        form.facility_id = null;
    }

    if (!newDepartmentId) {
        facilities.value = [];
        return;
    }

    axios.get(`/api/facilities-by-department/${newDepartmentId}`)
        .then(response => {
            facilities.value = response.data;
        });

}, {
    immediate: true 
});
</script>
