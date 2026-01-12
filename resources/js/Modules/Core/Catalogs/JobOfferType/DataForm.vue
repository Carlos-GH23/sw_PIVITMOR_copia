<template>
  <div class="text-gray-900">
    <div class="grid grid-cols-1 gap-4 mb-5">
      <div>
        <FormField label="Nombre del tipo de oferta laboral:" required :error="props.form.errors.name">
          <FormControl v-model="props.form.name" placeholder="Nombre del tipo de oferta laboral" />
        </FormField>
      </div>
      <div>
        <FormField label="Descripción:" required :error="props.form.errors.description">
          <FormControl v-model="props.form.description" type="textarea"
            placeholder="Descripción del tipo de oferta laboral" rows="3" maxLength="255" height="h-24" />
        </FormField>
      </div>
    </div>
  </div>
</template>

<script setup>
import { defineProps } from 'vue';
import FormField from "@/Components/FormField.vue";
import FormControl from "@/Components/FormControl.vue";

const props = defineProps({
  form: Object,
  isEdit: Boolean
});
</script>