<template>
    <div class="text-gray-900">
        <div class="grid grid-cols-1 md:grid-cols-2 space-x-2 mb-6 md:mb-0 ">
            <FormField label="Código del tipo de servicio:" required :error="form.errors.code">
                <FormControl v-model="form.code" placeholder="Código del tipo de servicio" maxlength="3" />
            </FormField>

            <FormField label="Categoría del servicio:" required :error="form.errors.category_id">
                <FormControl v-model="form.category_id" :options="categories.data" value-select="id" value-option="name"
                    placeholder="Seleccione una categoría" class="w-full" />
            </FormField>
        </div>

        <FormField label="Nombre del tipo de servicio:" required :error="form.errors.name">
            <FormControl v-model="form.name" placeholder="Nombre del tipo de servicio" />
        </FormField>

        <FormField label="Descripción:" required :error="form.errors.description">
            <FormControl v-model="form.description" placeholder="Descripción" type="textarea" height="h-24" maxLength="2000"
                @input="onDescriptionInput" />
        </FormField>
    </div>
</template>

<script setup>
import { defineProps } from 'vue';
import FormField from "@/Components/FormField.vue";
import FormControl from "@/Components/FormControl.vue";


const { form, categories = { data: [] } } = defineProps({
    form: {
        type: Object,
        required: true
    },
    categories: {
        type: Object,
        required: false,
        default: () => ({ data: [] })
    }
});

function onDescriptionInput(e) {
    if (e.target.value.length > 255) {
        e.target.value = e.target.value.slice(0, 255);
        form.description = e.target.value;
    }
}
</script>
