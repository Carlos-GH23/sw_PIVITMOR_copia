<template>
    <CardForm>
        <template #header>
            <div class="flex gap-2 items-center py-4">
                <BaseIcon class="bg-forest-400 text-mono-100 rounded-lg" :path="mdiSchoolOutline" size="24" h="h-10"
                    w="w-10" />
                <div>
                    <h3 class="text-forest-400 text-xl font-bold">
                        Formación académica
                    </h3>
                    <h3 class=" text-sm font-light text-slate-800">
                        Detalles sobre su grado académico y documentos relacionados
                    </h3>
                </div>
            </div>
        </template>


        <div class="grid mb-6 md:mb-0 md:grid-cols-2 md:gap-4">
            <FormField label="Título del grado" required :error="form.errors.academic_title">
                <FormControl placeholder="Ej: Doctor en Ciencias de la Computación" v-model="form.academic_title" />
            </FormField>

            <FormField label="Institución que lo otorga" required :error="form.errors.institution_name">
                <FormControl placeholder="Ej: Universidad Nacional Autónoma de México" v-model="form.institution_name" :icon="mdiDomain" />
            </FormField>
        </div>

        <div class="grid mb-6 md:mb-0 md:grid-cols-3 md:gap-4">
            <FormField label="Grado académico" required :error="form.errors.academic_degree_id">
                <FormControl type="select" placeholder="Seleccione un grado académico" v-model="form.academic_degree_id"
                    :options="academicDegrees" :icon="mdiSchoolOutline" />
            </FormField>

            <FormField label="Área de conocimiento" required :error="form.errors.knowledge_area_id">
                <FormControl type="select" placeholder="Seleccione una área de conocimiento"
                    v-model="form.knowledge_area_id" :options="knowledgeAreas" />
            </FormField>

            <FormField label="País" required :error="form.errors.country_id">
                <FormControl type="select" placeholder="Seleccione un país" v-model="form.country_id" :options="countries" :icon="mdiFlag" />
            </FormField>
        </div>

        <div class="grid mb-6 md:mb-0 md:grid-cols-2 md:gap-4">
            <FormField label="Número de cédula" required :error="form.errors.certificate_number">
                <FormControl placeholder="Ej: 1234567890" v-model="form.certificate_number" :icon="mdiNumeric" />
            </FormField>

            <FormField label="Fecha de obtención de grado" required :error="form.errors.degree_obtained_at">
                <FormControl :icon="mdiCalendar" type="date" v-model="form.degree_obtained_at" />
            </FormField>
        </div>

        <FileUpload title="Documentos comprobatorios"
            description="Adjunte los documentos que respalden su formación académica" :form="form" />
    </CardForm>

    <CardBox class="mt-5">
        <div class="flex justify-end items-center md:space-y-0 space-y-2">
            <BaseButtons>
                <slot />
            </BaseButtons>
        </div>
    </CardBox>
</template>

<script setup>
import BaseButtons from '@/Components/BaseButtons.vue';
import BaseIcon from '@/Components/BaseIcon.vue';
import CardBox from '@/Components/CardBox.vue';
import CardForm from '@/Components/CardForm.vue';
import FileUpload from '@/Components/FileUpload.vue';
import FormControl from '@/Components/FormControl.vue';
import FormField from '@/Components/FormField.vue';
import { mdiCalendar, mdiDomain, mdiFlag, mdiNumeric, mdiSchoolOutline } from '@mdi/js';

const props = defineProps({
    form: { type: Object, required: true },
    errors: { type: Object, default: () => ({}) },
    academicDegrees: { type: Array, default: () => [] },
    knowledgeAreas: { type: Array, default: () => [] },
    countries: { type: Array, default: () => [] },
});

</script>