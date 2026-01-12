<template>
    <CardForm>
        <template #header>
            <div class="flex gap-2 items-center py-4">
                <BaseIcon class="bg-forest-400 text-mono-100 rounded-lg" :path="mdiInformation" size="24" h="h-10" w="w-10" />
                <div>
                    <p class="text-forest-400 text-xl font-bold">
                        Información de la conferencia
                    </p>
                    <p class="text-sm font-light text-slate-800 dark:text-slate-300">
                        Detalles generales y palabras clave
                    </p>
                </div>
            </div>
        </template>

        <div class="space-y-6">
            <FormField label="Título" required :error="form.errors.title">
                <FormControl v-model="form.title" type="text" maxLength="255"
                    placeholder="Ingresa el título de la conferencia" />
            </FormField>
            <FormField label="Descripción" :error="form.errors.description">
                <FormControl v-model="form.description" type="textarea" height="h-48" maxLength="2000"
                    placeholder="Describa el objetivo, los temas principales y el valor que aporta la conferencia.\nEjemplo: Conferencia sobre innovación educativa en la era digital, abordando estrategias para integrar tecnología en el aula, fomentar el aprendizaje activo y preparar a los estudiantes para los retos del siglo XXI." />
            </FormField>
            <FormField label="Reseña del ponente" :error="form.errors.speaker_bio">
                <FormControl v-model="form.speaker_bio" type="textarea" height="h-48" maxLength="2000"
                    placeholder="Incluya una breve reseña del ponente, destacando su experiencia y logros relevantes.\nEjemplo: Dr. Juan Pérez, especialista en neurociencia con más de 15 años de experiencia en investigación y docencia, autor de múltiples publicaciones internacionales y conferencista invitado en eventos científicos de alto nivel." class="w-full min-w-[400px]" />
            </FormField>
            <FormField label="Palabras Clave" required :error="form.errors.keywords">
                <KeywordInput v-model="form.keywords" />
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
import { mdiInformation, mdiFileOutline, mdiPlus } from "@mdi/js";
import { QuillEditor } from '@vueup/vue-quill';
import KeywordInput from '@/Components/KeywordInput.vue';
import { useFile } from '@/Hooks/useFile';
const form = inject('conferenceForm');
const { totalFiles, fileCountText, handleFileInput, removeFile } = useFile();
</script>