

<template>
    <div class="text-gray-900">
        <div class="grid grid-cols-1 md:grid-cols gap-4 mb-5"> 
            <div class="flex gap-4 w-full">
                <div class="w-64">
                    <FormField label="Código de la categoría de servicio:" required :error="form.errors.code">
                        <FormControl v-model="form.code" placeholder="Código de la categoría de servicio" maxlength="3" />
                    </FormField>
                </div>
                <div class="flex-1">
                    <FormField label="Nombre de la categoría de servicio:" required :error="form.errors.name">
                        <FormControl v-model="form.name" placeholder="Nombre de la categoría de servicio" />
                    </FormField>
                </div>
            </div>
        </div>
        <FormField label="Categoría de la institución" required :error="form.errors.institution_category_id">
            <FormControl v-model="form.institution_category_id" :options="institutionCategories" value-select="id"
                value-option="name" />
        </FormField>
        <FormField label="Descripción:" required :error="form.errors.description">
            <FormControl v-model="form.description" type="textarea"
                placeholder="Descripción del tipo de institución" rows="3" maxLength="2000" height="h-24" />
        </FormField>
    </div>
</template>

<script setup>
import { defineProps } from 'vue';
import FormField from "@/Components/FormField.vue";
import FormControl from "@/Components/FormControl.vue";

const { form, institutionCategories } = defineProps({
    form: Object,
    isEdit: Boolean,
    institutionCategories: Array,
});
</script>
