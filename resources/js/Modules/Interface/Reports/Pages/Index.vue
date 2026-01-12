<template>
    <HeadLogo :title="title" />
    <LayoutMain>
        <SectionTitleLineWithButton :icon="mdiChartAreaspline" :title="title" main />

        <Tabs v-model="activeTab" class="lg:w-full">
            <TabsList class="w-full gap-4 h-auto lg:h-12">
                <TabsTrigger v-for="tab in tabs" :key="tab.value" :value="tab.value"
                    class="flex items-center gap-2 p-2 cursor-pointer">
                    <span class="text-left whitespace-pre-line">{{ tab.name }}</span>
                </TabsTrigger>
            </TabsList>

            <FiltersBar :active-tab="activeTab" :filters-report="filters" :user-types="userTypes"
                :economic-sectors="economicSectors" :oecd-sectors="oecdSectors" :categories="categories"
                :research-areas="researchAreas" :sni-levels="sniLevels" :genders="genders"
                :municipalities="municipalities" @apply="applyFilters" @clear="clearFilters" />

            <KpiSummary v-if="activeTab === 'system'" :data="kpisData" />

            <TabsContent value="system" class="py-5">
                <TabSystem :active-tab="activeTab" :applied-filters="appliedFilters"
                    :filters-version="filtersVersion" />
            </TabsContent>

            <TabsContent value="capabilitiesRequirements" class="py-5">
                <TabCapabilities :active-tab="activeTab" :applied-filters="appliedFilters"
                    :filters-version="filtersVersion" />
            </TabsContent>

            <TabsContent value="techServices" class="py-5">
                <TabTechServices :active-tab="activeTab" :applied-filters="appliedFilters"
                    :filters-version="filtersVersion" />
            </TabsContent>

            <TabsContent value="matchings" class="py-5">
                <TabVinculations :active-tab="activeTab" :applied-filters="appliedFilters"
                    :filters-version="filtersVersion" />
            </TabsContent>

            <TabsContent value="institutions" class="py-5">
                <TabInstitutions :active-tab="activeTab" :applied-filters="appliedFilters"
                    :filters-version="filtersVersion" />
            </TabsContent>

            <TabsContent value="snii">
                <TabSnii :active-tab="activeTab" :applied-filters="appliedFilters" :filters-version="filtersVersion" />
            </TabsContent>
        </Tabs>
    </LayoutMain>
</template>
<script setup>
import HeadLogo from '@/Components/HeadLogo.vue';
import SectionTitleLineWithButton from '@/Components/SectionTitleLineWithButton.vue';
import FiltersBar from '../Components/FiltersBar.vue';
import KpiSummary from '../Components/KpiSummary.vue';
import LayoutMain from '@/Layouts/LayoutMain.vue';
import { mdiChartAreaspline } from '@mdi/js';
import { Tabs, TabsContent, TabsList, TabsTrigger } from '@/Components/ui/tabs/index.js';
import { useTabs } from '../Composables/useTabs';
import TabVinculations from '../Components/TabVinculations.vue';
import TabInstitutions from '../Components/TabInstitutions.vue';
import TabSystem from '../Components/TabSystem.vue';
import TabCapabilities from '../Components/TabCapabilities.vue';
import TabTechServices from '../Components/TabTechServices.vue';
import { useFilters } from '../Composables/useFilters';
import TabSnii from '../Components/TabSnii.vue';

const props = defineProps({
    title: String,
    routeName: String,
    filtersReport: Object,
    userTypes: Object,
    oecdSectors: Object,
    economicSectors: Object,
    categories: Object,
    researchAreas: Object,
    sniLevels: Object,
    genders: Object,
    municipalities: Object,
    kpisData: Array,
});

const { activeTab, tabs } = useTabs();
const { filters, appliedFilters, filtersVersion, applyFilters, clearFilters } = useFilters(props.filtersReport, props.routeName);
</script>