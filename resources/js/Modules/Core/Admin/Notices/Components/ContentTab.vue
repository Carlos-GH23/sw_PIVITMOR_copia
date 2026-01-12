<template>
    <CardForm>
        <template #header>
            <div class="flex gap-2 items-center py-4">
                <BaseIcon class="bg-forest-400 text-mono-100 rounded-lg" :path="mdiFileDocumentEdit " size="24" h="h-10"
                    w="w-10" />
                <div class="space-y-">
                    <p class="text-xl font-bold">
                        Contenido de la noticia
                    </p>
                    <p class=" text-sm font-light text-slate-800 dark:text-slate-300">
                        Escribe el contenido completo de la noticia que deseas publicar
                    </p>
                </div>
            </div>
        </template>

        <div class="grid md:grid-cols-1 gap-4 mb-4">
            <FormField label="Resumen" :error="form.errors.abstract">
                <FormControl v-model="form.abstract" type="textarea" height="h-32" maxLength="500"
                    placeholder="Escribe un resumen del contenido de la noticia.
Ejemplo: La noticia trata sobre.." />
            </FormField>

            <FormField label="Cuerpo completo de la noticia" required :error="form.errors.notice_body">
                <QuillEditor theme="snow" v-model:content="form.notice_body" content-type="html"
                    placeholder="Ingresa el cuerpo completo de la noticia" style="height: 230px;" />
            </FormField>

            <FormField label="Fuente o referencia" :error="form.errors.notice_source">
                <FormControl v-model="form.notice_source" type="textarea" maxLength="200" height="h-12"
                    placeholder="Escribe la fuente o referencia de la noticia." />
            </FormField>
        </div>
    </CardForm>
</template>

<script setup>
import BaseIcon from '@/Components/BaseIcon.vue';
import CardForm from '@/Components/CardForm.vue';
import FormField from '@/Components/FormField.vue';
import FormControl from '@/Components/FormControl.vue';
import { QuillEditor } from '@vueup/vue-quill';
import { mdiFileDocumentEdit } from '@mdi/js';
import { inject } from 'vue';

const form = inject('form');
</script>