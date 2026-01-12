<template>
    <CardForm>
        <template #header>
            <div class="flex gap-2 items-center py-4">
                <BaseIcon class="bg-forest-400 text-mono-100 rounded-lg" :path="mdiAccountOutline" size="24" h="h-10"
                    w="w-10" />
                <div>
                    <h3 class="text-forest-400 text-xl font-bold">
                        Información personal
                    </h3>
                    <span class=" text-sm font-light text-slate-800">
                        Proporciona tus datos personales básicos
                    </span>
                </div>
            </div>
        </template>

        <div class="flex flex-col md:items-center md:justify-center md:gap-4 md:flex-row">

            <ImageUpload @delete="deletePhoto" title="Foto de perfil" v-model="form.photo.file"
                :error="form.errors['photo.file']" :existing-image="form.photo.path" :edit-mode="true" />

            <div class="md:w-2/3">
                <FormField required label="Nombre" :error="props.errors?.first_name">
                    <FormControl v-model="form.first_name" placeholder="Ingrese su nombre" />
                </FormField>
                <FormField required label="Apellido paterno" :error="props.errors?.last_name">
                    <FormControl v-model="form.last_name" placeholder="Apellido paterno" />
                </FormField>
                <FormField label="Apellido materno" :error="props.errors?.second_last_name">
                    <FormControl v-model="form.second_last_name" placeholder="Apellido materno" />
                </FormField>
            </div>
        </div>

        <FormField required label="Reseña" help="Describa brevemente su perfil profesional"
            :error="props.errors?.biography">
            <ContentQuillEditor v-model="form.biography" placeholder="Describa brevemente su perfil profesional"
                maxLength="2000" />
        </FormField>
        <FormField required label="Género" :error="props.errors?.gender">
            <FormControl type="select" v-model="form.gender" :icon="mdiGenderMaleFemaleVariant" :options="genders" />
        </FormField>
    </CardForm>
</template>

<script setup>
import { inject } from "vue";
import BaseIcon from "@/Components/BaseIcon.vue";
import CardForm from "@/Components/CardForm.vue";
import FormField from "@/Components/FormField.vue";
import FormControl from "@/Components/FormControl.vue";
import ImageUpload from "@/Components/ImageUpload.vue";
import { mdiAccountOutline, mdiGenderMaleFemaleVariant } from "@mdi/js";
import ContentQuillEditor from "@/Components/ContentQuillEditor.vue";

const form = inject('form');
const props = inject('props');
const genders = inject('genders');

const deletePhoto = () => {
    form.photo.delete_photo = true;
};
</script>
