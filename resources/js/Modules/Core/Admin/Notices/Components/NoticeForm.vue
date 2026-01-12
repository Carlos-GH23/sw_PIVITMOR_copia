<template>
    <Tabs v-model="activeTab" class="w-full">
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
            <InfoTab />
        </TabsContent>

        <TabsContent value="content" class="py-5">
            <ContentTab />
        </TabsContent>

        <TabsContent value="multimedia" class="py-5">
            <MultimediaTab />
        </TabsContent>

        <TabsContent value="metadata" class="py-5">
            <MetadataTab />
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
import ContentTab from './ContentTab.vue';
import MultimediaTab from './MultimediaTab.vue';
import MetadataTab from './MetadataTab.vue';
import { Tabs, TabsContent, TabsList, TabsTrigger } from "@/Components/ui/tabs/index.js";
import { tabs, useTabs } from '../Composables/useTabs';
import { computed } from 'vue';

const { activeTab, step, tabErrors } = useTabs();

const textClasses = computed(() => {
    return (tab) => {
        if (tabErrors.value?.[tab.value]) {
            return activeTab.value === tab.value ? 'text-white' : 'text-red-600';
        }
    }
});
</script>