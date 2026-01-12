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
                        Datos básicos de la necesidad tecnológica
                    </p>
                </div>
            </div>
        </template>

        <div class="space-y-6">
            <LabelText label="Título" :text="requirement.title" />
            <LabelText label="Descripción técnica" :text="requirement.technical_description" />
            <LabelText label="Problema que resuelve" :text="requirement.need_statement" />
            <LabelText label="Aplicaciones potenciales" :text="requirement.potential_applications" />
            <LabelText label="Departamento" :text="requirement.department?.name" />
            <LabelText v-if="requirement?.intellectual_property" label="Propiedad intelectual"
                :text="requirement.intellectual_property?.name" />
            <LabelText v-if="requirement?.technology_level" label="Nivel de madurez tecnológica"
                :text="requirement.technology_level?.name" />

            <LabelText label="Palabras clave">
                <template #default>
                    <div class="flex gap-2 flex-wrap">
                        <BadgeList :items="requirement.keywords" />
                    </div>
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
import { inject, computed, unref } from 'vue';
import { mdiInformation } from '@mdi/js';
import 'swiper/css';
import 'swiper/css/pagination';
import 'swiper/css/navigation';

const props = defineProps({
    data: {
        type: Object,
        required: false,
    },
});

const injectData = inject('requirement', null);

const requirement = computed(() => {
    return props.data || unref(injectData) || {};
});
</script>