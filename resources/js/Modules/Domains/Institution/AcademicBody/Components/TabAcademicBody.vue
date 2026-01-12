<template>
    <CardForm>
        <template #header>
            <div class="flex gap-2 items-center py-4">
                <BaseIcon class="bg-forest-400 text-mono-100 rounded-lg" :path="mdiInformation" size="24" h="h-10"
                    w="w-10" />
                <div>
                    <p class="text-forest-400 text-xl font-bold">
                        Cuerpo Académico
                    </p>
                    <p class=" text-sm font-light text-slate-800 dark:text-slate-300">
                        Proporciona la información del cuerpo académico
                    </p>
                </div>
            </div>
        </template>

        <div class="space-y-6">
            <FormField label="Nombre" required :error="form.errors.name">
                <FormControl v-model="form.name" type="text" placeholder="Ingresa el nombre del cuerpo académico" />
            </FormField>

            <div class="grid grid-cols-1 md:grid-cols-2 md:gap-6">
                <FormField label="Grado de Consolidación" required :error="form.errors.consolidation_degree_id">
                    <FormControl value-key="id" label-key="name" v-model="form.consolidation_degree_id"
                        :options="consolidationDegrees" />
                </FormField>
                <FormField label="Clave" required :error="form.errors.key">
                    <FormControl v-model="form.key" type="text" placeholder="Ingresa la clave del cuerpo académico" />
                </FormField>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 md:gap-6">
                <FormField label="Sectores económicos y productivos (ISIC)" required
                    :error="form.errors.economic_sectors">
                    <HierarchicalSelector v-model="form.economic_sectors" :items="economicSectors"
                        placeholder="Buscar sectores económicos y productivos (ISIC)..."
                        :level-labels="['Sección', 'División', 'Grupo']" />
                </FormField>
                <FormField label="Disciplinas cientificas y tecnológicas (OCDE)" required
                    :error="form.errors.oecd_sectors">
                    <HierarchicalSelector v-model="form.oecd_sectors" :items="oecdSectors"
                        placeholder="Buscar disciplinas cientificas y tecnológicas (OCDE)..."
                        :level-labels="['Área Principal', 'Subárea', 'Disciplina']" />
                </FormField>
            </div>

            <FormField label="Reseña" required :error="form.errors.review">
                <ContentQuillEditor v-model="form.review" maxLength="2000" placeholder="Ingresa una reseña" />
            </FormField>

            <FormField label="LGAC Asociadas" required :error="form.errors.knowledge_lines">
                <KeywordInput v-model="form.knowledge_lines" />
                <template #tooltip>
                    Agrege las Líneas de Generación y Aplicación del Conocimiento (LGAC) asociadas a la institución.
                </template>
            </FormField>
        </div>

        <CardSection title="Miembros asociados al Cuerpo Académico" description="Departamento y profesores asociados"
            iconClasses="bg-forest-400 text-mono-100" :icon="mdiDomain">
            <div class="grid grid-cols-2 gap-4">
                <FormField label="Departamento" required :error="form.errors.department_id">
                    <FormControl value-key="id" label-key="name" v-model="form.department_id" :options="departments" />
                </FormField>
                <FormField label="Profesores" required :error="form.errors.academics">
                    <MultiSelect value-key="id" label-key="full_name" v-model="form.academics" :options="academics" />
                </FormField>
            </div>
        </CardSection>

        <CardSection title="Líneas de investigación asociadas" description="Líneas de investigación asociadas"
            iconClasses="bg-forest-400 text-mono-100" :icon="mdiLayersSearch">
            <FormField label="Líneas de investigación" :error="form.errors.research_lines">
                <MultiSelect value-key="id" label-key="name" v-model="form.research_lines" :options="researchLines" />
            </FormField>
        </CardSection>

        <FileUpload title="Archivos relacionados" :form="form" />
    </CardForm>
</template>

<script setup>
import { inject } from "vue";
import BaseIcon from "@/Components/BaseIcon.vue";
import CardForm from "@/Components/CardForm.vue";
import FileUpload from '@/Components/FileUpload.vue';
import FormControl from "@/Components/FormControl.vue";
import KeywordInput from "@/Components/KeywordInput.vue";
import { mdiInformation } from "@mdi/js";
import ContentQuillEditor from '@/Components/ContentQuillEditor.vue';
import FormField from "@/Components/FormField.vue";
import MultiSelect from '@/Components/Form/MultiSelect/MultiSelect.vue';
import HierarchicalSelector from '@/Components/Form/HierarchicalSelector/HierarchicalSelector.vue';
import { mdiDomain, mdiLayersSearch } from "@mdi/js";
import CardSection from "@/Components/CardSection.vue";

const form = inject("form");
const departments = inject("departments");
const consolidationDegrees = inject("consolidationDegrees");
const academics = inject("academics");
const researchLines = inject("researchLines");
const economicSectors = inject("economicSectors");
const oecdSectors = inject("oecdSectors");

</script>