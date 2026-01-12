<template>
    <CardForm>
        <template #header>
            <div class="flex gap-2 items-center py-4">
                <BaseIcon class="bg-forest-400 text-mono-100 rounded-lg" :path="mdiOfficeBuilding" size="24" h="h-10"
                    w="w-10" />
                <div>
                    <p class="text-forest-400 text-xl font-bold">
                        Datos generales de la Organización
                    </p>
                    <p class="text-sm font-light text-slate-800 dark:text-slate-300">
                        Proporciona los datos generales
                    </p>
                </div>
            </div>
        </template>

        <div class="md:flex md:space-x-6 items-start">
            <div class="md:w-1/3 max-md:mb-5">
                <ImageUpload @delete="deletePhoto" title="Logo" v-model="form.logo.file" :error="form.errors.logo"
                    :existingImage="form.logo.path" editMode />
            </div>
            <div class="md:w-2/3 space-y-4">
                <FormField label="Nombre Oficial" required :error="form.errors.name">
                    <FormControl type="text" placeholder="Nombre" v-model="form.name" />
                </FormField>

                <FormField label="RFC" required :error="form.errors.rfc">
                    <FormControl type="text" placeholder="RFC" maxlength="100" v-model="form.rfc" />
                </FormField>

                <FormField label="Figura jurídica" required :error="form.errors.legal_entity_type_id">
                    <FormControl type="select" :options="props.legalEntityTypes" v-model="form.legal_entity_type_id" />
                </FormField>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <FormField label="CLUNI" :error="form.errors.cluni">
                <FormControl type="text" placeholder="Clave Única de Inscripción al Registro Federal de OSC"
                    v-model="form.cluni" />
            </FormField>

            <FormField label="Representante Legal" required :error="form.errors.legal_representative">
                <FormControl placeholder="Nombre del representante" v-model="form.legal_representative" />
            </FormField>

            <FormField label="Ámbito de actuación" required :error="form.errors.market_reach_id">
                <FormControl type="select" :options="props.marketReaches" v-model="form.market_reach_id" />
            </FormField>

            <FormField label="Sector" required :error="form.errors.economic_sector_id">
                <FormControl type="select" :options="props.economicSectors" v-model="form.economic_sector_id" />
            </FormField>
        </div>

        <FormField label="Objetivo Social/Misión" :error="form.errors.mission">
            <FormControl type="textarea" max-length="2000" height="h-42" v-model="form.mission" />
        </FormField>

        <FormField label="Proyectos Principales" :error="form.errors.main_projects">
            <FormControl type="textarea" max-length="2000" height="h-42" v-model="form.main_projects" />
        </FormField>

        <FormField label="Reseña de la ONG" :error="form.errors.description">
            <FormControl type="textarea" max-length="2000" height="h-42" v-model="form.description" />
        </FormField>

        <FormField label="Palabras clave" required :error="form.errors.keywords">
            <KeywordInput v-model="form.keywords" />
        </FormField>
    </CardForm>
</template>

<script setup>
import CardForm from '@/Components/CardForm.vue';
import BaseIcon from '@/Components/BaseIcon.vue';
import FormField from "@/Components/FormField.vue";
import FormControl from "@/Components/FormControl.vue";
import ImageUpload from "@/Components/ImageUpload.vue";
import KeywordInput from "@/Components/KeywordInput.vue";
import { mdiOfficeBuilding } from '@mdi/js';
import { inject } from 'vue';

const form = inject('form');
const props = inject('props');

const deletePhoto = () => {
    form.logo.delete_photo = true;
};
</script>
