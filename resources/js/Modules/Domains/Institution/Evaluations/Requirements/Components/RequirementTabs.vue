<template>
    <Tabs v-model="activeTab" class="">
        <TabsList class="dark:bg-slate-900 grid w-full grid-cols-2 md:grid-cols-3 gap-4 h-auto">
            <TabsTrigger v-for="tab in tabs" :value="tab.value" class="flex items-center gap-2 p-2 cursor-pointer ">
                <div class="flex items-center" :class="tab.value === activeTab ? 'text-white' : 'text-forest-400'">
                    <BaseIcon :path="tab.icon" class="w-6 h-6" />
                    <p class="text-start whitespace-pre-line">{{ tab.name }}</p>
                </div>
            </TabsTrigger>
        </TabsList>
        <TabsContent value="info" class="py-5">
            <TabInfo />
        </TabsContent>
         <TabsContent value="clasifications" class="py-5">
            <TabClassification />
        </TabsContent>
        <TabsContent value="images" class="py-5">
            <TabImages />
        </TabsContent>
    </Tabs>
</template>
<script setup>
import { Tabs, TabsContent, TabsList, TabsTrigger, } from "@/Components/ui/tabs/index.js";
import BaseIcon from "@/Components/BaseIcon.vue";
import { useRequirementTabs } from "../Composables/useTabs";
import TabInfo from "@/Components/Domains/Requirements/TabInfo.vue";
import TabClassification from "@/Components/Domains/Requirements/TabClassification.vue";
import TabImages from "@/Components/Domains/Requirements/TabImages.vue";

const { tabs, activeTab } = useRequirementTabs();
</script>