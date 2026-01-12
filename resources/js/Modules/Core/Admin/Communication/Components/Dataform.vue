<template>
  <CardBox>
    <div class="flex gap-2 items-center py-4">
      <BaseIcon class="bg-forest-400 text-mono-100 rounded-lg" :path="mdiPen" size="24" h="h-10" w="w-10" />
      <p class="text-forest-400 text-xl font-bold">Redactar correo</p>
    </div>


    <FormField label="Asunto" required :error="form.errors.subject">
      <FormControl v-model="form.subject" type="input" height="h-10" placeholder="Ingrese el asunto del comunicado" />
    </FormField>


    <div class="grid grid-cols-1 md:grid-cols-2 md:gap-4">
      <FormField label="Destinatarios" required :error="form.errors.recipients">
        <FormControl v-model="form.recipients" :options="roles" placeholder="Selecciona un destinatario" />
      </FormField>

      <FormField label="Estatus" required :error="form.errors.status">
        <FormControl v-model="form.status" :options="statuses" placeholder="Selecciona un estatus" />
      </FormField>
    </div>
    <FormField label="Información del correo" required :error="form.errors.body">
      <div class="w-full">
        <QuillEditor content-type="html" theme="snow" placeholder="Ingresa la información del correo"
          style="height: 230px;" v-model:content="form.body" />
      </div>
    </FormField>
    <FormField label="Pie de correo" required :error="form.errors.footer">
      <div class="w-full">
        <QuillEditor content-type="html" theme="snow" placeholder="Ingresa la información del correo"
          style="height: 230px;" v-model:content="form.footer" />
      </div>
    </FormField>
    <div class="pt-6">
      <FileUpload title="Archivos adjuntos" description="Agrega archivos relevantes al correo." :form="form" />
    </div>
  </CardBox>
</template>

<script setup>
import { inject } from 'vue'
import BaseIcon from "@/Components/BaseIcon.vue"
import FormControl from "@/Components/FormControl.vue"
import FormField from "@/Components/FormField.vue"
import { QuillEditor } from "@vueup/vue-quill"
import { mdiPen } from '@mdi/js'
import FileUpload from '@/Components/FileUpload.vue'
import '@vueup/vue-quill/dist/vue-quill.snow.css'
import CardBox from "@/Components/CardBox.vue";

const form = inject('form')
const roles = inject('roles')
const statuses = inject('statuses')

</script>
