<template>
    <div class="mt-5">
        <CardBox>
            <h3 class="text-lg md:text-xl text-forest-400 font-semibold mb-4">Resumen ejecutivo (KPIs)</h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4">
                <KpiCard v-for="(kpi, index) in data" :key="index" :label="kpi.label" :value="kpi.value"
                    :subtitle="kpi.subtitle" :icon="getIcon(kpi.icon)" />
            </div>
        </CardBox>
    </div>
</template>

<script setup>
import CardBox from '@/Components/CardBox.vue';
import KpiCard from './KpiCard.vue';
import {
    mdiAccountMultipleOutline,
    mdiAccountPlusOutline,
    mdiHandCoin,
    mdiLink,
    mdiOffer,
    mdiAccountGroup,
    mdiGenderMale,
    mdiGenderFemale,
    mdiSchool,
    mdiFlask
} from '@mdi/js';

defineProps({
    data: {
        type: Array,
        default: () => [],
    },
});

const iconMap = {
    mdiAccountMultipleOutline,
    mdiAccountPlusOutline,
    mdiHandCoin,
    mdiLink,
    mdiOffer,
    mdiAccountGroup,
    mdiGenderMale,
    mdiGenderFemale,
    mdiSchool,
    mdiFlask
};

const getIcon = (iconName) => {
    return iconMap[iconName] || mdiAccountMultipleOutline;
};
</script>