<template>
    <CardForm>
        <template #header>
            <div class="flex gap-2 items-center py-4">
                <BaseIcon class="bg-wine-100 text-mono-100 rounded-lg p-2" :path="mdiTextBox" size="24" h="h-10"
                    w="w-10" />
                <div>
                    <p class="text-forest-400 text-xl font-bold">Evaluación</p>
                    <p class="text-sm font-light text-slate-800 dark:text-slate-300">
                        Completa el formulario y acepta o rechaza la solicitud
                    </p>
                </div>
            </div>
        </template>
        <FormField label="Estado de la solicitud" required :error="form.errors.requirement_status_id">
            <div class="space-y-2">
                <BaseSelectOption v-model="form.requirement_status_id" :value="3" title="Aprobar"
                    description="La solicitud cumple con los requisitos" color="green" :icon="mdiCheck" />
                <BaseSelectOption v-model="form.requirement_status_id" :value="4" title="Rechazar con comentarios"
                    description="La solicitud requiere correcciones" color="yellow" :icon="mdiClose" />
                <BaseSelectOption v-model="form.requirement_status_id" :value="5" title="Rechazar"
                    description="La solicitud no cumple con los requisitos, esto no se puede deshacer" color="red"
                    :icon="mdiClose" />
            </div>
        </FormField>
        <FormField label="Observaciones" required :error="form.errors.body">
            <FormControl v-model="form.body" type="textarea" height="h-32" max-length="255" />
        </FormField>

        <BaseButton :icon="mdiCheck" color="success" label="Enviar evaluación" :small="false" class="w-full"
            @click="saveForm" :processing="form.processing" />
    </CardForm>
</template>
<script setup>
import FormField from '@/Components/FormField.vue';
import FormControl from '@/Components/FormControl.vue';
import { useForm } from '@inertiajs/vue3';
import BaseButton from '@/Components/BaseButton.vue';
import { mdiCheck, mdiClose, mdiTextBox } from '@mdi/js';
import BaseSelectOption from '@/Components/BaseSelectOption.vue';
import { error422 } from '@/Hooks/useErrorsForm';
import CardForm from '@/Components/CardForm.vue';
import BaseIcon from '@/Components/BaseIcon.vue';

const { requirement } = defineProps({
    requirement: {
        type: Object,
        required: true,
    },
})

const form = useForm({ body: null, requirement_status_id: 3 })

const saveForm = () => {
    form.post(route("requirements.evaluations.store", requirement.id), {
        onError: () => error422(),
    });
}
</script>