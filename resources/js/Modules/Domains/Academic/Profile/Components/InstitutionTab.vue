<template>
    <CardForm>
        <template #header>
            <div class="flex gap-2 items-center py-4">
                <BaseIcon class="bg-forest-400 text-mono-100 rounded-lg" :path="mdiDomain" size="24" h="h-10"
                    w="w-10" />
                <div>
                    <h3 class="text-forest-400 text-xl font-bold">
                        Información institucional
                    </h3>
                    <span class="text-sm font-light text-slate-800">
                        Detalles de la institución a la que pertenece
                    </span>
                </div>
            </div>
        </template>

        <div class="grid md:grid-cols-2 gap-4">
            <FormField label="Institución/Centro/Universidad">
                <FormControl :model-value="academic.data.department?.institution?.name" type="text" disabled />
            </FormField>

            <FormField label="Departamento/División/Jefatura/Gerencia/Unidad/Centro">
                <FormControl v-model="form.department_id" type="select" :options="departments" disabled />
            </FormField>
        </div>

        <CardSection title="Grupos académicos" description="Lineas de investigación y cuerpo académico"
            :icon="mdiAccountGroup">
            <div class="grid md:grid-cols-2 gap-4">
                <FormField label="Línea de investigación">
                    <div class="space-y-2">
                        <div v-for="line in academic.data.research_lines" :key="line.id"
                            class="border rounded-md p-2 flex justify-between items-center">
                            <span class="text-sm font-medium">{{ line.name }}</span>
                        </div>
                        <div v-if="!academic.data.research_lines?.length" class="text-sm text-gray-500">
                            No hay líneas de investigación asociadas.
                        </div>
                    </div>
                </FormField>

                <FormField label="Cuerpo académico">
                    <div class="space-y-2">
                        <div v-for="body in academic.data.academic_bodies" :key="body.id"
                            class="border rounded-md p-2 flex justify-between items-center">
                            <span class="text-sm font-medium">{{ body.name }}</span>
                            <span class="text-xs text-gray-500">{{ body.consolidation_degree.level }}</span>
                        </div>
                        <div v-if="!academic.data.academic_bodies?.length" class="text-sm text-gray-500">
                            No hay cuerpos académicos asociados.
                        </div>
                    </div>
                </FormField>
            </div>
        </CardSection>

        <BaseDivider />

        <FormField required label="Líneas de generación y aplicación de conocimiento (LGACs)"
            :error="form.errors.knowledge_lines">
            <KeywordInput class="w-1/2" v-model="form.knowledge_lines" />
        </FormField>
    </CardForm>
</template>

<script setup>
import { inject } from 'vue';
import BaseIcon from '@/Components/BaseIcon.vue';
import CardForm from '@/Components/CardForm.vue';
import CardSection from '@/Components/CardSection.vue';
import FormControl from '@/Components/FormControl.vue';
import FormField from '@/Components/FormField.vue';
import KeywordInput from "@/Components/KeywordInput.vue";
import { mdiAccountGroup, mdiDomain } from '@mdi/js';
import BaseDivider from '@/Components/BaseDivider.vue';

const form = inject('form');
const academic = inject('academic');
const departments = inject('departments');
</script>