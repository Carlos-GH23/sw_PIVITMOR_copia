<template>
    <HeadLogo :title="title" />
    <LayoutMain>
        <SectionTitleLineWithButton :icon="mdiPlus" :title="title" main :route-back="`${routeName}index`">
            <div class="md:block hidden">
                <BaseButton :icon="mdiClose" color="lightDark" :route-name="`${routeName}index`" />
            </div>
        </SectionTitleLineWithButton>

        <ServiceForm :service="service" :serviceTypes="serviceTypes" :serviceCategories="serviceCategories"
            :oecdSectors="oecdSectors" :economicSectors="economicSectors" :academics="academics">
            <BaseButton :routeName="`${routeName}index`" :icon="mdiClose" color="lightDark" label="Cancelar" />
            <BaseButton v-if="assessments?.length > 0" @click="open" :icon="mdiCommentMultiple" color="lightDark"
                label="Evaluaciones" />
            <BaseButton @click="updateForm" :icon="mdiContentSave" color="lightDark" label="Actualizar borrador" />
            <BaseButton @click="updateForm(false)" :icon="mdiSend" :processing="processing" color="success"
                label="Enviar" />
        </ServiceForm>

        <div class="vl-parent">
            <loading v-model:active="processing" :can-cancel="false" isFullPage loader="dots" color="#283C2A" />
        </div>

        <EvaluationsModal @close="close" :show="isOpen" :assessments="assessments" />
    </LayoutMain>
</template>

<script setup>
import BaseButton from '@/Components/BaseButton.vue';
import HeadLogo from '@/Components/HeadLogo.vue';
import LayoutMain from '@/Layouts/LayoutMain.vue';
import SectionTitleLineWithButton from '@/Components/SectionTitleLineWithButton.vue';
import { mdiClose, mdiCommentMultiple, mdiContentSave, mdiPlus, mdiSend, } from '@mdi/js';
import ServiceForm from '../Components/ServiceForm.vue';
import { useService } from '../Composables/useService';
import EvaluationsModal from '../Components/EvaluationsModal.vue';
import { useModal } from '@/Hooks/useModal';

const { isOpen, open, close } = useModal();


const props = defineProps({
    title: { type: String, required: true },
    routeName: { type: String, required: true },
    service: { type: Object, required: true },
    departments: { type: Array, required: true },
    serviceTypes: { type: Array, required: true },
    serviceCategories: { type: Array, required: true },
    oecdSectors: { type: Array, required: false, default: () => [] },
    economicSectors: { type: Array, required: false, default: () => [] },
    academic: { type: Object, required: false, default: () => ({}) },
    academics: { type: Array, required: true },
    equipments: { type: Array, required: true },
    facilities: { type: Array, required: true },
    keywords: { type: Array, required: false, default: () => [] },
});

const { processing, updateForm } = useService(props);
const assessments = props.service?.data.assessments;
</script>
