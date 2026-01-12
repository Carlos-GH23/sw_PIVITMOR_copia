<template>
    <CardForm class="border-forest-100/20 space-y-4">
        <template #header>
            <div class="flex flex-col py-4">
                <div class="flex items-center">
                    <BaseIcon class="text-forest-400" :path="mdiEmailNewsletter" size="24" h="h-10" w="w-10" />
                    <h3 class="text-forest-400 text-xl font-bold">
                        Plantillas de correo electrónico
                    </h3>
                </div>
                <span class="text-sm font-light text-slate-800 dark:text-slate-300">
                    Configura las plantillas de correo disponibles
                </span>
            </div>
        </template>

        <FormField label="Seleccionar plantilla de correo" class="w-1/2">
            <FormControl v-model="form.selectedTemplate" type="select" placeholder="Selecciona una plantilla"
                :options="emailTemplates.data" valueSelect="id" @change="setTemplate" />
        </FormField>

        <FormField label="Asunto del correo" required>
            <div class="">
                <FormControl v-model="form.subject" type="input" placeholder="No se ha seleccionado ninguna plantilla"
                    maxLength="255" />
            </div>
        </FormField>

        <FormField label="Cuerpo del correo" required>
            <div class="relative my-quill-wrapper">
                <QuillEditor theme="snow" v-model:content="form.body" content-type="html" class="my-quill"
                    placeholder="No se ha seleccionado ninguna plantilla" />
            </div>
        </FormField>

        <FormField label="Pie del correo" required>
            <div class="relative my-quill-wrapper">
                <QuillEditor theme="snow" v-model:content="form.footer" content-type="html" class="my-quill"
                    placeholder="No se ha seleccionado ninguna plantilla" />
            </div>
        </FormField>

        <CardBox class="border-forest-100/20" >
            <div class="flex gap-2 items-center py-4">
                <BaseIcon class="bg-forest-400 text-mono-100 rounded-lg" :path="mdiFileCode" size="24" h="h-10"
                    w="w-10" />
                <div>
                    <p class="text-forest-400 text-xl font-bold">
                        Variables disponibles
                    </p>
                    <p class=" text-sm font-light text-slate-800 dark:text-slate-300">
                        Utiliza estas variables para personalizar el contenido del correo electrónico.
                    </p>
                </div>
            </div>
            <div class="flex flex-wrap gap-3" v-if="form.selectedTemplate">
                <p v-for="value in form.variables" :key="value" class="text-gray-600">{{ value }}</p>
            </div>
            <div v-else>
                <p class="text-gray-400">No se ha seleccionado ninguna plantilla</p>
            </div>
        </CardBox>
    </CardForm>

    <CardBox class="border-forest-100/20 mt-5">
        <div class="md:flex justify-end items-center md:space-y-0 space-y-2">
            <BaseButtons>
                <BaseButton :icon="mdiClose" color="lightDark" label="Cancelar" />
                <BaseButton :icon="mdiEye" color="lightDark" label="Previsualizar" @click="openEmailPreview" />
                <BaseButton :icon="mdiContentSave" color="info" label="Guardar" @click="saveForm" />
            </BaseButtons>
        </div>
    </CardBox>
    <EmailPreviewModal :show="isEmailPreviewOpen" @close="closeEmailPreview" :form="form" />
</template>

<script setup>
import BaseButtons from '@/Components/BaseButtons.vue';
import BaseButton from '@/Components/BaseButton.vue';
import BaseIcon from '@/Components/BaseIcon.vue';
import CardBox from '@/Components/CardBox.vue';
import FormField from '@/Components/FormField.vue';
import CardForm from '@/Components/CardForm.vue';
import { useModal } from '@/Hooks/useModal';
import FormControl from '@/Components/FormControl.vue';
import { mdiClose, mdiContentSave, mdiEye, mdiEmailNewsletter, mdiFileCode  } from '@mdi/js';
import { QuillEditor } from '@vueup/vue-quill'
import EmailPreviewModal from './EmailPreviewModal.vue';
import { useEmail } from '../Composables/useEmail';

const props = defineProps({
    routeName: {
        type: String,
        required: true,
    },
    emailTemplates: {
        type: Object,
        required: true,
    },
});


const { isOpen: isEmailPreviewOpen, open: openEmailPreview, close: closeEmailPreview } = useModal();
const { form, setTemplate, saveForm } = useEmail(props);
</script>

<style scoped>
.my-quill-wrapper {
    border: 1px solid #90a1b9;
    border-radius: 8px;
    transition: border-color .15s ease, box-shadow .15s ease;
    overflow: hidden;
}

.my-quill-wrapper ::v-deep .ql-container {
    border: none;
    border-radius: inherit;
    box-shadow: none;
}

.my-quill-wrapper ::v-deep .ql-editor {
    min-height: 230px !important;
    padding: 0.75rem 1rem;
}

.my-quill-wrapper:focus-within {
    border-color: #86857E;
    border-width: 2px;
}
</style>