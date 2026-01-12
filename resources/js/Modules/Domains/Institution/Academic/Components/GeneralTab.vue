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

        <div class="flex flex-col md:flex-row md:items-center md:gap-6 space-y-4 md:space-y-0">
            <FormField>
                <ImageUpload @delete="deletePhoto" title="Foto de perfil" v-model="form.photo.file"
                    :error="form.errors['photo.file']" :existing-image="form.photo.path" :edit-mode="true" />
            </FormField>
            <div class="md:w-2/3 space-y-4">
                <FormField label="Nombre" required :error="form.errors?.first_name">
                    <FormControl v-model="form.first_name" type="text" placeholder="Nombre" />
                </FormField>
                <FormField label="Primer apellido" required :error="form.errors?.last_name">
                    <FormControl v-model="form.last_name" type="text" placeholder="Primer apellido" maxlength="100"
                        required />
                </FormField>
                <FormField label="Segundo Apellido" :error="form.errors?.second_last_name">
                    <FormControl v-model="form.second_last_name" type="text" placeholder="Segundo apellido"
                        maxlength="100" />
                </FormField>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <FormField label="Puesto" required :error="form.errors?.academic_position_id">
                <FormControl v-model="form.academic_position_id" type="select" :options="positions" required />
            </FormField>
            <FormField label="Correo electrónico" required :error="form.errors?.['contact.email']">
                <FormControl v-model="form.contact.email" type="email" placeholder="correo@institución.edu.mx"
                    maxlength="150" required />
            </FormField>
        </div>

        <FormField label="Semblanza" required :error="form.errors?.biography">
            <ContentQuillEditor v-model="form.biography" placeholder="Escriba la semblanza del académico..."
                maxLength="2000" />
        </FormField>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <FormField label="Grado de estudios" required :error="form.errors?.academic_degree_id">
                <FormControl v-model="form.academic_degree_id" type="select" :options="academicDegrees" required />
            </FormField>
            <FormField label="Género" required :error="form.errors?.gender">
                <FormControl v-model="form.gender" type="select" :options="genders" required />
            </FormField>
        </div>

        <FormField label="Líneas de generación y aplicación de conocimiento (LGACs)" required
            :error="form.errors.knowledge_lines">
            <KeywordInput v-model="form.knowledge_lines" />
        </FormField>
        <FormField label="Departamento académico:" required :error="form.errors?.department_id">
            <FormControl v-model="form.department_id" type="select" :options="departments" />
        </FormField>
    </CardForm>
</template>

<script setup>
import { inject } from 'vue';
import FormControl from '@/Components/FormControl.vue';
import FormField from '@/Components/FormField.vue';
import ImageUpload from '@/Components/ImageUpload.vue';
import KeywordInput from '@/Components/KeywordInput.vue';
import BaseIcon from '@/Components/BaseIcon.vue';
import { mdiInformation } from '@mdi/js';
import CardForm from '@/Components/CardForm.vue';
import ContentQuillEditor from '@/Components/ContentQuillEditor.vue';

const form = inject('form')
const positions = inject('positions')
const academicDegrees = inject('academicDegrees')
const departments = inject('departments')
const genders = inject('genders')

const deletePhoto = () => {
    form.photo.delete_photo = true;
};
</script>