<template>
    <HeadLogo title="Dashboard" />
    <LayoutMain>
        <SectionTitleLineWithButton :icon="mdiMonitorDashboard" :title="title" :description="description" main
            :hisBreadCrumb="false" />
        <InstitutionIndicators :kpis="kpis" :institution="institution" />
    </LayoutMain>
</template>
<script setup>
import HeadLogo from '@/Components/HeadLogo.vue';
import InstitutionIndicators from '../Components/InstitutionIndicators.vue';
import SectionTitleLineWithButton from '@/Components/SectionTitleLineWithButton.vue';
import LayoutMain from '@/Layouts/LayoutMain.vue';
import { mdiMonitorDashboard } from '@mdi/js';

const props = defineProps({
    title: { type: String, required: true },
    description: { type: String, required: true },
    kpis: { type: Object, default: () => ({}) },
    institution: { type: Object, default: () => ({}) },
});
</script>