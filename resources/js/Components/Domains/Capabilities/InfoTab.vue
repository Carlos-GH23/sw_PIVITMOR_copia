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
                        Datos básicos de la capacidad tecnológica
                    </p>
                </div>
            </div>
        </template>

        <div class="space-y-6">
            <LabelText label="Título" :text="capability.title" />
            <LabelText label="Descripción técnica" :text="capability.technical_description" />
            <LabelText label="Aplicaciones potenciales" :text="capability.problem_statement" />
            <LabelText label="Problema que resuelve" :text="capability.potential_applications" />
            <LabelText label="Departamento" :text="capability.department?.name" />
            <LabelText v-if="capability?.intellectual_property" label="Propiedad intelectual"
                :text="capability.intellectual_property?.name" />
            <LabelText v-if="capability?.technology_level" label="Nivel de madurez tecnológica"
                :text="capability.technology_level?.name" />

            <LabelText label="Palabras clave">
                <template #default>
                    <BadgeList :items="capability.keywords" />
                </template>
            </LabelText>
        </div>
    </CardForm>
</template>

<script setup>
import BadgeList from '@/Components/BadgeList.vue';
import BaseIcon from '@/Components/BaseIcon.vue';
import CardForm from '@/Components/CardForm.vue';
import LabelText from '@/Components/LabelText.vue';
import { mdiInformation } from '@mdi/js';
import { computed, inject, unref } from 'vue';

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

const injectData = inject('capability', null);

const capability = computed(() => {
    return unref(injectData) || props?.data || {};
});
</script>