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
                        Asignación de académicos y carga de archivos
                    </p>
                </div>
            </div>
        </template>

        <div>
            <FormField label="Académico(s) titular(es)" :error="form.errors.academics">
                <MultiSelect v-model="form.academics" :options="academics" valueKey="id" labelKey="full_name" />

                <template #tooltip>
                    <p class="max-w-60">
                        El capital humano
                        relacionado con la
                        oferta tecnológica,
                        puede relacionar al
                        creador autor
                        intelectual de dicha
                        tecnología.
                    </p>
                </template>
            </FormField>
        </div>

        <FileUpload title="Archivos relacionados" :form="form" />

    </CardForm>
</template>

<script setup>
import BaseIcon from '@/Components/BaseIcon.vue';
import CardForm from '@/Components/CardForm.vue';
import FileUpload from '@/Components/FileUpload.vue';
import FormField from '@/Components/FormField.vue';
import MultiSelect from '@/Components/Form/MultiSelect/MultiSelect.vue';
import { mdiCrowd } from '@mdi/js';
import { inject } from 'vue';

const form = inject('form');
const academics = inject('academics');
</script>