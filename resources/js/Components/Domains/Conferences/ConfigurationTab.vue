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
                        Datos básicos del servicio tecnológico
                    </p>
                </div>
            </div>
        </template>
        <div class="space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <LabelText label="Fecha de inicio" :text="conference.start_date" />
                <LabelText label="Fecha de fin" :text="conference.end_date" />
                <LabelText label="Departamento" :text="conference.department ? conference.department.name : ''" />
                <LabelText label="Idioma" :text="conference.language ? conference.language.name : ''" />
            </div>
            <CardSelectable :icon="mdiAccountGroup" title="Ponentes"
                :items="conference.academics" :is-filtered="false" />
        </div>
    </CardForm>
</template>
<script setup>
import LabelText from '@/Components/LabelText.vue';
import { inject } from 'vue';
import 'swiper/css';
import 'swiper/css/pagination';
import 'swiper/css/navigation';
import CardForm from '@/Components/CardForm.vue';
import { mdiAccountGroup, mdiInformation } from '@mdi/js';
import BaseIcon from '@/Components/BaseIcon.vue';
import CardSelectable from '@/Components/CardSelectable.vue';

defineProps({
    hasBorder: Boolean,
})

const conference = inject('conference')
</script>