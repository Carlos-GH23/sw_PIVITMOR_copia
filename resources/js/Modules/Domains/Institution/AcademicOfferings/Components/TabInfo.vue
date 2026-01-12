<template>
    <CardForm>
        <template #header>
            <div class="flex gap-2 items-center py-4">
                <BaseIcon class="bg-forest-400 text-mono-100 rounded-lg" :path="mdiInformation" size="24" h="h-10"
                    w="w-10" />
                <div>
                    <p class="text-forest-400 text-xl font-bold">
                        Informacion general
                    </p>
                    <p class="text-sm font-light text-slate-800 dark:text-slate-300">
                        Proporciona los datos básicos de la oferta educativa.
                    </p>
                </div>
            </div>
        </template>
        <div class="grid grid-cols-1 gap-4 items-center">
            <FormField label="Nombre del Programa" required :error="form.errors.name">
                <FormControl v-model="form.name" type="input" height="h-10"
                    placeholder="Ingresa el nombre del programa" />
            </FormField>

            <FormField label="Reseña del programa" required :error="form.errors.description">
                <div class="w-full">
                    <ContentQuillEditor v-model="form.description" theme="snow" maxLength="2000"
                        placeholder="Ingresa una descripción" />
                </div>
            </FormField>
            <FormField label="Objetivo" required :error="form.errors.objective">
                <div class="w-full">
                    <ContentQuillEditor v-model="form.objective" theme="snow" maxLength="2000"
                        placeholder="Ingresa una descripción" />
                </div>
            </FormField>
            <FormField label="Perfil de egreso" required :error="form.errors.graduate_profile">
                <div class="w-full">
                    <ContentQuillEditor v-model="form.graduate_profile" maxLength="2000" theme="snow"
                        placeholder="Ingresa una descripción" />
                </div>
            </FormField>
            <FormField label="Palabras clave" required :error="form.errors.keywords">
                <KeywordInput v-model="form.keywords" />
            </FormField>
            <FormField label="Departamento académico:" required :error="form.errors.department_id">
                <FormControl v-model="form.department_id" type="select" :options="departments"
                    placeholder="Seleccionar Departamento Académico" />
            </FormField>
            <div class="grid grid-cols-1 md:grid-cols-2 md:gap-4">
                <FormField label="Nivel" required :error="form.errors?.educational_level_id">
                    <FormControl v-model="form.educational_level_id" type="select" :options="educationalLevels"
                        placeholder="Selecciona un nivel" />
                </FormField>
                <FormField label="Modalidad" required :error="form.errors?.study_mode_id">
                    <FormControl v-model="form.study_mode_id" type="select" :options="studyModes"
                        placeholder="Selecciona una modalidad" />
                </FormField>
            </div>

            <FormField label="Página Web" :error="form.errors?.website">
                <FormControl v-model="form.website" type="input" height="h-10" placeholder="Ingresa la pagina web" />
            </FormField>

            <div class="grid grid-cols-1 md:grid-cols-2 md:gap-4">
                <FormField label="Costo del semestre" :error="form.errors?.semester_cost">
                    <FormControl v-model="form.semester_cost" type="number" height="h-10"
                        placeholder="Ingresa el costo del semestre" />
                </FormField>
                <FormField label="Duración en meses" :error="form.errors?.duration_months">
                    <FormControl v-model="form.duration_months" type="number" height="h-10" />
                </FormField>
            </div>

            <FormField label="REVOE" required :error="form.errors?.revoe">
                <FormControl v-model="form.revoe" type="input" height="h-10" placeholder="Ingresa la informacion" />
            </FormField>
        </div>
    </CardForm>
</template>

<script setup>
import BaseIcon from "@/Components/BaseIcon.vue";
import CardForm from "@/Components/CardForm.vue";
import FormControl from "@/Components/FormControl.vue";
import FormField from "@/Components/FormField.vue";
import KeywordInput from "@/Components/KeywordInput.vue";
import { mdiInformation } from "@mdi/js";
import '@vueup/vue-quill/dist/vue-quill.snow.css';
import ContentQuillEditor from "@/Components/ContentQuillEditor.vue";
import { inject } from 'vue';

const form = inject('form')
const educationalLevels = inject('educationalLevels')
const studyModes = inject('studyModes')
const departments = inject('departments')
const activeOptions = [
    { id: true, name: 'Habilitado' },
    { id: false, name: 'Deshabilitado' }
];
</script>
