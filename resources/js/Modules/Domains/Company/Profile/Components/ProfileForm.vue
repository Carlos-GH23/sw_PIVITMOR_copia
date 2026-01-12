<template>
    <div class="flex flex-col gap-5">
        <Tabs v-model="activeTab" class="">
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
            <TabsContent value="info" class="py-5">
                <TabGeneral />
            </TabsContent>
            <TabsContent value="location" class="py-5">
                <TabLocation />
            </TabsContent>
            <TabsContent value="contact" class="py-5">
                <TabContact />
            </TabsContent>
            <TabsContent value="reniecyt" class="py-5">
                <TabReniecyt />
            </TabsContent>
            <TabsContent value="technology" class="py-5">
                <TabCompanyTechnology />
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
import BaseIcon from '@/Components/BaseIcon.vue';
import TabGeneral from './TabGeneral.vue';
import TabLocation from './TabLocation.vue';
import TabContact from './TabContact.vue';
import TabReniecyt from './TabReniecyt.vue';
import TabCompanyTechnology from './TabCompanyTechnology.vue';
import { Tabs, TabsContent, TabsList, TabsTrigger, } from "@/Components/ui/tabs/index.js";
import { tabs, useTabs } from '../Composables/useTabs';
import { computed } from 'vue';
import CardBox from '@/Components/CardBox.vue';
import BaseButtons from '@/Components/BaseButtons.vue';

const { activeTab, tabErrors } = useTabs();

const textClasses = computed(() => {
    return (tab) => {
        if (tabErrors.value[tab.value]) {
            return activeTab.value === tab.value ? 'text-white' : 'text-red-600';
        }
    }
});
</script>
