<template>
    <CardBox padding="px-4 md:px-2">
        <div class="sticky -top-1 bg-white z-10 mb-4">
            <h3 class="text-base text-forest-400 font-semibold">Evaluación</h3>
            <span class="text-sm text-gray-500">Completa el formulario y acepta o rechaza la solicitud</span>
        </div>

        <div class="mb-4">
            <BaseSelectOption v-model="form.technology_service_status_id" v-for="option in switchOptions" v-bind="option"
                class="mb-4" />
            <InputError :message="form.errors.technology_service_status_id" />
        </div>

        <FormField label="Observaciones" required :error="form.errors.body">
            <FormControl v-model="form.body" type="textarea" height="h-32" max-length="255" />
        </FormField>

        <BaseButtons>
            <BaseButton :routeName="`${routeName}index`" :icon="mdiClose" color="lightDark" label="Cancelar" />
            <BaseButton @click="evaluate" :icon="mdiContentSave" color="success" label="Evaluar" />
        </BaseButtons>
    </CardBox>
</template>

<script setup>
import BaseButton from '@/Components/BaseButton.vue';
import BaseButtons from '@/Components/BaseButtons.vue';
import BaseSelectOption from '@/Components/BaseSelectOption.vue';
import CardBox from '@/Components/CardBox.vue';
import FormControl from '@/Components/FormControl.vue';
import FormField from '@/Components/FormField.vue';
import InputError from '@/Components/InputError.vue';
import { mdiClose, mdiContentSave } from '@mdi/js';

defineProps({
    form: Object,
    routeName: String,
});

const emits = defineEmits(['evaluate']);

const evaluate = () => {
    emits('evaluate');
};

const switchOptions = [
    {
        title: 'Aceptar',
        description: 'Aceptar servicio tecnológico',
        value: 3
    },
    {
        title: 'Rechazar',
        description: 'Rechazar servicio tecnológico',
        value: 5,
        color: 'red'
    },
    {
        title: 'Rechazar con observaciones',
        description: 'Rechazar con observaciones el servicio tecnológico',
        value: 4,
        color: 'yellow'
    },
];
</script>
