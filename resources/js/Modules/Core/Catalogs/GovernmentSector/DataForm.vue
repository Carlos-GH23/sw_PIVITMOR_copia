<template>
    <CardBox>
        <div class="grid grid-cols-1 md:grid-cols-1 space-x-2 mb-6 md:mb-0">
            <FormField label="Nombre de la instalación:" required :error="form.errors.name">
                <FormControl v-model="form.name" placeholder="Nombre de la instalación" />
            </FormField>
            <FormField label="Descripción:" :error="form.errors.description">
                <FormControl v-model="form.description" placeholder="Descripción" type="textarea" height="h-24" maxLength="2000"/>
            </FormField>
        </div>
    </CardBox>
</template>
<script setup>
import CardBox from "@/Components/CardBox.vue";
import { defineProps } from 'vue';

import FormField from "@/Components/FormField.vue";
import FormControl from "@/Components/FormControl.vue";

const  {form} = defineProps({
    form: {
        type: Object,
        required: true
    },
});
</script>