<template>
    <CardForm>
        <template #header>
            <div class="flex gap-2 items-center py-4">
                <BaseIcon class="bg-forest-400 text-mono-100 rounded-lg" :path="mdiOfficeBuilding" size="24" h="h-10"
                    w="w-10" />
                <div>
                    <p class="text-forest-400 text-xl font-bold">
                        Datos generales de la Dependencia
                    </p>
                    <p class=" text-sm font-light text-slate-800 dark:text-slate-300">
                        Proporciona los datos generales de la dependencia de gobierno.
                    </p>
                </div>
            </div>
        </template>
        <div class="md:flex md:space-x-6 items-start">
            <div class="md:w-1/3 max-md:mb-5">
                <FormField>
                    <ImageUpload @delete="deletePhoto" title="Logo" v-model="form.logo.file" :error="form.errors.logo"
                        :existingImage="form.logo.path" :editMode="true" />
                </FormField>
            </div>
            <div class="md:w-2/3 space-y-4">
                <FormField label="Nombre Oficial" required :error="form.errors.name">
                    <FormControl type="text" placeholder="Nombre" v-model="form.name" maxLength="100" />
                </FormField>
                <FormField label="Siglas" required :error="form.errors.acronym">
                    <FormControl type="text" placeholder="Siglas de la dependencia" maxlength="100"
                        v-model="form.acronym" required maxLength="20" />
                </FormField>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <FormField label="Nivel de gobierno" required :error="form.errors.government_level_id">
                        <FormControl type="select" :options="props.levels" v-model="form.government_level_id" />
                    </FormField>
                    <FormField label="Sector" required :error="form.errors.government_sector_id">
                        <FormControl type="select" :options="props.governmentSectors" v-model="form.government_sector_id" />
                    </FormField>
                </div>
            </div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <FormField label="Misión Institucional" required class="md:col-span-2" :error="form.errors.mission">
                <ContentQuillEditor theme="snow" maxLength="2000" placeholder="Ingresa una descripción"
                    v-model="form.mission" />
            </FormField>
            <FormField label="Visión Institucional" required class="md:col-span-2" :error="form.errors.vision">
                <ContentQuillEditor theme="snow" maxLength="2000" placeholder="Ingresa una descripción"
                    v-model="form.vision" />
            </FormField>
            <FormField label="Objetivos Estratégicos" required class="md:col-span-2" :error="form.errors.objectives">
                <ContentQuillEditor theme="snow" maxLength="2000" placeholder="Ingresa una descripción"
                    v-model="form.objectives" />
            </FormField>
            <FormField label="Palabras clave" required class="md:col-span-2" :error="form.errors.keywords">
                <KeywordInput v-model="form.keywords" :limit="5" />
            </FormField>
        </div>
    </CardForm>
</template>

<script setup>
import CardForm from '@/Components/CardForm.vue';
import BaseIcon from '@/Components/BaseIcon.vue';
import ImageUpload from "@/Components/ImageUpload.vue";
import FormField from "@/Components/FormField.vue";
import FormControl from "@/Components/FormControl.vue";
import ContentQuillEditor from "@/Components/ContentQuillEditor.vue";
import KeywordInput from "@/Components/KeywordInput.vue";
import { mdiOfficeBuilding } from '@mdi/js';
import { ref, inject } from 'vue';

const props = inject('props');
const form = inject('form');

const deletePhoto = () => {
    form.logo.delete_photo = true;
};
</script>
