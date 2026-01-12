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
                        Asignación de personal y carga de archivos
                    </p>
                </div>
            </div>
        </template>

        <div v-if="useRoles(['IES/CI', 'Academico'])">
            <div class="grid md:grid-cols-2 gap-4 mb-4">
                <FormField label="Departamento académico" :error="form.errors.department_id">
                    <FormControl v-model="form.department_id" placeholder="Selecciona un departamento"
                        :options="departments" />
                </FormField>

                <FormField label="Recursos humanos">
                    <SelectNames v-model="form.academics" :items="props.academics"
                        placeholder="Selecciona recursos humanos" />
                </FormField>

                <FormField label="Instalación especializada">
                    <SelectNames v-model="form.facilities" :items="facilities" placeholder="Selecciona instalación especializada" />
                </FormField>
                
                <FormField label="Infraestructura tecnológica">
                    <SelectNames v-model="form.equipments" :items="equipments"
                        placeholder="Selecciona infraestructura tecnológica" />
                </FormField>
            </div>
        </div>

        <div v-else class="text-center py-24 text-gray-500 dark:text-slate-400 mb-4">
            <p>Esta sección solo está disponible para instituciones académicas y centros de investigación.</p>
        </div>

        <FileUpload title="Archivos relacionados" :form="form" />

    </CardForm>
</template>

<script setup>
import BaseIcon from '@/Components/BaseIcon.vue';
import CardForm from '@/Components/CardForm.vue';
import FileUpload from '@/Components/FileUpload.vue';
import { mdiCrowd } from '@mdi/js';
import { inject } from 'vue';
import FormField from '@/Components/FormField.vue';
import FormControl from '@/Components/FormControl.vue';
import SelectNames from './SelectList.vue';
import { useRoles } from '@/Hooks/usePermissions';

const props = defineProps({
    academics: { type: Array, required: true },
});

const form = inject('form');
const departments = inject('departments');
const academics = inject('academics');
const facilities = inject('facilities');
const equipments = inject('equipments');



</script>