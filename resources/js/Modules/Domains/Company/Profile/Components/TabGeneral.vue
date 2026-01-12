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
                        Proporciona los datos básicos de tu empresa
                    </p>
                </div>
            </div>
        </template>
        <div class="md:flex md:space-x-6 mb-5">
            <div class="md:w-4/12 max-lg:mb-5">
                <ImageUpload @delete="deletePhoto" title="Logo" v-model="form.logo.file" :error="form.errors['logo.file']"
                    :existingImage="form.logo.path" editMode />
            </div>
            <div class="md:w-8/12">
                <FormField label="Razón social" required :error="form.errors.name">
                    <FormControl v-model="form.name" placeholder="Razón social de la Empresa de Base Tecnológica" />
                </FormField>
                <FormField label="Nombre comercial" required :error="form.errors.legal_name">
                    <FormControl v-model="form.legal_name"
                        placeholder="Nombre comercial de la Empresa de Base Tecnológica" />
                </FormField>
                <div class="grid grid-cols-1 md:grid-cols-2 md:gap-4">
                    <FormField label="RFC" required :error="form.errors.rfc">
                        <FormControl v-model="form.rfc" placeholder="Ingresa tu RFC"/>
                    </FormField>
                    <FormField label="Año fundación" required :error="form.errors.year">
                        <FormControl v-model="form.year" type="number" placeholder="Ingresa tu año de fundación"/>
                    </FormField>
                </div>
            </div>
        </div>
        <CardSection title="Acerca de tu empresa" description="Proporciona los datos acerca de tu empresa"
            iconClasses="bg-forest-400 text-mono-100" :icon="mdiTextBox">
            <FormField label="Misión" :error="form.errors.mission">
                <ContentQuillEditor v-model="form.mission" placeholder="Ingresa la misión" maxLength="2000" />
            </FormField>
            <FormField label="Visión" :error="form.errors.vision">
                <ContentQuillEditor v-model="form.vision" placeholder="Ingresa la visión" maxLength="2000" />
            </FormField>
            <FormField label="Reseña" :error="form.errors.overview">
                <ContentQuillEditor v-model="form.overview" placeholder="Ingresa la reseña" maxLength="2000" />
            </FormField>
            <FormField label="Palabras clave" required :error="form.errors.keywords">
                <KeywordInput v-model="form.keywords" />
            </FormField>
        </CardSection>
    </CardForm>
</template>
<script setup>
import FormControl from '@/Components/FormControl.vue';
import FormField from '@/Components/FormField.vue';
import ImageUpload from '@/Components/ImageUpload.vue';
import { inject } from 'vue';
import BaseIcon from '@/Components/BaseIcon.vue';
import CardForm from '@/Components/CardForm.vue';
import { mdiInformation, mdiTextBox } from '@mdi/js';
import CardSection from '@/Components/CardSection.vue';
import ContentQuillEditor from '@/Components/ContentQuillEditor.vue';
import KeywordInput from '@/Components/KeywordInput.vue';

const form = inject('profileForm')
const props = inject('props')

const deletePhoto = () => {
    form.logo.delete_photo = true;
};
</script>