<template>
    <HeadLogo title="Mapa ecosistema" />

    <LayoutWelcome>
        <SectionWrapper :hasLayer="false">
            <div class="space-y-0 mx-auto">
                <TitleLineWithIcon class="mx-auto mb-6">
                    Mapa del ecosistema de <span class="font-extrabold"> innovación en Morelos </span>
                </TitleLineWithIcon>
                <div class="w-24 h-1 mb-5 mx-auto bg-wine-50 rounded-full" />

                <div class="lg:w-3/5 mx-auto">
                    <p class="text-lg text-center leading-relaxed mb-4">
                        Conoce cómo se conectan las instituciones académicas, los centros de investigación, la
                        industria, el gobierno y la sociedad dentro de la entidad.
                    </p>
                </div>
            </div>

            <div class="my-10 grid items-center grid-cols-1 lg:grid-cols-1 gap-8">
                <div class="lg:col-span-2">
                    <div class="bg-white rounded-lg shadow-lg">
                        <EntityMap :resources="filteredResources" />
                    </div>
                </div>
            </div>

            <ResourceFilters :selectedTypes="selectedTypes" 
                :selectedEconomicSector="selectedEconomicSector" 
                :selectedOecdSector="selectedOecdSector"
                :economicSectors="economicSectors" 
                :oecdSectors="oecdSectors"
                @selectAll="selectAll" 
                @deselectAll="deselectAll"
                @update:selectedEconomicSector="selectedEconomicSector = $event"
                @update:selectedOecdSector="selectedOecdSector = $event" />

            <div class="grid grid-cols-2 items-center lg:flex flex-wrap justify-center gap-12">
                <SectorStat v-for="sector in ecosystemSectors" :key="sector.title" v-bind="sector" />
            </div>
        </SectionWrapper>
    </LayoutWelcome>
</template>

<script setup>
import { toRef } from 'vue';
import HeadLogo from '@/Components/HeadLogo.vue';
import EntityMap from '../Components/EntityMap.vue';
import LayoutWelcome from '@/Layouts/LayoutWelcome.vue';
import SectorStat from '../Components/SectorStat.vue';
import SectionWrapper from '../Components/SectionWrapper.vue';
import TitleLineWithIcon from '@/Components/TitleLineWithIcon.vue';
import ResourceFilters from '../Components/ResourceFilters.vue';
import { useEcosystem } from '../Composables/useEcosystem';
import { useEcosystemFilters } from '../Composables/useEcosystemFilters';

const props = defineProps({
    ecosystemStats: {
        type: Object,
        required: true
    },
    ecosystemResources: {
        type: Array,
        required: true
    },
    oecdSectors: {
        type: Array,
        required: true
    },
    economicSectors: {
        type: Array,
        required: true
    }
});

const { ecosystemSectors } = useEcosystem(toRef(props, 'ecosystemStats'));

const {
    selectedTypes,
    selectedOecdSector,
    selectedEconomicSector,
    filteredResources,
    selectAll,
    deselectAll
} = useEcosystemFilters(
    toRef(props, 'ecosystemResources'),
    toRef(props, 'oecdSectors'),
    toRef(props, 'economicSectors')
);
</script>