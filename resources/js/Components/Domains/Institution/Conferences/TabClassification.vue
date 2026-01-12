<template>
    <CardForm>
        <template #header>
            <div class="flex gap-2 items-center py-4">
                <BaseIcon class="bg-forest-400 text-mono-100 rounded-lg" :path="mdiShape" size="24" h="h-10" w="w-10" />
                <div>
                    <p class="text-forest-400 text-xl font-bold">
                        Clasificación y programación
                    </p>
                    <p class=" text-sm font-light text-slate-800 dark:text-slate-300">
                        Disciplinas y programación de la conferencia
                    </p>
                </div>
            </div>
        </template>

        <CardSection title="Disciplinas científicas y tecnológicas (OCDE)"
            description="Clasificación de disciplinas según la OCDE" :hasDivider="false">
            <OecdSectorRecords :sectors="conference.oecd_sectors" />
        </CardSection>

        <CardSection title="Programación" description="Fechas y detalles de la conferencia">
            <div class="space-y-6">
                <div class="grid md:grid-cols-2 gap-4">
                    <LabelText label="Modalidad" :text="conference.modality" />
                    <LabelText label="Idioma" :text="conference.language?.name" />
                </div>

                <div class="grid md:grid-cols-2 gap-4">
                    <LabelText label="Fecha de inicio" :text="conference.start_date" />
                    <LabelText label="Fecha de fin" :text="conference.end_date" />
                </div>

                <LabelText label="Tipos de audiencia" :empty="!conference.audience_types?.length">
                    <template #default>
                        <BadgeList :items="conference.audience_types" nameKey="type" />
                    </template>
                </LabelText>
            </div>
        </CardSection>
    </CardForm>
</template>

<script setup>
import BadgeList from '@/Components/BadgeList.vue';
import BaseIcon from '@/Components/BaseIcon.vue';
import CardForm from '@/Components/CardForm.vue';
import CardSection from '@/Components/CardSection.vue';
import LabelText from '@/Components/LabelText.vue';
import OecdSectorRecords from '@/Components/Domains/Sectors/OecdSectorRecords.vue';
import { mdiShape } from '@mdi/js';
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
