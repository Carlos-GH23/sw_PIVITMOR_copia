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
            <OecdSectorRecords :sectors="requirement.oecd_sectors" />
        </CardSection>

        <CardSection title="Sectores económicos y productivos (ISIC)"
            description="Clasificación de sectores económicos según ISIC">
            <EconomicSectorRecords :sectors="requirement.economic_sectors" />
        </CardSection>

        <CardSection title="Periodo de publicación" description="Periodo de publicación de la necesidad tecnológica"
            :icon="mdiCalendarBlankOutline">
            <div class="md:grid grid-cols-2 gap-4">
                <LabelText label="Fecha de inicio" :text="requirement.start_date?.formatted" />
                <LabelText label="Fecha de cierre" :text="requirement.end_date?.formatted" />
            </div>
        </CardSection>
    </CardForm>
</template>
<script setup>
import { mdiCalendarBlankOutline, mdiShape } from '@mdi/js';
import { computed, inject, unref } from 'vue';
import 'swiper/css';
import 'swiper/css/pagination';
import 'swiper/css/navigation';
import BaseIcon from '@/Components/BaseIcon.vue';
import CardForm from '@/Components/CardForm.vue';
import CardSection from '@/Components/CardSection.vue';
import EconomicSectorRecords from '@/Components/Domains/Sectors/EconomicSectorRecords.vue';
import LabelText from '@/Components/LabelText.vue';
import OecdSectorRecords from '@/Components/Domains/Sectors/OecdSectorRecords.vue';

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