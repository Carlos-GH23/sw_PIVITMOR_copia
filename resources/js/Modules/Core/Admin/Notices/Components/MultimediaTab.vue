<template>
    <CardForm>
        <template #header>
            <div class="flex gap-2 items-center py-4">
                <BaseIcon class="bg-forest-400 text-mono-100 rounded-lg" :path="mdiFolderMultipleImage" size="24"
                    h="h-10" w="w-10" />
                <div class="space-y-">
                    <p class="text-xl font-bold">
                        Multimedia de la noticia
                    </p>
                    <p class=" text-sm font-light text-slate-800 dark:text-slate-300">
                        Proporciona los datos multimedia de la noticia
                    </p>
                </div>
            </div>
        </template>

        <div class="grid grid-cols-1 md:grid-cols-1 gap-6 items-start">
            <FormField required label="Selecciona una imagen">
                <ImageUpload @delete="deletePhoto" v-model="form.photo.file" title=" "
                    description="La imagen debe tener un tamaño máximo de 2MB. Formatos permitidos: jpg, png, gif."
                    :existingImage="form.photo.path" :editMode="isEditMode" :error="form.errors.photo"  />
            </FormField>
            <FormField label="Texto adicional de la imagen" :error="form.errors['photo.description']">
                <FormControl v-model="form.photo.description" type="textarea" height="h-32" maxLength="500" placeholder="Escribe una descripción de la imagen.
Ejemplo: La imagen muestra..." />
            </FormField>
        </div>
    </CardForm>
</template>

<script setup>
import BaseIcon from '@/Components/BaseIcon.vue';
import CardForm from '@/Components/CardForm.vue';
import FormField from '@/Components/FormField.vue';
import FormControl from '@/Components/FormControl.vue';
import ImageUpload from '@/Components/ImageUpload.vue';
import { mdiFolderMultipleImage } from '@mdi/js';
import { inject } from 'vue';

const form = inject('form');
const isEditMode = inject('isEditMode');

const deletePhoto = () => {
    form.photo.delete_photo = true;
};
</script>