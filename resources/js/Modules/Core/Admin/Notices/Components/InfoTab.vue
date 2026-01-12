<template>
    <CardForm>
        <template #header>
            <div class="flex gap-2 items-center py-4">
                <BaseIcon class="bg-forest-400 text-mono-100 rounded-lg" :path="mdiInformation" size="24" h="h-10"
                    w="w-10" />
                <div class="space-y-">
                    <p class="text-xl font-bold">
                        Información general
                    </p>
                    <p class=" text-sm font-light text-slate-800 dark:text-slate-300">
                        Proporciona los datos básicos de la noticia
                    </p>
                </div>
            </div>
        </template>

        <div class="grid md:grid-cols-1 gap-4 mb-4">
            <FormField label="Título" required :error="form.errors.title">
                <FormControl v-model="form.title" maxLength="150"
                    placeholder="Ejemplo: Lleva Gobierno de Morelos ciencia a las comunidades con miniferia Cienciaventura: experiencia de verano, en Zacualpan de Amilpas." />
                <template #tooltip>
                    <p>Proporcione un título claro y descriptivo para la noticia.</p>
                </template>
            </FormField>
        </div>

        <div class="grid md:grid-cols-2 gap-4 mb-4">
            <FormField label="Subtitulo/Entradilla" :error="form.errors.subtitle">
                <FormControl v-model="form.subtitle" maxLength="150"
                    placeholder="Opcional, breve resumen de 1-2 frases" />
                <template #tooltip>
                    <p>Proporcione un subtítulo o entradilla que resuma la noticia.</p>
                </template>
            </FormField>

            <FormField label="Categoría" required :error="form.errors.news_category_id">
                <FormControl v-model="form.news_category_id" maxLength="150" :options="categories" />
            </FormField>
        </div>

        <BaseDivider />
        <FormField label="Palabras clave" required :error="form.errors.keywords">
            <KeywordInput v-model="form.keywords" :limit="5" :error="form.errors.keywords" />
        </FormField>
    </CardForm>
</template>

<script setup>
import BaseIcon from '@/Components/BaseIcon.vue';
import BaseDivider from '@/Components/BaseDivider.vue';
import CardForm from '@/Components/CardForm.vue';
import FormField from '@/Components/FormField.vue';
import FormControl from '@/Components/FormControl.vue';
import KeywordInput from '@/Components/KeywordInput.vue';
import { mdiInformation } from '@mdi/js';
import { inject } from 'vue';

const form = inject('form');
const categories = inject('categories');

</script>