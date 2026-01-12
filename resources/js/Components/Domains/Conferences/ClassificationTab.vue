<template>
    <CardForm>
        <template #header>
            <div class="flex gap-2 items-center py-4">
                <BaseIcon class="bg-forest-400 text-mono-100 rounded-lg" :path="mdiShape" size="24" h="h-10" w="w-10" />
                <div>
                    <p class="text-forest-400 text-xl font-bold">
                        Clasificación y Categorización
                    </p>
                    <p class=" text-sm font-light text-slate-800 dark:text-slate-300">
                        Taxonomía, etiquetas y recursos asociados
                    </p>
                </div>
            </div>
        </template>
        <div class="space-y-6">
            
            <CardSelectable :icon="mdiAtom" title="Disciplinas científicas y tecnológicas (OCDE)"
                :items="conference.oecd_sectors" :is-filtered="false" />

            <CardSelectable :icon="mdiHome" title="Sectores económicos y productivos (ISIC)" 
                :items="conference.economic_sectors" :is-filtered="false" />

            <CardSelectable :icon="mdiAccountGroup" title="Tipo de audiencia" 
                :items="audienceTypeObjects" :is-filtered="false" />

            <LabelText label="Título" :text="conference.modality" />
        </div>
    </CardForm>
</template>
<script setup>
import { mdiAtom, mdiShape, mdiAccountGroup, mdiHome } from '@mdi/js';
import { inject } from 'vue';
import 'swiper/css';
import 'swiper/css/pagination';
import 'swiper/css/navigation';
import CardSelectable from '@/Components/CardSelectable.vue';
import LabelText from '@/Components/LabelText.vue';
import CardForm from '@/Components/CardForm.vue';
import BaseIcon from '@/Components/BaseIcon.vue';

defineProps({
    hasBorder: Boolean,
})
const conference = inject('conference')

const audienceTypeObjects = Array.isArray(conference.audience_types) && conference.audience_types.length > 0
    ? (typeof conference.audience_types[0] === 'object'
        ? conference.audience_types.map(a => ({ ...a, name: a.type }))
        : inject('audienceTypes', []).filter(a => conference.audience_types.includes(a.id)).map(a => ({ ...a, name: a.type })))
    : [];
</script>