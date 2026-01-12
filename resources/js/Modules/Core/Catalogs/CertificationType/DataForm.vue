<template>
    <div class="text-gray-900">
        <div class="grid grid-cols-1 md:grid-cols gap-4 mb-5">
            <FormField label="Nombre del tipo de certificación:" required :error="form.errors.name">
                <FormControl v-model="form.name" placeholder="Nombre del tipo de certificación" />
            </FormField>
        </div>
        <FormField label="Descripción:" required :error="form.errors.description">
            <FormControl v-model="form.description" type="textarea"
                placeholder="Descripción del tipo de certificación" rows="3" maxLength="2000" height="h-24" />
        </FormField>
    </div>
</template>

<script setup>
import { defineProps } from 'vue';
import FormField from "@/Components/FormField.vue";
import FormControl from "@/Components/FormControl.vue";

const { form } = defineProps({
    form: {
        type: Object,
        required: true
    },
});
</script>