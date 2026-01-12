<template>
    <HeadLogo :title="title" />
    <LayoutMain>
        <SectionTitleLineWithButton :icon="mdiFileDocument" :title="title" main :route-back="`${routeName}index`">
            <div class="md:block hidden">
                <BaseButton :icon="mdiClose" color="lightDark" :route-name="`${routeName}index`" />
            </div>
        </SectionTitleLineWithButton>

        <MatchEvaluationForm>
            <template #actions>
                <BaseButton :routeName="`${routeName}index`" :icon="mdiClose" color="lightDark" label="Cancelar" />
            </template>
        </MatchEvaluationForm>
    </LayoutMain>
</template>
<script setup>
import LayoutMain from "@/Layouts/LayoutMain.vue";
import SectionTitleLineWithButton from "@/Components/SectionTitleLineWithButton.vue";
import {
    mdiClose,
    mdiFileDocument,
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

useMatchEvaluation(props);
provide("props", props)
</script>