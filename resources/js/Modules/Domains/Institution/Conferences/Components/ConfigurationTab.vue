<template>
    <CardForm>
        <template #header>
            <div class="flex gap-2 items-center py-4">
                <BaseIcon class="bg-forest-400 text-mono-100 rounded-lg" :path="mdiCog" size="24" h="h-10" w="w-10" />
                <div>
                    <p class="text-forest-400 text-xl font-bold">
                        Programación
                    </p>
                    <p class="text-sm font-light text-slate-800 dark:text-slate-300">
                        Fechas, horarios y responsables
                    </p>
                </div>
            </div>
        </template>

        <div class="space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 md:gap-6">
                <FormField label="Fecha de inicio" required :error="form.errors.start_date">
                    <FormControl v-model="form.start_date" type="date" />
                </FormField>
                <FormField label="Fecha fin" required :error="form.errors.end_date">
                    <FormControl v-model="form.end_date" type="date" />
                </FormField>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 md:gap-6">
                <FormField label="Departamento" required :error="form.errors.department_id">
                    <FormControl value-key="id" label-key="name" v-model="form.department_id" :options="departments" />
                </FormField>
                <FormField label="Idioma" required :error="form.errors.language_id">
                    <FormControl v-model="form.language_id" :options="languages" placeholder="Seleccione un idioma" />
                </FormField>
            </div>

            <FormField label="Ponentes" required :error="form.errors.academics">
                <MultiSelect value-key="id" label-key="name" v-model="form.academics" :options="academics" />
            </FormField>
        </div>
    </CardForm>
</template>
<script setup>
import { inject } from 'vue';
import CardForm from "@/Components/CardForm.vue";
import FormField from "@/Components/FormField.vue";
import FormControl from "@/Components/FormControl.vue";
import BaseIcon from "@/Components/BaseIcon.vue";
import { mdiCog } from "@mdi/js";
import MultiSelect from '@/Components/Form/MultiSelect/MultiSelect.vue';
const form = inject('conferenceForm');

const departments = inject('departments');
const academics = inject('academics', []);
const languages = inject('languages');

</script>