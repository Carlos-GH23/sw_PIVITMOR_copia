<template>
    <HeadLogo :title="title" />
    <LayoutMain>
        <SectionTitleLineWithButton :icon="mdiPlus" :title="title" main :route-back="`${routeName}index`">
            <div class="md:block hidden">
                <BaseButton :icon="mdiClose" color="lightDark" :route-name="`${routeName}index`" />
            </div>
        </SectionTitleLineWithButton>

        <CapabilityForm>
            <BaseButton :routeName="`${routeName}index`" :icon="mdiClose" color="lightDark" label="Cancelar" />
            <BaseButton @click="storeForm" :icon="mdiContentSave" color="lightDark" label="Guardar borrador" />
            <BaseButton @click="storeForm(false)" :icon="mdiSend" :processing="processing" color="success"
                label="Enviar" />
        </CapabilityForm>

        <div class="vl-parent">
            <loading v-model:active="processing" :can-cancel="false" isFullPage loader="dots" color="#283C2A" />
        </div>
    </LayoutMain>
</template>

<script setup>
import BaseButton from '@/Components/BaseButton.vue';
import HeadLogo from '@/Components/HeadLogo.vue';
import LayoutMain from '@/Layouts/LayoutMain.vue';
import SectionTitleLineWithButton from '@/Components/SectionTitleLineWithButton.vue';
import { mdiClose, mdiContentSave, mdiPlus, mdiSend } from '@mdi/js';
import CapabilityForm from '../Components/CapabilityForm.vue';
import { useCapability } from '../Composables/useCapability';

const props = defineProps({
    title: { type: String, required: true, },
    routeName: { type: String, required: true },
    department: { type: Object, required: true },
    academics: { type: Object, required: true },
    intellectualProperties: { type: Object, required: true },
    techLevels: { type: Object, required: true },
    economicSectors: { type: Object, required: true },
    oecdSectors: { type: Object, required: true },
});

const { processing, storeForm } = useCapability(props);
</script>