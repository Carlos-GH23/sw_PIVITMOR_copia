<template>
    <CardForm>
        <template #header>
            <div class="flex gap-2 items-center py-4">
                <BaseIcon class="bg-forest-400 text-mono-100 rounded-lg" :path="mdiTools" size="24" h="h-10" w="w-10" />
                <div>
                    <p class="text-forest-400 text-xl font-bold">
                        Recursos técnicos
                    </p>
                    <p class="text-sm font-light text-slate-800 dark:text-slate-300">
                        Recursos técnicos y archivos relacionados
                    </p>
                </div>
            </div>
        </template>

        <div class="space-y-6">
            <FormField label="Requerimientos técnicos" :error="form.errors.technical_requirements">
                <FormControl v-model="form.technical_requirements" type="textarea" height="h-32" maxLength="2000" placeholder="Ingresa los requerimientos técnicos necesarios para la conferencia" />
            </FormField>
            <BaseDivider />
            <FileUpload title="Archivos relacionados" :form="form" />
        </div>
    </CardForm>
</template>
<script setup>
import { inject } from 'vue';
import CardForm from "@/Components/CardForm.vue";
import FormField from "@/Components/FormField.vue";
import FormControl from "@/Components/FormControl.vue";
import BaseIcon from "@/Components/BaseIcon.vue";
import { mdiTools, mdiFileOutline, mdiPlus } from "@mdi/js";
import { useFile } from '@/Hooks/useFile';
import FileUpload from '@/Components/FileUpload.vue';
import BaseDivider from '@/Components/BaseDivider.vue';

const form = inject('conferenceForm');
const { totalFiles, fileCountText, handleFileInput, removeFile } = useFile();
</script>