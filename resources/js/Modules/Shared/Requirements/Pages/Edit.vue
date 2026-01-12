<template>
    <HeadLogo :title="title" />
    <loading v-model:active="processing" :can-cancel="false" :is-full-page="true" loader="dots" color="#283C2A" />
    <LayoutMain>
        <SectionTitleLineWithButton :icon="mdiPlus" :title="title" main :route-back="`${routeName}index`">
            <div class="md:block hidden">
                <BaseButton :icon="mdiClose" color="lightDark" :route-name="`${routeName}index`" />
            </div>
        </SectionTitleLineWithButton>

        <RequirementForm>
            <template #actions>
                <BaseButton :routeName="`${routeName}index`" :icon="mdiClose" color="lightDark" label="Cancelar" />
                <BaseButton v-if="assessments?.length > 0" @click="open" :icon="mdiCommentMultiple" color="lightDark"
                    label="Evaluaciones" />
                <BaseButton @click="updateForm(true)" :icon="mdiContentSave" color="lightDark"
                    label="Actualizar borrador" />
                <BaseButton @click="updateForm(false)" :icon="mdiSend" color="success" label="Enviar" />
            </template>
        </RequirementForm>

        <EvaluationsModal @close="close" :show="isOpen" :assessments="assessments" />
    </LayoutMain>
</template>
<script setup>
import LayoutMain from "@/Layouts/LayoutMain.vue";
import SectionTitleLineWithButton from "@/Components/SectionTitleLineWithButton.vue";
import {
    mdiClose,
    mdiCommentMultiple,
    mdiContentSave,
    mdiPlus,
    mdiSend,
} from "@mdi/js";
import BaseButton from "@/Components/BaseButton.vue";
import HeadLogo from "@/Components/HeadLogo.vue";
import RequirementForm from "../Components/RequirementForm.vue";
import { useRequirement } from "../Composables/useRequirement";
import { provide } from "vue";
import { useModal } from "@/Hooks/useModal";
import EvaluationsModal from '@/Components/Domains/Evaluations/EvaluationsModal.vue';

const props = defineProps({
    title: {
        type: String,
        required: true,
    },
    department: {
        type: Object,
        default: () => ({}),
    },
    intellectuals: {
        type: Object,
        default: () => ({}),
    },
    technologies: {
        type: Object,
        default: () => ({}),
    },
    oecdSectors: {
        type: Object,
        default: () => ({}),
    },
    economicSectors: {
        type: Object,
        default: () => ({}),
    },
    routeName: {
        type: String,
        required: true,
    },
    requirement: {
        type: Object,
        required: true
    }
});

const { isOpen, open, close } = useModal();
const assessments = props.requirement?.data.assessments;

const { updateForm, processing } = useRequirement(props);
provide("props", props)

</script>