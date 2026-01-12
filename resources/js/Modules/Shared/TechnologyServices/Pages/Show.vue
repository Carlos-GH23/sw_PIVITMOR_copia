<template>
    <HeadLogo :title="title" />
    <LayoutMain>
        <SectionTitleLineWithButton :icon="mdiCog" :title="title" main :route-back="`${routeName}index`">
            <div class="md:block hidden">
                <BaseButton :icon="mdiClose" color="lightDark" :route-name="`${routeName}index`" />
            </div>
        </SectionTitleLineWithButton>

        <Tabs v-model="activeTab" class="">
            <TabsList class="dark:bg-slate-900 grid w-full grid-cols-2 md:grid-cols-3 gap-4 h-auto">
                <TabsTrigger v-for="tab in tabs" :value="tab.value" class="flex items-center gap-2 p-2 cursor-pointer ">
                    <div class="flex items-center" :class="tab.value === activeTab ? 'text-white' : 'text-forest-400'">
                        <BaseIcon :path="tab.icon" class="w-6 h-6" />
                        <p class="text-start whitespace-pre-line">{{ tab.name }}</p>
                    </div>
                </TabsTrigger>
            </TabsList>
            <TabsContent value="info" class="py-5">
                <TabInfo has-border />
            </TabsContent>
            <TabsContent value="classifications" class="py-5">
                <TabClassification has-border />
            </TabsContent>
            <TabsContent value="resources" class="py-5">
                <TabResources has-border />
            </TabsContent>
        </Tabs>
        <CardBox>
            <BaseButtons type="justify-end">
                <BaseButton :routeName="`${routeName}index`" :icon="mdiClose" color="lightDark" label="Cancelar" />
                <BaseButton v-if="assessments?.length > 0" @click="open" :icon="mdiCommentMultiple" color="lightDark"
                    label="Evaluaciones" />
            </BaseButtons>
        </CardBox>
        <EvaluationsModal @close="close" :show="isOpen" :assessments="assessments" />
    </LayoutMain>
</template>

<script setup>
import LayoutMain from "@/Layouts/LayoutMain.vue";
import SectionTitleLineWithButton from "@/Components/SectionTitleLineWithButton.vue";
import {
    mdiClose,
    mdiCommentMultiple,
    mdiCog,
} from "@mdi/js";
import BaseButton from "@/Components/BaseButton.vue";
import HeadLogo from "@/Components/HeadLogo.vue";
import { Tabs, TabsContent, TabsList, TabsTrigger, } from "@/Components/ui/tabs/index.js";
import { useModal } from "@/Hooks/useModal";
import EvaluationsModal from '@/Components/Domains/Evaluations/EvaluationsModal.vue';
import { provide } from "vue";
import { tabsInfo } from "../Composables/useTabs";
import TabInfo from "@/Components/Domains/TechnologyServices/TabInfo.vue";
import TabClassification from "@/Components/Domains/TechnologyServices/TabClassification.vue";
import TabResources from "@/Components/Domains/TechnologyServices/TabResources.vue";
import BaseIcon from "@/Components/BaseIcon.vue";
import CardBox from "@/Components/CardBox.vue";
import BaseButtons from "@/Components/BaseButtons.vue";

const props = defineProps({
    title: {
        type: String,
        required: true,
    },
    routeName: {
        type: String,
        required: true,
    },
    service: {
        type: Object,
        required: true
    }
});

const { tabs, activeTab } = tabsInfo();
const { isOpen, open, close } = useModal();
const assessments = props.service?.data.assessments;
provide("service", props.service.data)
</script>