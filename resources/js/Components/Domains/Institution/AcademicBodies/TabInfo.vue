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
                        Datos básicos del cuerpo académico
                    </p>
                </div>
            </div>
        </template>

        <div class="space-y-6">
            <LabelText label="Nombre" :text="academicBody.name" />
            <div class="grid md:grid-cols-2 gap-4">
                <LabelText label="Grado de consolidación" :text="academicBody.consolidation_degree?.name" />
                <LabelText label="Clave" :text="academicBody.key" />
            </div>
            <LabelText label="Departamento" :text="academicBody.department?.name" />
            <LabelText label="LGAC Asociadas">
                <template #default>
                    <BadgeList :items="academicBody.knowledge_lines" />
                </template>
            </LabelText>
            <LabelText label="Reseña" :text="academicBody.review" />
        </div>
    </CardForm>
</template>

<script setup>
import BadgeList from '@/Components/BadgeList.vue';
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

const injectData = inject('academic_body', null);

const academicBody = computed(() => {
    return props.data || injectData || {};
});
</script>
