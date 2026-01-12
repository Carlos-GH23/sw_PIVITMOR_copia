<template>
    <div class="text-gray-900">
        <div class="grid grid-cols-1 gap-4 mb-5">
            <FormField label="Nombre del área:" required :error="form.errors.name">
                <FormControl v-model="form.name" placeholder="Nombre del área SNI" />
            </FormField>
            <FormField label="Número de orden:" required :error="form.errors.order">
                <FormControl v-model="form.order" type="number" placeholder="Número de orden del área SNI" />
            </FormField>
            <FormField label="Descripción:" required :error="form.errors.description">
                <FormControl v-model="form.description" type="textarea" placeholder="Descripción del área SNI" rows="3"
                    maxLength="2000" height="h-24" />
            </FormField>
        </div>
    </div>
</template>

<script setup>
import { defineProps } from 'vue';
import FormField from "@/Components/FormField.vue";
import FormControl from "@/Components/FormControl.vue";

const { form } = defineProps({
    form: Object,
    isEdit: Boolean
});
</script>
