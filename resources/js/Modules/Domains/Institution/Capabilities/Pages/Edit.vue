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
            <BaseButton v-if="assessments?.length > 0" @click="open" :icon="mdiCommentMultiple" color="lightDark"
                label="Evaluaciones" />
            <BaseButton @click="updateForm" :icon="mdiContentSave" color="lightDark" label="Actualizar borrador" />
            <BaseButton @click="updateForm(false)" :icon="mdiSend" :processing="processing" color="success"
                label="Enviar" />
        </CapabilityForm>

        <div class="vl-parent">
            <loading v-model:active="processing" :can-cancel="false" isFullPage loader="dots" color="#283C2A" />
        </div>

        <EvaluationsModal @close="close" :show="isOpen" :assessments="assessments" />
    </LayoutMain>
</template>

<script setup>
import BaseButton from '@/Components/BaseButton.vue';
import HeadLogo from '@/Components/HeadLogo.vue';
import CapabilityForm from '../Components/CapabilityForm.vue';
import EvaluationsModal from '@/Components/Domains/Evaluations/EvaluationsModal.vue';
import LayoutMain from '@/Layouts/LayoutMain.vue';
import SectionTitleLineWithButton from '@/Components/SectionTitleLineWithButton.vue';
import { mdiClose, mdiCommentMultiple, mdiContentSave, mdiPlus, mdiSend } from '@mdi/js';
import { useCapability } from '../Composables/useCapability';
import { useModal } from '@/Hooks/useModal';

const props = defineProps({
    title: { type: String, required: true, },
    routeName: { type: String, required: true },
    capability: { type: Object, required: true },
    department: { type: Object, required: true },
    academics: { type: Object, required: true },
    intellectualProperties: { type: Object, required: true },
    techLevels: { type: Object, required: true },
    economicSectors: { type: Object, required: true },
    oecdSectors: { type: Object, required: true },
});

const { processing, updateForm } = useCapability(props);
const { isOpen, open, close } = useModal();
const assessments = props.capability?.data.assessments;

</script>