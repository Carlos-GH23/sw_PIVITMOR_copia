<template>
    <CardForm>
        <template #header>
            <div class="flex gap-2 items-center py-4">
                <BaseIcon class="bg-forest-400 text-mono-100 rounded-lg" :path="mdiChartDonut" size="24" h="h-10"
                    w="w-10"/>
                <div class="space-y-">
                    <p class="text-xl font-bold">
                        Metadatos de la noticia
                    </p>
                    <p class=" text-sm font-light text-slate-800 dark:text-slate-300">
                        Proporciona los metadatos de la noticia que deseas publicar.
                    </p>
                </div>
            </div>
        </template>

        <div class="grid md:grid-cols-2 gap-4 mb-4">
            <FormField label="Autor de la noticia" required :error="form.errors.author">
                <FormControl v-model="form.author" maxLength="150"
                    placeholder="Nombre del academico/admin que publico" />
                    <template #tooltip>
                        <p>Proporcione el nombre completo del autor de la noticia.</p>
                </template>
            </FormField>

            <FormField label="Estado de la noticia" required :error="form.errors.notice_status_id">
                <FormControl v-model="form.notice_status_id" :options="statuses" />
            </FormField>

            <FormField label="Fecha de creación" :error="form.errors.creation_date">
                <FormControl v-model="form.creation_date" type="date" disabled />
            </FormField>

            <FormField label="Fecha de publicación programada" :error="form.errors.publication_date">
                <FormControl v-model="form.publication_date" type="date" />
            </FormField>
        </div>

        <BaseDivider />

        <div class="flex justify-between">
            <div class="flex items-center gap-2">
                <BaseIcon class="bg-forest-400 text-mono-100 rounded-lg" :path="mdiBullhornVariant" size="24" h="h-10"
                    w="w-10" />
                    <div class="space-y-">
                        <p class="text-xl font-bold">
                                Difusión
                            </p>
                        <p class=" text-sm font-light text-slate-800 dark:text-slate-300">
                                Selecciona las opciones de difusión para la noticia.
                            </p>
                    </div>
            </div>
        </div>

        <div class="grid md:grid-cols-1 gap-4 mb-4">

            <FormField label="Compartir categorias de correo" :error="form.errors.email_notification">
                <FormControl v-model="form.email_notification" :options="emailOptions" />
            </FormField>
        </div>
    </CardForm>
</template>

<script setup>
import BaseIcon from '@/Components/BaseIcon.vue';
import CardForm from '@/Components/CardForm.vue';
import FormField from '@/Components/FormField.vue';
import FormControl from '@/Components/FormControl.vue';
import BaseDivider from '@/Components/BaseDivider.vue';
import { mdiChartDonut, mdiBullhornVariant } from '@mdi/js';
import { inject } from 'vue';

const form = inject('form');


const statuses = inject('statuses');

const comments = [
    { id: 1, name: 'Habilitados' },
    { id: 2, name: 'Deshabilitados' },
];

const emailOptions = [
    { id: 1, name: 'Si, compartir' },
    { id: 2, name: 'No, no compartir' },
];
</script>