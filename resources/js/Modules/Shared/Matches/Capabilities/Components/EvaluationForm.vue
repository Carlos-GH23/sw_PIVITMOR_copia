<template>
    <DialogModal :show="show" @close="close" max-width="5xl">
        <template #title>
            <div class="sticky -top-1 bg-white z-10 mb-4">
                <h3 class="text-base text-forest-400 font-semibold">Vinculación de capacidad con necesidad</h3>
                <span class="text-sm text-gray-500">
                    Acepta o rechaza la vinculación de la capacidad tecnológica con la necesidad tecnológica.
                </span>
            </div>
        </template>

        <template #content>

            <Tabs defaultValue="info">
                <TabsList class="dark:bg-slate-900 grid w-full grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 h-auto">
                    <TabsTrigger v-for="tab in tabs" :value="tab.value"
                        class="flex items-center gap-2 p-2 cursor-pointer">
                        <div class="flex items-center">
                            <p class="text-start whitespace-pre-line">{{ tab.name }}</p>
                        </div>
                    </TabsTrigger>
                </TabsList>

                <TabsContent value="info" class="py-5 max-h-[650px] overflow-y-auto">
                    <TabInfo />
                </TabsContent>

                <TabsContent value="classifications" class="py-5 max-h-[650px] overflow-y-auto">
                    <TabClassification />
                </TabsContent>

                <TabsContent value="resources" class="py-5 max-h-[650px] overflow-y-auto">
                    <TabImages />
                </TabsContent>

                <TabsContent value="entity" class="py-5 max-h-[650px] overflow-y-auto">
                    <TabEntity :data="match?.requirement.entity" />
                </TabsContent>
            </Tabs>
        </template>

        <template #footer>
            <BaseButtons>
                <BaseButton label="Aceptar" color="success" :disabled="!disableButtons" :icon="mdiCheck"
                    @click="onAccept" />
                <BaseButton label="Rechazar" color="danger" :disabled="!disableButtons" :icon="mdiClose"
                    @click="onReject" />
            </BaseButtons>
        </template>
    </DialogModal>
</template>
<script setup>
import BaseButton from '@/Components/BaseButton.vue';
import BaseButtons from "@/Components/BaseButtons.vue";
import DialogModal from '@/Components/DialogModal.vue';
import TabClassification from '@/Components/Domains/Requirements/TabClassification.vue';
import TabEntity from '@/Components/Domains/Entity/TabEntity.vue';
import TabImages from '@/Components/Domains/Requirements/TabImages.vue';
import TabInfo from '@/Components/Domains/Requirements/TabInfo.vue';
import { computed, provide } from 'vue';
import { mdiCheck, mdiClose } from "@mdi/js";
import { Tabs, TabsContent, TabsList, TabsTrigger, } from "@/Components/ui/tabs/index.js";
import { tabs } from './tabs';
import { verifyPermission } from '@/Hooks/usePermissions.js';

const props = defineProps({
    show: {
        type: Boolean,
        default: false,
    },
    match: {
        type: Object,
    },
    onAccept: {
        type: Function,
        required: true
    },
    onReject: {
        type: Function,
        required: true
    }
})

const emit = defineEmits(['close']);
const close = () => {
    emit('close')
};

const disableButtons = computed(() => {
    return verifyPermission('capabilities.matches.store') && props.match.match_status_id === 2;
});

provide('requirement', computed(() => props.match?.requirement));
</script>