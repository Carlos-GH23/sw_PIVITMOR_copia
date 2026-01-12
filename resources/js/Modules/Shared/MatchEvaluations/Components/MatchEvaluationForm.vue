<template>
    <Tabs v-model="activeTab" class="">
        <TabsList class="dark:bg-slate-900 grid w-full grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 h-auto">
            <TabsTrigger v-for="tab in tabs" :value="tab.value" class=" flex items-center gap-2 p-2 cursor-pointer"
                :class="{ 'data-[state=active]:bg-red-600': tabErrors?.[tab.value] }">
                <div class="flex items-center" :class="textClasses(tab)">
                    <BaseIcon :path="tab.icon" class="w-6 h-6" />
                    <p class="text-start whitespace-pre-line">{{ tab.name }}</p>
                </div>
            </TabsTrigger>
        </TabsList>

        <TabsContent value="info" class="py-5">
            <TabInfo />
        </TabsContent>
        <TabsContent value="story" class="py-5">
            <TabStory />
        </TabsContent>
        <TabsContent value="metrics" class="py-5">
            <TabMetrics />
        </TabsContent>
        <TabsContent value="confirmation" class="py-5">
            <TabConfirmation />
        </TabsContent>
    </Tabs>
    <CardBox>
        <div class="md:flex justify-between items-center md:space-y-0 space-y-2">
            <div>
                Paso <strong>{{ step + 1 }}</strong> de <strong>{{ tabs.length }}</strong>
            </div>
            <BaseButtons>
                <slot name="actions" />
            </BaseButtons>
        </div>
    </CardBox>
</template>
<script setup>
import BaseButtons from '@/Components/BaseButtons.vue';
import { Tabs, TabsContent, TabsList, TabsTrigger, } from "@/Components/ui/tabs/index.js";
import { tabs, useRequirementTabs } from '../Composables/useTabs';
import CardBox from '@/Components/CardBox.vue';
import BaseIcon from '@/Components/BaseIcon.vue';
import { computed, inject } from 'vue';
import TabInfo from './TabInfo.vue';
import TabStory from './TabStory.vue';
import TabConfirmation from './TabConfirmation.vue';
import TabMetrics from './TabMetrics.vue';

const { activeTab, tabErrors, step } = useRequirementTabs();

const textClasses = computed(() => {
    return (tab) => {
        if (tabErrors.value?.[tab.value]) {
            return activeTab.value === tab.value ? 'text-white' : 'text-red-600';
        }
    }
});
</script>