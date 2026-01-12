<template>
    <CardForm>
        <template #header>
            <div class="flex gap-2 items-center py-4">
                <BaseIcon class="bg-forest-400 text-mono-100 rounded-lg" :path="mdiShape" size="24" h="h-10" w="w-10" />
                <div>
                    <p class="text-forest-400 text-xl font-bold">
                        Clasificación
                    </p>
                    <p class=" text-sm font-light text-slate-800 dark:text-slate-300">
                        Sectores de la oferta académica
                    </p>
                </div>
            </div>
        </template>

        <CardSection title="Disciplinas científicas y tecnológicas (OCDE)"
            description="Clasificación de disciplinas según la OCDE" :hasDivider="false">
            <OecdSectorRecords :sectors="data.oecd_sectors" />
        </CardSection>

        <CardSection title="Sectores económicos y productivos (ISIC)"
            description="Clasificación de sectores económicos según ISIC">
            <EconomicSectorRecords :sectors="data.economic_sectors" />
        </CardSection>
    </CardForm>
</template>

<script setup>
import BaseIcon from '@/Components/BaseIcon.vue';
import CardForm from '@/Components/CardForm.vue';
import CardSection from '@/Components/CardSection.vue';
import OecdSectorRecords from '@/Components/Domains/Sectors/OecdSectorRecords.vue';
import EconomicSectorRecords from '@/Components/Domains/Sectors/EconomicSectorRecords.vue';
import { mdiShape } from '@mdi/js';

defineProps({
    hasBorder: {
        type: Boolean,
        default: false,
    },
    data: {
        type: Object,
        required: false,
    },
});
</script>
