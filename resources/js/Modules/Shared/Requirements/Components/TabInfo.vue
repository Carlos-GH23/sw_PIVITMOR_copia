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
                        Proporciona los datos básicos de la necesidad tecnológica
                    </p>
                </div>
            </div>
        </template>
        <FormField label="Título" required :error="form.errors.title">
            <FormControl v-model="form.title" type="textarea" height="h-24" max-length="400"
                placeholder="Ejemplo: Sistema inteligente de monitoreo ambiental para invernaderos" />

            <template #tooltip>
                <p class="mb-2 text-sm font-semibold">Recomendaciones:</p>
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
                        Prioriza verbos de acción y términos comprensibles: “Sistema para…”, “Método de…”, “Herramienta de…”
                    </li>
                </ul>
            </template>
        </FormField>

        <FormField label="Descripción técnica" required :error="form.errors.technical_description">
            <ContentQuillEditor v-model="form.technical_description"
                placeholder="Describa en qué consiste la tecnología, cómo funciona y sus características principales. Ejemplo: Software basado en inteligencia artificial que analiza imágenes médicas en tiempo real para apoyar diagnósticos tempranos de cáncer, reduciendo tiempos y errores clínicos."
                maxLength="2000" />
        </FormField>

        <div class="md:grid grid-cols-2 gap-4">
            <FormField label="Palabras clave" :error="form.errors.keywords">
                <KeywordInput v-model="form.keywords" />
            </FormField>
            <FormField v-if="useRoles(['Academico', 'IES/CI'])" label="Departamento">
                <LabelControl :value="department.name" disabled />
            </FormField>
        </div>

        <CardSection title="Periodo de publicación" description="Periodo de publicación de la necesidad tecnológica"
            iconClasses="bg-forest-400 text-mono-100" :icon="mdiCalendarBlankOutline">
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
            description="Agrega imágenes relacionadas con la necesidad tecnológica"
            iconClasses="bg-forest-400 text-mono-100" :icon="mdiImageOutline">
            <FormField label="Máximo 5 imágenes por publicación" :error="form.errors.photos">
                <ImageUploadCarousel :form="form" />
            </FormField>
        </CardSection>
    </CardForm>
</template>
<script setup>
import BaseIcon from "@/Components/BaseIcon.vue";
import CardForm from "@/Components/CardForm.vue";
import CardSection from "@/Components/CardSection.vue";
import ContentQuillEditor from "@/Components/ContentQuillEditor.vue";
import FormControl from "@/Components/FormControl.vue";
import FormField from "@/Components/FormField.vue";
import ImageUploadCarousel from "@/Components/ImageUploadCarousel.vue";
import KeywordInput from "@/Components/KeywordInput.vue";
import LabelControl from "@/Components/LabelControl.vue";
import { useRoles } from "@/Hooks/usePermissions";
import { mdiCalendarBlankOutline, mdiImageOutline, mdiInformation } from "@mdi/js";
import { inject } from "vue";

const form = inject('requirementForm')
const { department } = inject('props')
</script>