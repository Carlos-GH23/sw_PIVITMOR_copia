<template>
    <div class="text-gray-900">
        <div class="grid grid-cols-1 gap-4 mb-5">
            <div>
                <FormField label="Nombre del nivel:" required :error="form.errors.name">
                    <FormControl v-model="form.name" placeholder="Nombre del nivel educativo" />
                </FormField>
            </div>
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
