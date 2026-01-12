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

        <FormField label="Problema que resuelve" required :error="form.errors.need_statement">
            <ContentQuillEditor v-model="form.need_statement"
                placeholder="Explique la necesidad o reto que atiende esta tecnología. Ejemplo: En la agricultura intensiva, los agricultores enfrentan pérdidas por plagas no detectadas a tiempo; esta herramienta permite detectar y clasificar plagas con un 95% de precisión mediante imágenes capturadas por drones."
                maxLength="2000" />

            <template #tooltip>
                <p class="mb-2 text-sm font-semibold">Recomendaciones:</p>
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

        <FormField label="Aplicaciones potenciales" required :error="form.errors.potential_applications">
            <ContentQuillEditor v-model="form.potential_applications"
                placeholder="Mencione áreas, sectores o industrias donde puede aplicarse. Ejemplo: Industria automotriz (control de calidad manufactura avanzada (automatización de procesos), salud (análisis de imágenes médicas)."
                maxLength="2000" />
        </FormField>

        <div class="grid grid-cols-1 md:grid-cols-2 md:gap-4">
            <FormField label="Propiedad Intelectual" :error="form.errors.intellectual_property_id">
                <FormControl v-model="form.intellectual_property_id" :options="intellectuals"
                    placeholder="Seleccione el tipo registro de Propiedad intelectual" />

                <template #tooltip>
                    Descripción del campo de información, se puede generar un texto con ayuda del Asistente Virtual
                    PIVITMor
                </template>
            </FormField>
            <FormField label="Nivel de madurez tecnológica" :error="form.errors.technology_level_id">
                <FormControl v-model="form.technology_level_id" :options="technologies"
                    placeholder="Seleccione el nivel de madurez tecnológica" />
            </FormField>
        </div>
    </CardForm>
</template>
<script setup>
import BaseIcon from "@/Components/BaseIcon.vue";
import CardForm from "@/Components/CardForm.vue";
import ContentQuillEditor from "@/Components/ContentQuillEditor.vue";
import FormControl from "@/Components/FormControl.vue";
import FormField from "@/Components/FormField.vue";
import { mdiHandHeart } from "@mdi/js";
import { inject } from "vue";

const form = inject('requirementForm');
const { intellectuals, technologies } = inject('props');
</script>