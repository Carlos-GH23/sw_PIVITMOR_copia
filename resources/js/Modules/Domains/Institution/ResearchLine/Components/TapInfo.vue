<template>
    <CardForm>
        <template #header>
            <div class="flex gap-2 items-center py-4">
                <BaseIcon class="bg-forest-400 text-mono-100 rounded-lg" :path="mdiInformation" size="24" h="h-10"
                    w="w-10" />
                <div>
                    <p class="text-forest-400 text-xl font-bold">
                        Línea de investigación
                    </p>
                    <p class=" text-sm font-light text-slate-800 dark:text-slate-300">
                        Proporciona la información de la línea de investigación
                    </p>
                </div>
            </div>
        </template>

        <div class="space-y-6">
            <FormField>
                <ImageUpload @delete="deletePhoto" title="Logo" v-model="form.logo.file" :error="form.errors.logo"
                    :existingImage="form.logo.path" editMode />
            </FormField>
            <FormField label="Nombre" required :error="form.errors.name">
                <FormControl v-model="form.name" type="text" placeholder="Ingresa el nombre de la línea" />
            </FormField>
            <FormField label="Reseña" required :error="form.errors.description">
                <ContentQuillEditor v-model="form.description" maxLength="2000" placeholder="Ingresa una reseña" />
            </FormField>

            <div class="grid grid-cols-1 md:grid-cols-2 md:gap-6">
                <FormField label="Sectores económicos y productivos (ISIC)" required
                    :error="form.errors.economic_sectors">
                    <HierarchicalSelector v-model="form.economic_sectors" :items="economicSectors"
                        placeholder="Buscar sectores económicos y productivos (ISIC)..."
                        :level-labels="['Sección', 'División', 'Grupo']" />
                    <template #tooltip>
                        El capital humano relacionado con la oferta tecnológica, puede relacionar al creador autor
                        intelectual de dicha tecnología.
                    </template>
                </FormField>
                <FormField label="Disciplinas cientificas y tecnológicas (OCDE)" required
                    :error="form.errors.oecd_sectors">
                    <HierarchicalSelector v-model="form.oecd_sectors" :items="oecdSectors"
                        placeholder="Buscar disciplinas cientificas y tecnológicas (OCDE)..."
                        :level-labels="['Área Principal', 'Subárea', 'Disciplina']" />
                </FormField>
            </div>

            <CardSection title="Miembros asociados a la linea de investigación"
                description="Departamento y profesores integrantes" iconClasses="bg-forest-400 text-mono-100"
                :icon="mdiDomain">
                <FormField label="Departamento" required :error="form.errors.department_id">
                    <FormControl value-key="id" label-key="name" v-model="form.department_id" :options="departments" />
                </FormField>

                <FormField label="Profesores" required :error="form.errors.academics">
                    <MultiSelect value-key="id" label-key="full_name" v-model="form.academics" :options="academics" />
                </FormField>
            </CardSection>

            <CardSection title="Tópicos de investigación" description="Agrega los tópicos de investigación"
                iconClasses="bg-forest-400 text-mono-100" :icon="mdiLayersSearch">
                <FormField label="Tópicos de Investigación" required :error="form.errors.keywords">
                    <KeywordInput v-model="form.keywords" />
                </FormField>
            </CardSection>
        </div>

        <FileUpload title="Archivos relacionados" :form="form" />
    </CardForm>
</template>

<script setup>
import { inject } from 'vue';
import CardForm from "@/Components/CardForm.vue";
import FormField from "@/Components/FormField.vue";
import FormControl from "@/Components/FormControl.vue";
import BaseIcon from "@/Components/BaseIcon.vue";
import ImageUpload from '@/Components/ImageUpload.vue';
import { mdiInformation } from "@mdi/js";
import MultiSelect from '@/Components/Form/MultiSelect/MultiSelect.vue';
import KeywordInput from '@/Components/KeywordInput.vue';
import HierarchicalSelector from '@/Components/Form/HierarchicalSelector/HierarchicalSelector.vue';
import FileUpload from '@/Components/FileUpload.vue';
import ContentQuillEditor from '@/Components/ContentQuillEditor.vue';
import { mdiDomain, mdiLayersSearch } from "@mdi/js";
import CardSection from "@/Components/CardSection.vue";

const form = inject('form');
const economicSectors = inject('economicSectors');
const oecdSectors = inject('oecdSectors');
const departments = inject('departments');
const academics = inject('academics');

const deletePhoto = () => {
    form.logo.delete_photo = true;
};
</script>
