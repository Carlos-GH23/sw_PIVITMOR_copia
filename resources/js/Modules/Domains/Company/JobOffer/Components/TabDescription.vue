<template>
    <CardForm>
        <template #header>
            <div class="flex gap-2 items-center py-4">
                <BaseIcon class="bg-forest-400 text-mono-100 rounded-lg" :path="mdiText" size="24" h="h-10" w="w-10" />
                <div>
                    <p class="text-forest-400 text-xl font-bold">
                        Descripción
                    </p>
                    <p class=" text-sm font-light text-slate-800 dark:text-slate-300">
                        Proporciona los datos de descripción
                    </p>
                </div>
            </div>
        </template>

        <div class="grid grid-cols-1 md:grid-cols-2 md:gap-4">
            <FormField label="Descripción de la vacante" required :error="form.errors.job_description">
                <FormControl v-model="form.job_description" type="textarea" height="h-24" maxLength="2000"
                    placeholder="Agrega una descripción de la vacante" />
            </FormField>
            <FormField label="Responsabilidades" required :error="form.errors.responsibilities">
                <FormControl v-model="form.responsibilities" type="textarea" height="h-24" maxLength="2000"
                    placeholder="Agrega las responsabilidades de la vacante" />
            </FormField>
            <FormField label="Habilidades e idiomas" :error="form.errors.skills_languages">
                <FormControl v-model="form.skills_languages" type="textarea" height="h-24" maxLength="2000"
                    placeholder="Agrega las habilidades e idiomas requeridos" />
            </FormField>
            <FormField label="Observaciones" :error="form.errors.observations">
                <FormControl v-model="form.observations" type="textarea" height="h-24" maxLength="2000"
                    placeholder="Agrega observaciones adicionales" />
            </FormField>
            <FormField label="Comentarios" :error="form.errors.comments">
                <FormControl v-model="form.comments" type="textarea" height="h-24" maxLength="2000"
                    placeholder="Agrega comentarios adicionales" />
            </FormField>
        </div>
    </CardForm>
</template>
<script setup>
import BaseIcon from "@/Components/BaseIcon.vue";
import CardForm from "@/Components/CardForm.vue";
import FormControl from "@/Components/FormControl.vue";
import FormField from "@/Components/FormField.vue";
import { mdiText } from "@mdi/js";
import { inject } from "vue";

const form = inject("formJobOffer")
</script>