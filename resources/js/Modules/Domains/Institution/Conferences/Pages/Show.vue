<template>
    <HeadLogo :title="title" />
    <LayoutMain>
        <SectionTitleLineWithButton :icon="mdiAccountMultiple" :title="title" main :route-back="`${routeName}index`">
            <div class="md:block hidden">
                <BaseButton :icon="mdiClose" color="lightDark" :route-name="`${routeName}index`" />
            </div>
        </SectionTitleLineWithButton>

        <Tabs v-model="activeTab" class="">
            <TabsList class="dark:bg-slate-900 grid w-full grid-cols-2 md:grid-cols-4 gap-4 h-auto">
                <TabsTrigger v-for="tab in tabs" :value="tab.value" class="flex items-center gap-2 p-2 cursor-pointer ">
                    <div class="flex items-center" :class="tab.value === activeTab ? 'text-white' : 'text-forest-400'">
                        <BaseIcon :path="tab.icon" class="w-6 h-6" />
                        <p class="text-start whitespace-pre-line">{{ tab.name }}</p>
                    </div>
                </TabsTrigger>
            </TabsList>
            <TabsContent value="info" class="py-5">
                <InfoTab />
            </TabsContent>
            <TabsContent value="classifications" class="py-5">
                <ClassificationTab />
            </TabsContent>
            <TabsContent value="configuration" class="py-5">
                <ConfigurationTab />
            </TabsContent>
            <TabsContent value="technical_resources" class="py-5">
                <TechnicalTab />
            </TabsContent>
        </Tabs>
        <CardBox>
            <BaseButtons type="justify-end">
                <BaseButton :routeName="`${routeName}index`" :icon="mdiClose" color="lightDark" label="Cancelar" />
            </BaseButtons>
        </CardBox>
    </LayoutMain>
</template>

<script setup>
import LayoutMain from "@/Layouts/LayoutMain.vue";
import SectionTitleLineWithButton from "@/Components/SectionTitleLineWithButton.vue";
import {
    mdiClose,
    mdiAccountMultiple,
} from "@mdi/js";
import BaseButton from "@/Components/BaseButton.vue";
import HeadLogo from "@/Components/HeadLogo.vue";
import { Tabs, TabsContent, TabsList, TabsTrigger, } from "@/Components/ui/tabs/index.js";
import { provide } from "vue";
import { tabsInfo } from "../Composables/useTabs";
import InfoTab from "@/Components/Domains/Conferences/InfoTab.vue";
import ClassificationTab from "@/Components/Domains/Conferences/ClassificationTab.vue";
import ConfigurationTab from "@/Components/Domains/Conferences/ConfigurationTab.vue";
import TechnicalTab from "@/Components/Domains/Conferences/TechnicalTab.vue";
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
    conference: {
        type: Object,
        required: true
    }
});

const { tabs, activeTab } = tabsInfo();
provide("conference", props.conference.data)
provide("audienceTypes", props.conference.audienceTypes ?? [])
</script>