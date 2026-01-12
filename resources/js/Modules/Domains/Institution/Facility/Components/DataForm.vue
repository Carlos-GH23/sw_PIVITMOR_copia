<template>
    <div class="flex gap-2 items-center py-4">
        <BaseIcon class="bg-forest-400 text-mono-100 rounded-lg" :path="mdiInformation" size="24" h="h-10" w="w-10" />
        <div class="space-y-">
            <p class="text-xl font-bold">
                Información general
            </p>
            <p class=" text-sm font-light text-slate-800 dark:text-slate-300">
                Proporciona los datos básicos de la instalación especializada
            </p>
        </div>
    </div>

    <BaseDivider />

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 items-start">
        <div class="space-y-6 m-auto w-full">
            <FormField label="Nombre de la instalación:" required :error="form.errors.name">
                <FormControl v-model="form.name" placeholder="Nombre de la instalación" maxLength="250" />
            </FormField>
        </div>
        <div class="space-y-6 m-auto w-full">
            <FormField label="Tipo de instalación:" required :error="form.errors.facility_type_id">
                <FormControl v-model="form.facility_type_id" :options="facilityTypes"
                    placeholder="Seleccione el tipo de instalación" />
            </FormField>
        </div>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-1 gap-6 items-start mt-4">
        <div class="md:col-span-2">
            <FormField label="Descripción" :error="form.errors.description">
                <FormControl v-model="form.description" type="textarea" height="h-32" placeholder="Descripción..."
                    maxLength="2000" :counter="{ max: 1000, current: form.description?.length || 0 }" />
                <template #tooltip>
                        <p>Proporcione una descripción detallada de la instalación.</p>
                    </template>
            </FormField>
        </div>
    </div>

    <BaseDivider />
    <div class="grid grid-cols-1 md:grid-cols-1 gap-6 items-start">

        <div class="grid grid-cols-1">
            <div class="flex items-center gap-2">
                <BaseIcon class="bg-forest-400 text-mono-100 rounded-lg" :path="mdiImageArea" size="24" h="h-10"
                    w="w-10" />
                <h3 class="text-md font-medium">Imagenes relacionadas</h3>
            </div>
            <ImageUploadCarousel :form="form" />
            <InputError :message="form.errors.photos" />
        </div>
    </div>

    <FileUpload :form="form" title="Archivos relacionados" description="Puedes subir archivos en formato PDF o DOCX."
        icon-classes="bg-forest-400 text-mono-100 rounded-lg" />
    <InputError :message="form.errors.files" />

    <FormField label="Departamento académico" required :error="form.errors.department_id">
        <FormControl v-model="form.department_id" :options="departments" placeholder="Seleccione departamento" />
    </FormField>

    <div class="flex gap-2 items-center py-4">
        <BaseIcon class="bg-forest-400 text-mono-100 rounded-lg" :path="mdiCubeOutline" size="24" h="h-10" w="w-10" />
        <div class="space-y-">
            <p class="text-md font-medium">
                Infraestructura tecnológica relacionada
            </p>
            <p class=" text-sm font-light text-slate-800 dark:text-slate-300">
                Puedes visualizar la infraestructura tecnológica relacionada a esta instalación especializada
            </p>
        </div>
    </div>
    <table class="mt-2">
        <thead class="uppercase bg-gray-300 text-gray-600 border-b border-gray-200">
            <tr>
                <th>Nombre del equipamiento</th>
                <th>Descripción</th>
            </tr>
        </thead>
        <tbody v-if="form.equipments.length > 0" class="border border-gray-200 divide-y divide-gray-300">
            <tr v-for="equipment in form.equipments" :key="equipment.id">
                <td data-label="Nombre">
                    {{ equipment.name }}
                </td>
                <td data-label="Descripción">
                    {{ equipment.description }}
                </td>
            </tr>
        </tbody>
        <tbody v-else class="border border-gray-200">
            <tr>
                <td colspan="2" class="text-center p-4 text-gray-500">
                    No hay equipamiento relacionado.
                </td>
            </tr>
        </tbody>
    </table>
</template>

<script setup>
import FormField from '@/Components/FormField.vue';
import FormControl from '@/Components/FormControl.vue';
import BaseIcon from '@/Components/BaseIcon.vue';
import { mdiInformation, mdiImageArea, mdiCubeOutline } from '@mdi/js';
import InputError from '@/Components/InputError.vue';
import 'swiper/css';
import 'swiper/css/effect-coverflow';
import 'swiper/css/navigation';
import 'swiper/css/pagination';
import { inject } from 'vue';
import BaseDivider from '@/Components/BaseDivider.vue';
import ImageUploadCarousel from '@/Components/ImageUploadCarousel.vue';
import FileUpload from '@/Components/FileUpload.vue';


const { facilityTypes, departments } = defineProps({
    facilityTypes: {
        type: Array,
        required: true,
    },
    departments: {
        type: Array,
        required: true,
    },
    facility: {
        type: Object,
        default: null,
    },
    equipment: {
        type: Object,
        default: () => ([]),
        required: false,
    },
});

const form = inject('form');

</script>
