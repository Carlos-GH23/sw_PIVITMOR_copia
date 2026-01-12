<template>
    <Modal :show="show" @close="$emit('close')" max-width="5xl">
        <div class="p-5 max-h-[calc(100vh-10rem)] overflow-y-auto">
            <div class="mb-4">
                <div class="flex justify-between items-center">
                    <div class="flex items-center">
                        <h2 class="text-forest-400 text-xl font-bold">
                            {{ initialData.title || initialData.institution_name }}
                        </h2>
                    </div>

                    <BaseButton color="light" @click="$emit('close')" :icon="mdiClose" />
                </div>
                <span class="text-sm font-light text-slate-800 dark:text-slate-300">
                    Detalles de <span class="lowercase">{{ resourceType[initialData.resource_type] }}</span>
                </span>
            </div>

            <SkeletonContent v-if="isLoading" />

            <Tabs v-else :defaultValue="defaultTab">
                <TabsList class="grid w-full grid-cols-4 gap-2">
                    <TabsTrigger v-for="tab in currentTabs" :value="tab.value"
                        class="flex items-center gap-2 p-2 cursor-pointer">
                        <div class="flex items-center">
                            <p class="text-start whitespace-pre-line">{{ tab.name }}</p>
                        </div>
                    </TabsTrigger>
                </TabsList>

                <TabsContent v-for="tab in currentTabs" :value="tab.value" class="py-5">
                    <component :is="tab.component" :data="resultDetails" v-bind="tab.props" />
                </TabsContent>
            </Tabs>
        </div>
    </Modal>
</template>

<script setup>
import BaseButton from '@/Components/BaseButton.vue';
import Modal from '@/Components/Modal.vue';
import SkeletonContent from './SkeletonContent.vue';
import TabEntity from '@/Components/Domains/Entity/TabEntity.vue';
import { Tabs, TabsContent, TabsList, TabsTrigger } from "@/Components/ui/tabs/index.js";
import { resourceType, resourceColor } from '@/Utils/resources.js';
import { mdiClose } from '@mdi/js';
import { computed } from 'vue';
import tabsConfig from '@/Configs/tabs/index.js';

const props = defineProps({
    show: {
        type: Boolean,
        required: true,
    },
    initialData: {
        type: Object,
    },
    resultDetails: {
        type: Object,
    },
    isLoading: {
        type: Boolean,
        default: false,
    },
});

const currentTabs = computed(() => {
    const type = props.initialData?.resource_type;
    if (!type) return [];

    const tabs = [...(tabsConfig[type] || [])];
    const excludeEntityTab = ['higher_education', 'research_center', 'company', 'non_profit', 'government_agency'];

    if (!excludeEntityTab.includes(type)) {
        tabs.push({
            value: 'entity',
            name: 'Entidad',
            component: TabEntity,
            props: {
                resourceType: props.initialData.resource_type,
            }
        });
    }

    return tabs;
});

const defaultTab = 'info';
const emit = defineEmits(['close']);
</script>
