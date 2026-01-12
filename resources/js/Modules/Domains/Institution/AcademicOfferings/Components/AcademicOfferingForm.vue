<template>
    <Tabs v-model="activeTab" class="w-full">
        <TabsList class="dark:bg-slate-900 grid w-full grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4 h-auto">
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
        <TabsContent value="accreditations" class="py-5">
            <TabAccreditations />
        </TabsContent>
        <TabsContent value="classification" class="py-5">
            <TabClassification />
        </TabsContent>
        <TabsContent value="resources" class="py-5">
            <TabResources />
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
import { computed } from 'vue';
import { Tabs, TabsContent, TabsList, TabsTrigger, } from "@/Components/ui/tabs/index.js";
import CardBox from '@/Components/CardBox.vue';
import BaseIcon from '@/Components/BaseIcon.vue';
import TabInfo from './TabInfo.vue';
import TabAccreditations from './TabAccreditations.vue';
import TabClassification from './TabClassification.vue';
import TabResources from './TabResources.vue';
import TabConfirmation from './TabConfirmation.vue';
import { tabs, useTabs } from '../Composables/useTabs';
import BaseButtons from '@/Components/BaseButtons.vue';

const { activeTab, step, tabErrors } = useTabs();


const emit = defineEmits(['next-tab', 'prev-tab']);

const textClasses = computed(() => {
    return (tab) => {
        if (tabErrors.value?.[tab.value]) {
            return activeTab.value === tab.value ? 'text-white' : 'text-red-600';
        }
    }
});

</script>
