<template>
    <HeadLogo :title="title" />
    <LayoutMain>
        <SectionTitleLineWithButton :icon="mdiPlus" :title="title" main :routeBack="`${routeName}index`">
            <div class="md:block hidden">
                <BaseButton :icon="mdiClose" color="lightDark" :routeName="`${routeName}index`"
                    :parameter="capability.id" />
            </div>
        </SectionTitleLineWithButton>

        <Tabs defaultValue="info">
            <TabsList class="dark:bg-slate-900 grid w-full grid-cols-2 lg:grid-cols-3 gap-4 h-auto">
                <TabsTrigger v-for="tab in tabs" :key="tab.value" :value="tab.value"
                    class="flex items-center gap-2 p-2 cursor-pointer">
                    <p class="text-start whitespace-pre-line">{{ tab.name }}</p>
                </TabsTrigger>
            </TabsList>

            <TabsContent value="info" class="py-5">
                <InfoTab />
            </TabsContent>

            <TabsContent value="classifications" class="py-5">
                <ClassificationTab />
            </TabsContent>

            <TabsContent value="resources" class="py-5">
                <ResourcesTab />
            </TabsContent>
        </Tabs>

        <CardBox>
            <div class="md:flex justify-end items-center md:space-y-0 space-y-2">
                <BaseButtons>
                    <BaseButton :routeName="`${routeName}index`" :icon="mdiArrowLeft" color="lightDark"
                        label="Regresar" />
                    <BaseButton v-if="capability.data.assessments?.length > 0" @click="open" :icon="mdiCommentMultiple"
                        color="lightDark" label="Evaluaciones" />
                </BaseButtons>
            </div>
        </CardBox>

        <EvaluationsModal @close="close" :show="isOpen" :assessments="assessments" />
    </LayoutMain>
</template>

<script setup>
import BaseButton from "@/Components/BaseButton.vue";
import BaseButtons from "@/Components/BaseButtons.vue";
import CardBox from "@/Components/CardBox.vue";
import ClassificationTab from "@/Components/Domains/Capabilities/ClassificationTab.vue";
import EvaluationsModal from '@/Components/Domains/Evaluations/EvaluationsModal.vue';
import HeadLogo from "@/Components/HeadLogo.vue";
import InfoTab from "@/Components/Domains/Capabilities/InfoTab.vue";
import LayoutMain from "@/Layouts/LayoutMain.vue";
import SectionTitleLineWithButton from "@/Components/SectionTitleLineWithButton.vue";
import ResourcesTab from "@/Components/Domains/Capabilities/ResourcesTab.vue";
import { Tabs, TabsContent, TabsList, TabsTrigger, } from "@/Components/ui/tabs/index.js";
import { mdiArrowLeft, mdiClose, mdiCommentMultiple, mdiPlus } from "@mdi/js";
import { provide } from "vue";
import { useModal } from '@/Hooks/useModal';

const props = defineProps({
    title: {
        type: String,
        required: true,
    },
    capability: {
        type: Object,
        required: true
    },
    routeName: {
        type: String,
        required: true,
    },
});

const tabs = [
    {
        value: "info",
        name: "Información general",
    },
    {
        value: "classifications",
        name: "Clasificación",
    },
    {
        value: "resources",
        name: "Recursos",
    },
];

const assessments = props.capability.data?.assessments;
const { isOpen, open, close } = useModal();

provide('capability', props.capability.data);
</script>