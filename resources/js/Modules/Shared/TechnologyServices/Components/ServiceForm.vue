<template>
    <Tabs v-model="activeTab">
        <TabsList class="grid w-full grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 h-auto">
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
        <TabsContent value="application" class="py-4">
            <ApplicationTab />
        </TabsContent>
        <TabsContent value="classifications" class="py-4">
            <ClassificationTab />
        </TabsContent>
        <TabsContent value="resources" class="py-4">
            <ResourceTab :academics="props.academics" />
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
import ApplicationTab from './ApplicationTab.vue';
import ClassificationTab from './ClassificationTab.vue';
import ResourceTab from './ResourceTab.vue';
import ConfirmationTab from './ConfirmationTab.vue';
import { computed } from 'vue';

const props = defineProps({
    service: { type: Object, required: true },
    serviceTypes: { type: Array, required: true },
    serviceCategories: { type: Array, required: true },
    activities: { type: Array, required: false, default: () => [] },
    oecdSectors: { type: Array, required: false, default: () => [] },
    economicSectors: { type: Array, required: false, default: () => [] },
    academics: { type: Array, required: true },
});

const { activeTab, step, tabErrors } = useTabs();

const textClasses = computed(() => {
    return (tab) => {
        if (tabErrors.value?.[tab.value]) {
            return activeTab.value === tab.value ? 'text-white' : 'text-red-600';
        }
        return '';
    };
});
</script>