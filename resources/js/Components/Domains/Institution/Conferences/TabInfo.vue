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
                        Datos básicos de la conferencia
                    </p>
                </div>
            </div>
        </template>

        <div class="space-y-6">
            <LabelText label="Título" :text="conference.title" />
            <LabelText label="Descripción" :text="conference.description" />
            <LabelText label="Biografía del ponente" :text="conference.speaker_bio" />
            <LabelText label="Requisitos técnicos" :text="conference.technical_requirements" />
            <LabelText label="Departamento" :text="conference.department?.name" />
            <LabelText label="Palabras clave" :empty="!conference.keywords?.length">
                <template #default>
                    <BadgeList :items="conference.keywords" />
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

const injectData = inject('conference', null);

const conference = computed(() => {
    return props.data || injectData || {};
});
</script>
