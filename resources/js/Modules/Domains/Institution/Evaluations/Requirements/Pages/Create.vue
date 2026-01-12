<template>
    <HeadLogo :title="title" />
    <LayoutMain>
        <SectionTitleLineWithButton :icon="mdiCheckDecagram" :title="title" main :route-back="`${routeName}index`">
            <div class="md:block hidden">
                <BaseButton :icon="mdiClose" color="lightDark" :route-name="`${routeName}index`" />
            </div>
        </SectionTitleLineWithButton>

        <div class="flex flex-col lg:flex-row gap-4 mb-5">
            <div class="w-full lg:w-8/12 order-2 lg:order-1">
                <RequirementTabs />
            </div>
            <div class="w-full lg:w-4/12 order-1 lg:order-2  self-start space-y-4">
                <EvaluationForm :requirement="requirement.data" />
                <EvaluationLog :assessments="requirement.data.assessments" />
            </div>
        </div>
    </LayoutMain>
</template>
<script setup>
import LayoutMain from "@/Layouts/LayoutMain.vue";
import SectionTitleLineWithButton from "@/Components/SectionTitleLineWithButton.vue";
import {
    mdiClose,
    mdiCheckDecagram,
} from "@mdi/js";
import BaseButton from "@/Components/BaseButton.vue";
import HeadLogo from "@/Components/HeadLogo.vue";
import CardBox from "@/Components/CardBox.vue";
import RequirementTabs from "../Components/RequirementTabs.vue";
import { provide } from "vue";
import EvaluationForm from "../Components/EvaluationForm.vue";
import EvaluationLog from "../Components/EvaluationLog.vue";

const props = defineProps({
    title: {
        type: String,
        required: true,
    },
    requirement: {
        type: Object,
        required: true
    },
    routeName: {
        type: String,
        required: true,
    },
});

provide("requirement", props.requirement.data)
</script>