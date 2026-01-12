<template>
    <CardForm class="border-forest-100/20 space-y-4">
        <template #header>
            <div class="flex flex-col py-4">
                <div class="flex items-center">
                    <BaseIcon class="text-forest-400" :path="mdiInformation" size="24" h="h-10" w="w-10" />
                    <h3 class="text-forest-400 text-xl font-bold">
                        Políticas de uso
                    </h3>
                </div>
                <span class="text-sm font-light text-slate-800 dark:text-slate-300">
                    Proporciona las políticas de uso de la plataforma
                </span>
            </div>
        </template>

        <FormField label="Políticas de cookies" required :error="form.errors.cookies_policy">
            <ContentQuillEditor maxLength="5000" v-model="form.cookies_policy" />
        </FormField>

        <FormField label="Política de términos y condiciones" required :error="form.errors.terms_and_conditions">
            <ContentQuillEditor maxLength="5000" v-model="form.terms_and_conditions" />
        </FormField>

        <FormField label="Referencias legales aplicables" class="w-1/2" :error="form.errors.legal_references">
            <FormControl placeholder="Url de la referencia" :icon="mdiLink" v-model="form.legal_references" />
        </FormField>
    </CardForm>

    <CardBox class="border-forest-100/20 mt-5">
        <div class="md:flex justify-end items-center md:space-y-0 space-y-2">
            <BaseButtons>
                <BaseButton :icon="mdiClose" color="lightDark" label="Cancelar" />
                <BaseButton :icon="mdiContentSave" color="info" label="Guardar" @click="saveForm" :loading="processing" />
            </BaseButtons>
        </div>
    </CardBox>
</template>

<script setup>
import BaseButtons from '@/Components/BaseButtons.vue';
import BaseButton from '@/Components/BaseButton.vue';
import CardBox from '@/Components/CardBox.vue';
import CardForm from '@/Components/CardForm.vue';
import FormField from '@/Components/FormField.vue';
import FormControl from '@/Components/FormControl.vue';
import { mdiClose, mdiContentSave, mdiEye, mdiInformation, mdiLink } from '@mdi/js';
import ContentQuillEditor from '@/Components/ContentQuillEditor.vue';
import BaseIcon from '@/Components/BaseIcon.vue';
import { usePolitic } from '../Composables/usePolitic.js';

const props = defineProps({
    
    policies:{
        type: Object,
        required: true,
    }
});

const { form, saveForm, processing } = usePolitic(props);

</script>