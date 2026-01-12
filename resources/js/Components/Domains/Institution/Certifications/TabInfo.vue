<template>
    <CardForm>
        <template #header>
            <div class="flex gap-2 items-center py-4">
                <BaseIcon class="bg-forest-400 text-mono-100 rounded-lg" :path="mdiInformation" size="24" h="h-10"
                    w="w-10" />
                <div>
                    <p class="text-forest-400 text-xl font-bold">
                        Información general
                    </p>
                    <p class=" text-sm font-light text-slate-800 dark:text-slate-300">
                        Datos básicos de la certificación institucional
                    </p>
                </div>
            </div>
        </template>

        <div class="space-y-6">
            <div class="grid grid-cols-2 gap-4">
                <LabelText label="Nombre de la certificación" :text="certification.name" />
                <LabelText label="Departamento" :text="certification.department?.name" />
            </div>
            <div class="grid grid-cols-2 gap-4">
                <LabelText label="Entidad certificadora" :text="certification.certifying_entity" />
                <LabelText label="Tipo de recurso" :text="certification.resource_type?.name" />
            </div>
            <div class="grid grid-cols-2 gap-4">
                <LabelText label="Tipo de certificación" :text="certification.certification_type?.name" />
                <LabelText label="Recurso certificado" :text="certification.certified_resource?.name" />
            </div>
            <LabelText label="Descripción" :text="certification.description" />
        </div>
    </CardForm>
</template>

<script setup>
import BaseIcon from '@/Components/BaseIcon.vue';
import CardForm from '@/Components/CardForm.vue';
import LabelText from '@/Components/LabelText.vue';
import { mdiInformation } from '@mdi/js';
import { computed, inject } from 'vue';

const props = defineProps({
    hasBorder: {
        type: Boolean,
        default: false,
    },
    data: {
        type: Object,
        required: false,
    },
});

const injectData = inject('certification', null);

const certification = computed(() => {
    return props.data || injectData || {};
});
</script>
