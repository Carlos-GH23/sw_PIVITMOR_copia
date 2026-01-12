<template>
    <Tabs default-value="info">
        <TabsList class="dark:bg-slate-900 grid w-full grid-cols-2 lg:grid-cols-3 gap-4 h-auto">
            <TabsTrigger v-for="tab in tabs" :key="tab.value" :value="tab.value"
                class="flex items-center gap-2 p-2 cursor-pointer">
                <p class="text-start whitespace-pre-line">{{ tab.name }}</p>
            </TabsTrigger>
        </TabsList>

        <TabsContent value="info" class="py-5">
            <InfoTab />
        </TabsContent>

        <TabsContent value="classifications" class="py-5">
            <ClassificationTab />
        </TabsContent>

        <TabsContent value="resources" class="py-5">
            <ResourcesTab />
        </TabsContent>
    </Tabs>
</template>

<script setup>
import InfoTab from "./InfoTab.vue";
import ClassificationTab from "./ClassificationTab.vue";
import ResourcesTab from "./ResourcesTab.vue";
import { Tabs, TabsContent, TabsList, TabsTrigger, } from "@/Components/ui/tabs/index.js";
import { useTabs } from '../Composables/useTabs';

const { activeTab, tabs } = useTabs();
</script>
