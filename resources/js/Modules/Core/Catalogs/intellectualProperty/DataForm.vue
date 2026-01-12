<template>
  <div class="md:flex md:space-x-4 mb-5">
    <div class="md:w-1/2 max-lg:mb-5">
      <FormField label="Nombre de la Propiedad Intelectual:" required :error="form.errors.name">
        <FormControl v-model="form.name" placeholder="Ingrese el nombre de la Propiedad Intelectual" />
      </FormField>
    </div>
  </div>
</template>

<script setup>

import { defineProps } from 'vue';
import FormField from "@/Components/FormField.vue";
import FormControl from "@/Components/FormControl.vue";


const props = defineProps({
  form: {
    type: Object,
    required: true,
  },
});
</script>
