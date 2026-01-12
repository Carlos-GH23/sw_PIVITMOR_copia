<template>
    <HeadLogo :title="title" />
    <LayoutMain>
        <SectionTitleLineWithButton :icon="mdiPlus" :title="title" main :routeBack="`${routeName}index`">
            <div class="md:block hidden">
                <BaseButton :icon="mdiClose" color="lightDark" :routeName="`${routeName}index`" />
            </div>
        </SectionTitleLineWithButton>
        <ServiceForm :service="{}" :serviceTypes="serviceTypes" :serviceCategories="serviceCategories"
            :academics="academics">
            <BaseButton :routeName="`${routeName}index`" :icon="mdiClose" color="lightDark" label="Cancelar" />
            <BaseButton @click="storeForm" :icon="mdiContentSave" color="lightDark" label="Guardar borrador" />
            <BaseButton @click="storeForm(false)" :icon="mdiSend" :processing="processing" color="success" label="Enviar" />
        </ServiceForm>
    </LayoutMain>
</template>

<script setup>
import BaseButton from '@/Components/BaseButton.vue';
import HeadLogo from '@/Components/HeadLogo.vue';
import LayoutMain from '@/Layouts/LayoutMain.vue';
import SectionTitleLineWithButton from '@/Components/SectionTitleLineWithButton.vue';
import { mdiClose, mdiContentSave, mdiPlus, mdiSend } from '@mdi/js';
import ServiceForm from '../Components/ServiceForm.vue';
import { useService } from '../Composables/useService';

const props = defineProps({
    title: { type: String, required: true },
    routeName: { type: String, required: true },
    serviceTypes: { type: Array, required: true },
    serviceCategories: { type: Array, required: true },
    oecdSectors: { type: Array, required: true },
    economicSectors: { type: Array, required: true },
    academics: { type: Array, required: true },
    equipments: { type: Array, required: true },
    facilities: { type: Array, required: true },
    departments: { type: Array, required: true },
});

const { processing, storeForm } = useService(props);
</script>