<template>
    <HeadLogo :title="title" />
    <LayoutMain>
        <SectionTitleLineWithButton :icon="mdiPlus" :title="title" main :route-back="`${routeName}index`">
            <div class="md:block hidden">
                <BaseButton :icon="mdiClose" color="lightDark" :route-name="`${routeName}index`"
                    :parameter="technologyService.id" />
            </div>
        </SectionTitleLineWithButton>
        
        <div class="flex flex-col lg:flex-row gap-4 mb-5">
            <div class="p-2 w-full lg:w-8/12 order-2 lg:order-1">
                <TechnologyServiceInfo />
            </div>

            <div class="w-full lg:w-4/12 order-1 lg:order-2  self-start space-y-4">
                <EvaluationForm @evaluate="storeForm" :form="form" :routeName="routeName"/>

                <EvaluationLog />
            </div>
        </div>
    </LayoutMain>
</template>

<script setup>
import BaseButton from "@/Components/BaseButton.vue";
import HeadLogo from "@/Components/HeadLogo.vue";
import TechnologyServiceInfo from "../Components/TechnologyServiceInfo.vue";
import EvaluationForm from "../Components/EvaluationForm.vue";
import EvaluationLog from "../Components/EvaluationLog.vue";
import LayoutMain from "@/Layouts/LayoutMain.vue";
import SectionTitleLineWithButton from "@/Components/SectionTitleLineWithButton.vue";
import {
    mdiClose,
    mdiPlus,
} from "@mdi/js";
import { useEvaluation } from "../Composables/useEvaluation";

const props = defineProps({
    title: {
        type: String,
        required: true,
    },
    technologyService: {
        type: Object,
        required: true
    },
    routeName: {
        type: String,
        required: true,
    },
});

const { form, storeForm } = useEvaluation(props);
</script>
