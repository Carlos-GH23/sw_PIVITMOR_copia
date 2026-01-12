<template>
    <CardForm>
        <template #header>
            <div class="flex gap-2 items-center py-4">
                <BaseIcon class="bg-forest-400 text-mono-100 rounded-lg" :path="mdiInformation" size="24" h="h-10"
                    w="w-10" />
                <div>
                    <p class="text-forest-400 text-xl font-bold">
                        Información general
                    </p>
                    <p class=" text-sm font-light text-slate-800 dark:text-slate-300">
                        Proporciona los datos básicos de la capacidad tecnológica
                    </p>
                </div>
            </div>
        </template>

        <div>
            <FormField label="Título" required :error="form.errors.title">
                <FormControl v-model="form.title" type="textarea" height="h-24" maxlength="400"
                    placeholder="Ejemplo: Sistema inteligente de monitoreo ambiental para invernaderos." />

                <template #tooltip>
                    <span class="mb-2 text-sm font-semibold">Recomendaciones:</span>
                    <ul class="max-w-md space-y-1 list-disc list-inside">
                        <li>
                            Usa un título breve, concreto y atractivo (máx. 400 caracteres).
                        </li>
                        <li>
                            Evita frases genéricas como “nueva tecnología innovadora”.
                        </li>
                        <li>
                            Incluye el ámbito de aplicación o el componente principal.
                        </li>
                        <li>
                            Prioriza verbos de acción y términos comprensibles: “Sistema para…”, “Método de…”,
                            “Herramienta de…”
                        </li>
                    </ul>
                </template>
            </FormField>

            <FormField label="Descripción técnica" required :error="form.errors.technical_description">
                <ContentQuillEditor v-model="form.technical_description" maxLength="2000"
                    placeholder="Ejemplo: Software basado en inteligencia artificial que analiza imágenes médicas en tiempo real para apoyar diagnósticos tempranos de cáncer, reduciendo tiempos y errores clínicos." />
            </FormField>

            <div class="grid grid-cols-2 gap-4">
                <FormField label="Palabras clave" :error="form.errors.keywords">
                    <KeywordInput v-model="form.keywords" />
                </FormField>

                <FormField label="Departamento" :error="form.errors.department_id">
                    <LabelControl disabled :value="department.name" />
                </FormField>
            </div>
        </div>

        <CardSection title="Periodo de publicación" description="Periodo de publicación de la capacidad tecnológica"
            :icon="mdiCalendarBlankOutline">
            <div class="grid grid-cols-2 gap-4">
                <FormField label="Fecha de inicio" :error="form.errors.start_date">
                    <FormControl v-model="form.start_date" type="date" />
                </FormField>

                <FormField label="Fecha de cierre" :error="form.errors.end_date">
                    <FormControl v-model="form.end_date" type="date" />
                </FormField>
            </div>
        </CardSection>

        <CardSection title="Imágenes relacionadas"
            description="Agrega imágenes relacionadas con la capacidad tecnológica" :icon="mdiImageOutline">
            <FormField help="Máximo 5 imágenes por publicación" :error="form.errors.photos">
                <ImageUploadCarousel :form="form" />
            </FormField>
        </CardSection>
    </CardForm>
</template>

<script setup>
import BaseIcon from '@/Components/BaseIcon.vue';
import CardForm from '@/Components/CardForm.vue';
import CardSection from '@/Components/CardSection.vue';
import FormField from '@/Components/FormField.vue';
import FormControl from '@/Components/FormControl.vue';
import KeywordInput from '@/Components/KeywordInput.vue';
import { mdiCalendarBlankOutline, mdiImageOutline, mdiInformation } from '@mdi/js';
import { inject } from 'vue';
import ContentQuillEditor from '@/Components/ContentQuillEditor.vue';
import ImageUploadCarousel from '@/Components/ImageUploadCarousel.vue';
import LabelControl from '@/Components/LabelControl.vue';

const form = inject('form');
const department = inject('department');
</script>