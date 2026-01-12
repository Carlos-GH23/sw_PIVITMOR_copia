<template>
    <HeadLogo :title="title" />
    <LayoutMain>
        <SectionTitleLineWithButton :icon="mdiPen" :title="title" main :routeBack="`${routeName}index`">
            <div class="md:block hidden">
                <BaseButton :icon="mdiClose" color="lightDark" :routeName="`${routeName}index`" />
            </div>
        </SectionTitleLineWithButton>
        <DataForm 
            :departments="departments"
            :academics="academics" 
            :oecdSectors="oecdSectors"
            :economicSectors="economicSectors"
            :knowledgeAreas="knowledgeAreas"
            :audienceTypes="audienceTypes"
            :modality="modality"
            :languages="languages"
        >
            <BaseButton :routeName="`${routeName}index`" :icon="mdiClose" color="lightDark" label="Cancelar" />
            <BaseButton @click="updateForm" :icon="mdiContentSave" color="lightDark" label="Actualizar borrador" />
            <BaseButton @click="updateForm(false)" :icon="mdiSend" :processing="processing" color="success"
                label="Publicar" />
        </DataForm>
    </LayoutMain>
</template>
<script setup>
import HeadLogo from '@/Components/HeadLogo.vue';
import LayoutMain from '@/Layouts/LayoutMain.vue';
import SectionTitleLineWithButton from '@/Components/SectionTitleLineWithButton.vue';
import { mdiClose, mdiContentSave, mdiPen, mdiSend } from '@mdi/js';
import BaseButton from '@/Components/BaseButton.vue';
import DataForm from '../Components/DataForm.vue';
import { useConference } from '../Composables/useConference.js';

const props = defineProps({
    title: { type: String, required: true },
    routeName: { type: String, required: true },
    conference: { type: Object, required: true },
    departments: { type: Array, default: () => [] },
    academics: { type: Array, default: () => [] },
    oecdSectors: { type: Array, default: () => [] },
    economicSectors: { type: Array, default: () => [] },
    knowledgeAreas: { type: Array, default: () => [] },
    audienceTypes: { type: Array, default: () => [] },
    modality: { type: Array, default: () => [] },
    languages: { type: Array, default: () => [] },
});

const { form, processing, updateForm } = useConference(props);
</script>