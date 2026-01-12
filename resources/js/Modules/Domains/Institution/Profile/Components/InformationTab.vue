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
                        Proporciona los datos básicos de la institución
                    </p>
                </div>
            </div>
        </template>
        <div class="space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="md:col-span-2">
                    <FormField>
                        <ImageUpload @delete="deletePhoto" title="Logo" v-model="form.logo.file"
                            :error="form.errors['logo.file']" :existingImage="form.logo.path" :editMode="true" />
                    </FormField>
                </div>

                <FormField label="Nombre de la institución" required :error="props.errors?.name">
                    <FormControl v-model="form.name" type="text" placeholder="Ingrese el nombre" />
                </FormField>
                <FormField label="Categoría de la institución" required :error="props.errors?.institution_category_id">
                    <FormControl v-model="form.institution_category_id" :options="props.categories" value-select="id"
                        value-option="name" @update:modelValue="handleCategoryChange" />
                </FormField>

                <div class="md:col-span-2">
                    <FormField label="Tipo de institución" required :error="props.errors?.institution_type_id"
                        :help="!form.institution_category_id ? 'Selecciona la categoría de la institución primero' : ''">
                        <FormControl v-model="form.institution_type_id" :options="filteredTypes" value-select="id"
                            value-option="name" :disabled="!form.institution_category_id" />
                    </FormField>
                    <FormField label="Reseña" :error="props.errors?.description">
                        <ContentQuillEditor v-model="form.description" placeholder="Ingresa una reseña"
                            maxLength="2000" />
                    </FormField>
                </div>
            </div>

            <FormField label="Palabras clave" required :error="form.errors.keywords">
                <KeywordInput v-model="form.keywords" :limit="5" :error="form.errors.keywords" />
            </FormField>
        </div>
    </CardForm>
</template>

<script setup>
import { inject, computed } from 'vue';
import CardForm from '@/Components/CardForm.vue';
import FormField from '@/Components/FormField.vue';
import FormControl from '@/Components/FormControl.vue';
import ImageUpload from '@/Components/ImageUpload.vue';
import { mdiInformation } from '@mdi/js';
import BaseIcon from '@/Components/BaseIcon.vue';
import ContentQuillEditor from '@/Components/ContentQuillEditor.vue';
import KeywordInput from '@/Components/KeywordInput.vue';

const form = inject('form');
const props = inject('props');

const filteredTypes = computed(() => {
    if (!form.institution_category_id) {
        return [];
    }
    return props.types.filter(type =>
        type.institution_category_id === form.institution_category_id
    );
});

const handleCategoryChange = () => {
    form.institution_type_id = null;
};

const deletePhoto = () => {
    form.logo.delete_photo = true;
};
</script>
