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
                        Disciplinas, sectores económicos y periodo de publicación
                    </p>
                </div>
            </div>
        </template>

        <CardSection title="Disciplinas científicas y tecnológicas (OCDE)"
            description="Clasificación de disciplinas según la OCDE" :hasDivider="false">
            <OecdSectorRecords :sectors="service.oecd_sectors" />
        </CardSection>

        <CardSection title="Sectores económicos y productivos (ISIC)"
            description="Clasificación de sectores económicos según ISIC">
            <EconomicSectorRecords :sectors="service.economic_sectors" />
        </CardSection>

        <CardSection title="Periodo de publicación" description="Periodo de publicación del servicio tecnológico"
            :icon="mdiCalendarBlankOutline">
            <div class="md:grid grid-cols-2 gap-4">
                <FormField label="Fecha de inicio">
                    <LabelControl :value="service.start_date?.formatted" />
                </FormField>

                <FormField label="Fecha de cierre">
                    <LabelControl :value="service.end_date?.formatted" />
                </FormField>
            </div>
        </CardSection>
    </CardForm>
</template>
<script setup>
import { mdiCalendarBlankOutline, mdiShape } from '@mdi/js';
import { computed, inject } from 'vue';
import 'swiper/css';
import 'swiper/css/pagination';
import 'swiper/css/navigation';
import BaseIcon from '@/Components/BaseIcon.vue';
import CardForm from '@/Components/CardForm.vue';
import CardSection from '@/Components/CardSection.vue';
import EconomicSectorRecords from '@/Components/Domains/Sectors/EconomicSectorRecords.vue';
import LabelControl from '@/Components/LabelControl.vue';
import FormField from '@/Components/FormField.vue';
import OecdSectorRecords from '@/Components/Domains/Sectors/OecdSectorRecords.vue';

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

const injectData = inject('service', null);

const service = computed(() => {
    return props.data || injectData || {};
});
</script>