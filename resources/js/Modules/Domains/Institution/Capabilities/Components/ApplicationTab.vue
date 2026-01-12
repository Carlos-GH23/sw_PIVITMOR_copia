<template>
    <CardForm>
        <template #header>
            <div class="flex gap-2 items-center py-4">
                <BaseIcon class="bg-forest-400 text-mono-100 rounded-lg" :path="mdiHandHeart" size="24" h="h-10"
                    w="w-10" />
                <div>
                    <p class="text-forest-400 text-xl font-bold">
                        Valor y Aplicaciones
                    </p>
                    <p class=" text-sm font-light text-slate-800 dark:text-slate-300">
                        Beneficios y casos de uso
                    </p>
                </div>
            </div>
        </template>

        <FormField label="Problema que resuelve o necesidad que atiende" required :error="form.errors.problem_statement"
            help="Explique la necesidad o reto que atiende esta tecnología.">
            <ContentQuillEditor v-model="form.problem_statement" maxLength="2000"
                placeholder="Ejemplo: En la agricultura intensiva, los agricultores enfrentan pérdidas por plagas no detectadas a tiempo; esta herramienta permite detectar y clasificar plagas con un 95% de precisión mediante imágenes capturadas por drones." />

            <template #tooltip>
                <span class="mb-2 text-sm font-semibold">Recomendaciones:</span>
                <ul class="max-w-md space-y-1 list-disc list-inside">
                    <li>
                        Presente el contexto del problema (sector, actores afectados).
                    </li>
                    <li>
                        Responda a: “¿qué pasa si este problema no se resuelve?”.
                    </li>
                    <li>
                        Use datos breves o indicadores cuando sea posible (ej. porcentajes, costos evitados).
                    </li>
                    <li>
                        Mantenga un lenguaje claro, accesible y orientado al beneficio social, económico o ambiental.
                    </li>
                </ul>
            </template>
        </FormField>

        <FormField label="Aplicaciones potenciales" required :error="form.errors.potential_applications"
            help="Áreas, sectores o industrias donde puede aplicarse.">
            <ContentQuillEditor v-model="form.potential_applications" maxLength="2000"
                placeholder="Ejemplo: Industria automotriz (control de calidad), manufactura avanzada (automatización de procesos), salud (análisis de imágenes médicas)." />
        </FormField>

        <div class="grid grid-cols-1 md:grid-cols-2 md:gap-4">
            <FormField label="Propiedad Intelectual" :error="form.errors.intellectual_property_id">
                <FormControl v-model="form.intellectual_property_id" :options="intellectualProperties" />
            </FormField>
            <FormField label="Nivel de madurez tecnológica" :error="form.errors.technology_level_id">
                <FormControl v-model="form.technology_level_id" :options="techLevels" />
            </FormField>
        </div>
    </CardForm>
</template>

<script setup>
import BaseIcon from '@/Components/BaseIcon.vue';
import CardForm from '@/Components/CardForm.vue';
import FormControl from '@/Components/FormControl.vue';
import FormField from '@/Components/FormField.vue';
import { mdiHandHeart } from '@mdi/js';
import { inject } from 'vue';
import ContentQuillEditor from '@/Components/ContentQuillEditor.vue';

const form = inject('form');
const intellectualProperties = inject('intellectualProperties');
const techLevels = inject('techLevels');
</script>