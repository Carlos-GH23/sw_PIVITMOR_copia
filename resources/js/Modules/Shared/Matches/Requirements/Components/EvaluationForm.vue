<template>
    <DialogModal :show="show" @close="close" max-width="5xl">
        <template #title>
            <div class="sticky -top-1 bg-white z-10 mb-4">
                <h3 class="text-base text-forest-400 font-semibold">Vinculación de necesidad con capacidad</h3>
                <span class="text-sm text-gray-500">
                    Acepta o rechaza la vinculación de la necesidad tecnológica con la capacidad tecnológica.
                </span>
            </div>
        </template>
        <template #content>
            <Tabs v-if="capability" v-model="activeTab">
                <TabsList class="dark:bg-slate-900 grid w-full grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 h-auto">
                    <TabsTrigger v-for="tab in tabs" :value="tab.value"
                        class="flex items-center gap-2 p-2 cursor-pointer">
                        <div class="flex items-center"
                            :class="tab.value === activeTab ? 'text-white' : 'text-forest-400'">
                            <BaseIcon :path="tab.icon" class="w-6 h-6" />
                            <p class="text-start whitespace-pre-line">{{ tab.name }}</p>
                        </div>
                    </TabsTrigger>
                </TabsList>
                <TabsContent value="info" class="py-5 max-h-[650px] overflow-y-auto">
                    <InfoTab />
                </TabsContent>
                <TabsContent value="clasifications" class="py-5 max-h-[650px] overflow-y-auto">
                    <ClassificationTab />
                </TabsContent>
                <TabsContent value="resources" class="py-5 max-h-[650px] overflow-y-auto">
                    <ResourcesTab />
                </TabsContent>
                <TabsContent value="institution" class="py-5 max-h-[650px] overflow-y-auto">
                    <TabEntity :data="capability?.entity" />
                </TabsContent>
            </Tabs>
            <loading v-model:active="isLoading" :can-cancel="false" :is-full-page="false" loader="dots"
                color="#283C2A" />
        </template>
        <template #footer>
            <BaseButtons>
                <BaseButton :disabled="!disableButtons" label="Aceptar" color="success" :icon="mdiCheck"
                    @click="acceptForm()" />
                <BaseButton :disabled="!disableButtons" label="Rechazar" color="danger" :icon="mdiClose"
                    @click="rejectForm" />
            </BaseButtons>
        </template>
    </DialogModal>
</template>
<script setup>
import { Tabs, TabsContent, TabsList, TabsTrigger, } from "@/Components/ui/tabs/index.js";
import InfoTab from "@/Components/Domains/Capabilities/InfoTab.vue";
import ClassificationTab from "@/Components/Domains/Capabilities/ClassificationTab.vue";
import ResourcesTab from "@/Components/Domains/Capabilities/ResourcesTab.vue";
import BaseIcon from '@/Components/BaseIcon.vue';
import { provide, watch } from 'vue';
import DialogModal from '@/Components/DialogModal.vue';
import BaseButton from '@/Components/BaseButton.vue';
import { useRequirementTabs } from "../Composables/useTabs";
import BaseButtons from "@/Components/BaseButtons.vue";
import { mdiCheck, mdiClose } from "@mdi/js";
import { useMatch } from "../Composables/useRequirementMatch";
import TabEntity from "@/Components/Domains/Entity/TabEntity.vue";

const props = defineProps({
    show: {
        type: Boolean,
        default: false,
    },
    matchId: {
        type: Number,
        default: null,
    },
    routeName: {
        type: String,
        required: true,
    },
})

const { tabs, activeTab } = useRequirementTabs();
const emit = defineEmits(['close'])
const close = () => emit('close')
const { capability, isLoading, fetchMatch, acceptForm, rejectForm, disableButtons } = useMatch(props.routeName, close)

watch(() => props.show, (show) => {
    if (show && props.matchId) {
        fetchMatch(props.matchId)
    }
})

provide('capability', capability)
</script>