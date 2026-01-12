<template>
    <div class="space-y-6">
        <div class="grid grid-cols-1 gap-6">
            <FormField label="Nombre de la estructura organizacional" required :error="errors?.name">
                <FormControl v-model="form.name" type="text" placeholder="Nombre de la estructura organizacional"
                    maxLength="255" required :error="errors?.name" />
            </FormField>

            <FormField label="Descripción" required :error="errors?.description">
                <FormControl v-model="form.description" type="textarea"
                    placeholder="Descripción de la estructura organizacional" height="h-48" maxLength="2000" required
                    :error="errors?.description" />
            </FormField>
        </div>
    </div>
</template>

<script setup>
import FormField from "@/Components/FormField.vue";
import FormControl from "@/Components/FormControl.vue";

defineProps({
    form: { type: Object, required: true },
    errors: { type: Object, default: () => ({}) },
});
</script>
