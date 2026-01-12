<template>
    <Tabs v-model="activeTab">
        <TabsContent value="research" class="py-5">
            <TabInfo />
        </TabsContent>
    </Tabs>

    <CardBox>
        <div class="flex justify-end items-center space-x-2">
            <BaseButtons>
                <slot name="actions" />
            </BaseButtons>
        </div>
    </CardBox>
</template>

<script setup>
import BaseButtons from "@/Components/BaseButtons.vue";
import { Tabs, TabsContent } from "@/Components/ui/tabs/index.js";
import TabInfo from './TapInfo.vue';
import CardBox from '@/Components/CardBox.vue';
import { useResearchLineTabs } from "../Composables/useTabs.js";

const { activeTab } = useResearchLineTabs();
</script>