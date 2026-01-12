<template>
    <div class="flex flex-col gap-5">
        <Tabs v-model="activeTab" class="space-y-4">
            <TabsList class="grid w-full grid-cols-3 gap-2 h-auto">
                <TabsTrigger v-for="tab in tabs" :key="tab.value" :value="tab.value"
                    class=" flex items-center gap-2 p-2 cursor-pointer"
                    :class="{ 'data-[state=active]:bg-red-600': tabErrors?.[tab.value] }">
                    <div class="flex items-center" :class="textClasses(tab)">
                        <p class="text-start whitespace-pre-line">{{ tab.name }}</p>
                    </div>
                </TabsTrigger>
            </TabsList>

            <TabsContent value="info">
                <TabInfo />
            </TabsContent>
            <TabsContent value="address">
                <TabAddress />
            </TabsContent>
            <TabsContent value="contact">
                <TabContact />
            </TabsContent>
        </Tabs>

        <CardBox>
            <div class="flex justify-end items-center">
                <BaseButtons>
                    <slot />
                </BaseButtons>
            </div>
        </CardBox>
    </div>
</template>

<script setup>
import { computed } from 'vue';
import { Tabs, TabsContent, TabsList, TabsTrigger } from "@/Components/ui/tabs/index.js";
import { tabs, useTabs } from '../Composables/useTabs';
import BaseButtons from '@/Components/BaseButtons.vue';
import CardBox from '@/Components/CardBox.vue';
import TabAddress from './TabAddress.vue';
import TabInfo from './TabInfo.vue';
import TabContact from './TabContact.vue';

const { activeTab, tabErrors } = useTabs();

const textClasses = computed(() => {
    return (tab) => {
        if (tabErrors.value[tab.value]) {
            return activeTab.value === tab.value ? 'text-white' : 'text-red-600';
        }
    }
});
</script>