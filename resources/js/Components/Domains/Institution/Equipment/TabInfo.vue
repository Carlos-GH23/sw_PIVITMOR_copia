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
                        Datos básicos del equipamiento de la instalación
                    </p>
                </div>
            </div>
        </template>

        <div class="space-y-6">
            <LabelText label="Nombre del equipamiento" :text="equipment.name" />
            <LabelText label="Tipo de equipamiento" :text="equipment.equipmentType?.name" />
            <LabelText label="Descripción" :text="equipment.description" />
            <LabelText label="Instalación" :text="equipment.facility?.name" />
            <LabelText label="Académico responsable" :text="equipment.responsible?.name" />
            <LabelText label="Departamento" :text="equipment.department?.name" />
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

const injectData = inject('equipment', null);

const equipment = computed(() => {
    return props.data || injectData || {};
});
</script>
