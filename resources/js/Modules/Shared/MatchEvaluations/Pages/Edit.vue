<template>
    <HeadLogo :title="title" />
    <loading v-model:active="processing" :can-cancel="false" :is-full-page="true" loader="dots" color="#283C2A" />
    <LayoutMain>
        <SectionTitleLineWithButton :icon="mdiPlus" :title="title" main :route-back="routeBack">
            <div class="md:block hidden">
                <BaseButton :icon="mdiClose" color="lightDark" :route-name="routeBack" />
            </div>
        </SectionTitleLineWithButton>

        <MatchEvaluationForm>
            <template #actions>
                <BaseButton :routeName="routeBack" :icon="mdiClose" color="lightDark" label="Cancelar" />
                <BaseButton @click="updateForm(true)" :icon="mdiContentSave" color="lightDark"
                    label="Actualizar borrador" />
                <BaseButton @click="updateForm(false)" :icon="mdiSend" color="success" label="Enviar" />
            </template>
        </MatchEvaluationForm>
    </LayoutMain>
</template>
<script setup>
import LayoutMain from "@/Layouts/LayoutMain.vue";
import SectionTitleLineWithButton from "@/Components/SectionTitleLineWithButton.vue";
import {
    mdiClose,
    mdiContentSave,
    mdiPlus,
    mdiSend,
} from "@mdi/js";
import BaseButton from "@/Components/BaseButton.vue";
import HeadLogo from "@/Components/HeadLogo.vue";
import MatchEvaluationForm from "../Components/MatchEvaluationForm.vue";
import { useMatchEvaluation } from "../Composables/useMatchEvaluation";
import { provide } from "vue";

const props = defineProps({
    title: {
        type: String,
        required: true,
    },
    routeName: {
        type: String,
        required: true,
    },
    routeBack: {
        type: String,
        required: true,
    },
    categories: {
        type: Object,
        default: () => ({}),
    },
    matchEvaluation: {
        type: Object,
        required: true,
    },
    capabilityRequirementMatch: {
        type: Object,
        required: true,
    },
    actors: {
        type: Object,
        required: true,
    },
    impactMetrics: {
        type: Object,
        required: true,
    },
    technologyLevels: {
        type: Object,
        required: true,
    },
    academicOfferings: {
        type: Object,
        required: true,
    },
    matchEvaluationStatuses: {
        type: Object,
        default: () => ({}),
    },
    allowedImpactMetrics: {
        type: Object,
        required: true,
    },
});

const { updateForm, processing } = useMatchEvaluation(props);
provide("props", props)
</script>