<template>
    <Tabs v-model="activeTab">
        <TabsContent value="academic" class="py-5">
            <TabAcademicBody />
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
import TabAcademicBody from './TabAcademicBody.vue';
import CardBox from '@/Components/CardBox.vue';
import { useAcademicGroupTabs } from "../Composables/useTabs.js";

const { activeTab } = useAcademicGroupTabs();
</script>
