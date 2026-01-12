<template>
    <Tabs v-model="activeTab" class="space-y-6">
        <TabsList class="grid w-full grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-2 h-auto">
            <TabsTrigger v-for="tab in tabs" :key="tab.value" :value="tab.value"
                class=" flex items-center gap-2 p-2 cursor-pointer"
                :class="[tabErrors[tab.value] ? 'data-[state=active]:bg-red-600' : 'data-[state=active]:bg-forest-400']">
                <div class="flex items-center" :class="textClasses(tab)">
                    <BaseIcon :path="tab.icon" class="w-6 h-6" />
                    <p class="text-start whitespace-pre-line">{{ tab.name }}</p>
                </div>
            </TabsTrigger>
        </TabsList>
        <TabsContent value="info">
            <InformationTab />
        </TabsContent>
        <TabsContent value="address">
            <AddressTab />
        </TabsContent>
        <TabsContent value="contact">
            <ContactTab />
        </TabsContent>
        <TabsContent value="register">
            <RegisterTab />
        </TabsContent>
        <TabsContent value="clasification" class="py-5">
            <ClasificationTab />
        </TabsContent>
    </Tabs>

    <CardBox>
        <div class="md:flex justify-between items-center md:space-y-0 space-y-2">
            <div>
                <p class="text-sm text-gray-600">
                    Paso <strong>{{ step + 1 }}</strong> de <strong>{{ tabs.length }}</strong>
                </p>
            </div>
            <BaseButtons>
                <slot />
            </BaseButtons>
        </div>
    </CardBox>
</template>

<script setup>
import { computed } from 'vue';
import { Tabs, TabsContent, TabsList, TabsTrigger } from "@/Components/ui/tabs/index.js";
import { tabs, useTabs } from '../Composables/useTabs';
import BaseButtons from '@/Components/BaseButtons.vue';
import BaseIcon from '@/Components/BaseIcon.vue';
import CardBox from '@/Components/CardBox.vue';
import InformationTab from './InformationTab.vue';
import AddressTab from './AddressTab.vue';
import ContactTab from './ContactTab.vue';
import RegisterTab from './RegisterTab.vue';
import ClasificationTab from './ClasificationTab.vue';

const { activeTab, step, tabErrors } = useTabs();

const textClasses = computed(() => {
    return (tab) => {
        if (tabErrors.value[tab.value]) {
            return activeTab.value === tab.value ? 'text-white' : 'text-red-600';
        }
    }
});
</script>