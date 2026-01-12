<template>
    <loading v-model:active="isLoading" :can-cancel="false" :is-full-page="true" loader="dots" color="#283C2A" />
    <template v-if="data">
        <div class="grid lg:grid-cols-2 gap-6 mb-6">
            <CardChart title="Tiempo promedio por etapa" has-divider>
                <template #actions>
                    <DropdownMenuItem @click="downloadChartInstance(chartInstance, 'funnel-tiempos')">
                        Descargar
                        <DropdownMenuShortcut>
                            <BaseIcon :path="mdiDownload" />
                        </DropdownMenuShortcut>
                    </DropdownMenuItem>
                    <DropdownMenuItem @click="printChartInstance(chartInstance, 'Tiempo Promedio por Etapa')">
                        Imprimir
                        <DropdownMenuShortcut>
                            <BaseIcon :path="mdiPrinter" />
                        </DropdownMenuShortcut>
                    </DropdownMenuItem>
                </template>
                <template #chart>
                    <div class="max-w-xs mx-auto">
                        <canvas ref="canvasFunnel"></canvas>
                    </div>
                </template>
                <template #legend>
                    <div class="text-sm text-neutral-600 text-center space-y-1">
                        <p class="text-pretty">Publicación → Match → Aceptación → Éxito</p>
                        <p class="text-xs text-neutral-500">
                            Total: {{ funnelTotals.matches }} matches |
                            Con aceptación: {{ funnelTotals.with_both_acceptances }} |
                            Exitosos: {{ funnelTotals.with_success }}
                        </p>
                    </div>
                </template>
            </CardChart>

            <CardChart title="Mapa de Calor" has-divider>
                <template #actions>
                    <DropdownMenuItem @click="downloadElement(heatmapRef, 'mapa-calor')">
                        Descargar
                        <DropdownMenuShortcut>
                            <BaseIcon :path="mdiDownload" />
                        </DropdownMenuShortcut>
                    </DropdownMenuItem>
                    <DropdownMenuItem @click="printElement(heatmapRef, 'Mapa de Calor')">
                        Imprimir
                        <DropdownMenuShortcut>
                            <BaseIcon :path="mdiPrinter" />
                        </DropdownMenuShortcut>
                    </DropdownMenuItem>
                </template>
                <template #chart>
                    <div ref="heatmapRef">
                        <MatchHeatmap :data="data.heatmapData" />
                    </div>
                </template>
                <template #legend>
                    <p class="text-sm text-neutral-600 text-center text-pretty">
                        Vinculaciones por región geográfica
                    </p>
                </template>
            </CardChart>
        </div>

        <MatchRecords :matches="data.matchesTable" :table-filters="tableFilters" @update:filters="onFiltersChange"
            @clear="onClearFilters" />
    </template>

    <CardBoxComponentEmpty v-else />
</template>

<script setup>
import { ref, toRef, watch } from 'vue';
import BaseIcon from '@/Components/BaseIcon.vue';
import CardBoxComponentEmpty from '@/Components/CardBoxComponentEmpty.vue';
import CardChart from './CardChart.vue';
import MatchRecords from './MatchRecords.vue';
import MatchHeatmap from './MatchHeatmap.vue';
import { DropdownMenuItem, DropdownMenuShortcut } from '@/Components/ui/dropdown-menu';
import { mdiDownload, mdiPrinter } from '@mdi/js';
import { useMatchCharts } from '../Composables/useMatchCharts';
import { useChartExport } from '../Composables/useChartExport';
import { useReportTableTab } from '../Composables/useReportTableTab';

const props = defineProps({
    activeTab: {
        type: String,
        required: true,
    },
    appliedFilters: {
        type: Object,
        required: true,
    },
    filtersVersion: {
        type: Number,
        required: true,
    },
});

const {
    data,
    isLoading,
    tableFilters,
    onFiltersChange,
    onClearFilters
} = useReportTableTab(
    props,
    'api.reports.matches',
    'matchings',
    toRef(props, 'appliedFilters'),
    toRef(props, 'filtersVersion')
);

const canvasFunnel = ref(null);
const heatmapRef = ref(null);

const { funnelChartData, funnelTotals, renderFunnelChart, chartInstance } = useMatchCharts(data, canvasFunnel);
const { downloadChartInstance, printChartInstance, downloadElement, printElement } = useChartExport();

watch(funnelChartData, () => {
    renderFunnelChart();
}, { immediate: true });
</script>