<template>
    <Modal :show="show" max-width="xl" :closeable="true">
        <CardBox :hasBorder="false">
            <div class="mb-4">
                <div class="flex justify-between items-center">
                    <div class="flex items-center gap-2">
                        <UserRoundCog class="w-5 h-5 text-forest-400" />
                        <h2 class="text-forest-400 text-xl font-bold">Consentimiento de usuario</h2>
                    </div>

                    <BaseButton color="light" @click="$emit('close')" :icon="mdiClose" />
                </div>
                <span class="text-sm font-light text-slate-800 dark:text-slate-300">
                    Configurar los requisitos de consentimiento y los mensajes que se muestran a los usuarios
                </span>
            </div>

            <div class="flex items-center justify-between mb-4">
                <Label value="Consentimiento para uso de datos" />
                <FormCheckRadio v-model="form.data_usage_consent" inputValue="boolean" name="dataUsageConsent"
                    type="switch" />
            </div>

            <div class="flex items-center justify-between mb-4">
                <Label value="Forzar aceptación al inicio de sesión" />
                <FormCheckRadio v-model="form.force_acceptance" inputValue="boolean" name="forceAcceptance"
                    type="switch" />
            </div>

            <SwitcherToggle label="Consentimiento para comunicaciones electrónicas"
                description="Permite el envío de correos y notificaciones" name="consent"
                v-model="form.electronic_communication_consent" :icon="Check" inputValue="boolean">
                <FormField v-if="form.electronic_communication_consent" label="Mensaje de consentimiento" required
                    :error="form.errors.electronic_communication_message">
                    <FormControl type="textarea" height="min-h-32" maxLength="500"
                        v-model="form.electronic_communication_message" placeholder="" />
                </FormField>
            </SwitcherToggle>

            <SwitcherToggle label="Consentimiento para fines estadísticos"
                description="Permite el análisis de datos con fines estadísticos" name="consent"
                v-model="form.statistical_data_consent" :icon="Check" inputValue="boolean">
                <FormField v-if="form.statistical_data_consent" label="Mensaje de consentimiento" required
                    :error="form.errors.statistical_data_message">
                    <FormControl type="textarea" placeholder="" height="min-h-32" maxLength="500"
                        v-model="form.statistical_data_message" />
                </FormField>
            </SwitcherToggle>

            <FormField label="Frecuencia de renovación de consentimiento" :error="form.errors.frequency_of_acceptance">
                <FormControl type="select" v-model="form.frequency_of_acceptance" :options="frequency" />
            </FormField>

            <BaseButton @click="saveForm" class="w-full" color="info" label="Guardar configuración"
                :icon="mdiContentSave" />
        </CardBox>
    </Modal>
</template>

<script setup>
import BaseButton from '@/Components/BaseButton.vue';
import CardBox from '@/Components/CardBox.vue';
import FormControl from '@/Components/FormControl.vue';
import FormField from '@/Components/FormField.vue';
import Modal from '@/Components/Modal.vue';
import { mdiClose, mdiContentSave } from '@mdi/js';
import { Check, UserRoundCog } from 'lucide-vue-next';
import { useSettings } from '../Composables/useSettings';
import SwitcherToggle from '@/Components/SwitcherToggle.vue';
import FormCheckRadio from '@/Components/FormCheckRadio.vue';
import Label from '@/Components/Label.vue';

const props = defineProps({
    props: {
        type: Object,
        required: true,
    },
    show: Boolean
});

const emit = defineEmits(['close']);

const { form, saveForm } = useSettings(props.props, emit);

const frequency = [
    { id: 'never', name: 'Nunca' },
    { id: 'bi_annually', name: 'Cada 6 meses' },
    { id: 'annually', name: 'Anualmente' },
    { id: 'version_change', name: 'Por versión' },
];
</script>