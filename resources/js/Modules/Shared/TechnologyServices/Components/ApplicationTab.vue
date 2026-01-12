<template>
    <CardForm>
        <template #header>
            <div class="flex gap-2 items-center py-4">
                <BaseIcon :path="mdiHandHeart" size="20" h="h-auto" w="w-auto" />
                <div class="space-y-">
                    <p class="text-xl font-bold">
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
            <QuillEditor theme="snow" v-model:content="form.problem_statement" content-type="html"
                placeholder="Ejemplo: En la agricultura intensiva, los agricultores enfrentan pérdidas por plagas no detectadas a tiempo; esta herramienta permite detectar y clasificar plagas con un 95% de precisión mediante imágenes capturadas por drones."
                style="height: 230px;" />
        </FormField>

        <FormField label="Aplicaciones potenciales" :error="form.errors.potential_applications"
            help="Áreas, sectores o industrias donde puede aplicarse.">
            <QuillEditor theme="snow" v-model:content="form.potential_applications" content-type="html"
                placeholder="Ejemplo: Industria automotriz (control de calidad), manufactura avanzada (automatización de procesos), salud (análisis de imágenes médicas)."
                style="height: 230px;" />
        </FormField>

        <div class="grid grid-cols-1 md:grid-cols-2 md:gap-4">
            <FormField label="Propiedad Intelectual" :error="form.errors.intellectual_property_id">
                <FormControl v-model="form.intellectual_property_id" :options="[]" />
            </FormField>
            <FormField label="Nivel de madurez tecnológica" :error="form.errors.technology_level_id">
                <FormControl v-model="form.technology_level_id" :options="[]" />
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
import { QuillEditor } from '@vueup/vue-quill';
import { inject } from 'vue';

const form = inject('form');
</script>