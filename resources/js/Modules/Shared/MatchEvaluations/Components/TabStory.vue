<template>
    <CardForm>
        <template #header>
            <div class="flex gap-2 items-center py-4">
                <BaseIcon class="bg-forest-400 text-mono-100 rounded-lg" :path="mdiBookOpen" size="24" h="h-10"
                    w="w-10" />
                <div>
                    <p class="text-forest-400 text-xl font-bold">
                        Historía completa
                    </p>
                    <p class=" text-sm font-light text-slate-800 dark:text-slate-300">
                        Describe la historia completa del proyecto, incluyendo el contexto, el problema, el desarrollo,
                        la implementación y los resultados.
                    </p>
                </div>
            </div>
        </template>

        <FormField label="Historia completa" required :error="form.errors.story">
            <ContentQuillEditor v-model="form.story"
                placeholder="Redacta la narrativa del proyecto: contexto, problema detectado, desarrollo, implementación y resultados finales."
                maxLength="2000" />
        </FormField>

        <FormField label="Resultados cuantificables" required :error="form.errors.results">
            <ContentQuillEditor v-model="form.results"
                placeholder="Incluye indicadores medibles de impacto: número de beneficiarios, reducción de costos, publicaciones, patentes o TRL alcanzado."
                maxLength="2000" />
        </FormField>

        <FormField label="Objetivos alcanzados" required :error="form.errors.goals">
            <ContentQuillEditor v-model="form.goals"
                placeholder="Enumera los principales logros del proyecto. Ejemplo: reducir consumo de agua en 25%, incrementar rendimiento de cultivos y transferir tecnología a productores."
                maxLength="2000" />
        </FormField>

        <FormField label="Lecciones aprendidas" required :error="form.errors.lessons">
            <ContentQuillEditor v-model="form.lessons"
                placeholder="Describe los factores clave de éxito, desafíos enfrentados y recomendaciones para replicar la experiencia."
                maxLength="2000" />
        </FormField>
    </CardForm>
</template>
<script setup>
import BaseIcon from "@/Components/BaseIcon.vue";
import CardForm from "@/Components/CardForm.vue";
import ContentQuillEditor from "@/Components/ContentQuillEditor.vue";
import FormField from "@/Components/FormField.vue";
import { mdiBookOpen } from "@mdi/js";
import { inject } from "vue";

const form = inject('matchEvaluationForm')
</script>