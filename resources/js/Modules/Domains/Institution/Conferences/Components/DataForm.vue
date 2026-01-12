
<template>
    <Tabs v-model="activeTab">
    <TabsList class="grid w-full grid-cols-2 md:grid-cols-5 lg:grid-cols-5 gap-4 h-auto">
            <TabsTrigger v-for="tab in tabs" :key="tab.value" :value="tab.value"
                class="flex items-center gap-2 p-2 cursor-pointer"
                :class="{ 'data-[state=active]:bg-red-600': tabErrors?.[tab.value] }">
                <div class="flex items-center" :class="textClasses(tab)">
                    <BaseIcon :path="tab.icon" class="w-6 h-6" />
                    <p class="text-start whitespace-pre-line">{{ tab.name }}</p>
                </div>
            </TabsTrigger>
        </TabsList>

        <TabsContent value="info" class="py-4">
            <InfoTab />
        </TabsContent>
        <TabsContent value="classifications" class="py-4">
            <ClassificationTab />
        </TabsContent>
        <TabsContent value="configuration" class="py-4">
            <ConfigurationTab />
        </TabsContent>
        <TabsContent value="technical_resources" class="py-4">
            <TechnicalTab />
        </TabsContent>
        <TabsContent value="confirmation" class="py-4">
            <ConfirmationTab />
        </TabsContent>
    </Tabs>

    <CardBox>
        <div class="md:flex justify-between items-center md:space-y-0 space-y-2">
            <div>
                Paso <strong>{{ step + 1 }}</strong> de <strong>{{ tabs.length }}</strong>
            </div>
            <BaseButtons>
                <slot />
            </BaseButtons>
        </div>
    </CardBox>
</template>

<script setup>
import BaseButtons from '@/Components/BaseButtons.vue';
import BaseIcon from '@/Components/BaseIcon.vue';
import CardBox from '@/Components/CardBox.vue';
import InfoTab from './InfoTab.vue';
import { Tabs, TabsContent, TabsList, TabsTrigger } from "@/Components/ui/tabs/index.js";
import { tabs, useTabs } from '../Composables/useTabs';
import ConfigurationTab from './ConfigurationTab.vue';
import ClassificationTab from './ClassificationTab.vue';
import TechnicalTab from './TechnicalTab.vue';
import ConfirmationTab from './ConfirmationTab.vue';
import { computed, provide } from 'vue';

const props = defineProps({
    oecdSectors: { type: Array, required: false, default: () => [] },
    economicSectors: { type: Array, required: false, default: () => [] },
    knowledgeAreas: { type: Array, required: false, default: () => [] },
    departments: { type: Array, required: false, default: () => [] },
    academics: { type: Array, required: false, default: () => [] },
    audienceTypes: { type: Array, required: false, default: () => [] },
    modality: { type: Array, required: false, default: () => [] },
    languages: { type: Array, required: false, default: () => [] },
});

const { activeTab, step, tabErrors } = useTabs();

provide('departments', props.departments);
provide('academics', props.academics);
provide('oecdSectors', props.oecdSectors);
provide('economicSectors', props.economicSectors);
provide('knowledgeAreas', props.knowledgeAreas);
provide('audienceTypes', props.audienceTypes);
provide('modality', props.modality);
provide('languages', props.languages);

const textClasses = computed(() => {
    return (tab) => {
        if (tabErrors.value?.[tab.value]) {
            return activeTab.value === tab.value ? 'text-white' : 'text-red-600';
        }
        return '';
    };
});
</script>