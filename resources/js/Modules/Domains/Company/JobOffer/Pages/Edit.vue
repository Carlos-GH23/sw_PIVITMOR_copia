<template>
    <HeadLogo title="Editar oferta laboral" />
    <LayoutMain>
        <SectionTitleLineWithButton :icon="mdiPencil" :title="title" main :routeBack="`${routeName}index`">
            <div class="md:block hidden">
                <BaseButton :icon="mdiClose" color="lightDark" :routeName="`${routeName}index`" />
            </div>
        </SectionTitleLineWithButton>
        <Tabs v-model="activeTab" class="">
            <TabsList class="dark:bg-slate-900 grid w-full grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 h-auto">
                <TabsTrigger v-for="tab in tabs" :key="tab.value" :value="tab.value"
                    class="flex items-center gap-2 p-2 cursor-pointer"
                    :class="{ 'data-[state=active]:bg-red-600': tabErrors?.[tab.value] }">
                    <div class="flex items-center" :class="textClasses(tab)">
                        <BaseIcon :path="tab.icon" class="w-6 h-6" />
                        <p class="text-start whitespace-pre-line">{{ tab.name }}</p>
                    </div>
                </TabsTrigger>
            </TabsList>

            <TabsContent value="info" class="py-5">
                <TabInfo :academicDegrees="academicDegrees" :genders="genders" :jobOfferTypes="jobOfferTypes" />
            </TabsContent>
            <TabsContent value="description" class="py-5">
                <TabDescription />
            </TabsContent>
            <TabsContent value="classification" class="py-5">
                <TabClassification :oecdSectors="oecdSectors" :economicSectors="economicSectors" />
            </TabsContent>
            <TabsContent value="contact" class="py-5">
                <TabContact />
            </TabsContent>
        </Tabs>
        <CardBox>
            <div class="md:flex justify-between items-center md:space-y-0 space-y-2">
                <div>
                    Paso <strong>{{ step + 1 }}</strong> de <strong>{{ tabs.length }}</strong>
                </div>
                <div class="flex gap-2 justify-end">
                    <BaseButton :icon="mdiClose" color="lightDark" label="Cancelar" :routeName="`${routeName}index`" />
                    <BaseButton :icon="mdiSend" color="success" label="Actualizar" @click="updateForm" :loading="processing"/>
                </div>
            </div>
        </CardBox>
    </LayoutMain>
</template>
<script setup>
import HeadLogo from '@/Components/HeadLogo.vue';
import SectionTitleLineWithButton from '@/Components/SectionTitleLineWithButton.vue';
import LayoutMain from '@/Layouts/LayoutMain.vue';
import { mdiClose, mdiSend, mdiPencil } from '@mdi/js';
import { Tabs, TabsContent, TabsList, TabsTrigger, } from "@/Components/ui/tabs/index.js";
import { useTabs, tabs } from '../Composables/useTabs';
import CardBox from '@/Components/CardBox.vue';
import TabInfo from '../Components/TabInfo.vue';
import BaseButton from '@/Components/BaseButton.vue';
import BaseIcon from '@/Components/BaseIcon.vue';
import { useJobOffer } from '../Composables/useJobOffer';
import TabDescription from '../Components/TabDescription.vue';
import TabClassification from '../Components/TabClassification.vue';
import TabContact from '../Components/TabContact.vue';
import { computed } from 'vue';

const props = defineProps({
    title: { type: String, required: true },
    routeName: { type: String, required: true },
    jobOffer: { type: Object, default: null },
    jobOfferTypes: { type: Array, default: () => [] },
    academicDegrees: { type: Array, default: () => [] },
    genders: { type: Array, default: () => [] },
    oecdSectors: { type: Array, default: () => [] },
    economicSectors: { type: Array, default: () => [] }
});

const { activeTab, tabErrors, step } = useTabs()
const { processing, updateForm } = useJobOffer(props)

const textClasses = computed(() => {
    return (tab) => {
        if (tabErrors.value?.[tab.value]) {
            return activeTab.value === tab.value ? 'text-white' : 'text-red-600';
        }
        return '';
    };
});
</script>
