<template>
    <loading v-model:active="isLoading" :can-cancel="false" :is-full-page="true" loader="dots" color="#283C2A" />
    <template v-if="data">
        <div class="grid lg:grid-cols-2 gap-6 mb-6">
            <CardChart title="Capacidades y necesidades por área OCDE">
                <template #actions>
                    <DropdownMenuItem @click="downloadChart(barChartRef, 'capacidades-oecd')">
                        Descargar
                        <DropdownMenuShortcut>
                            <BaseIcon :path="mdiDownload" />
                        </DropdownMenuShortcut>
                    </DropdownMenuItem>
                    <DropdownMenuItem @click="printChart(barChartRef, 'Capacidades y Necesidades por OCDE')">
                        Imprimir
                        <DropdownMenuShortcut>
                            <BaseIcon :path="mdiPrinter" />
                        </DropdownMenuShortcut>
                    </DropdownMenuItem>
                </template>

                <template #chart>
                    <div class="h-80">
                        <Bar ref="barChartRef" :data="oecdBarData" :options="stackedBarOptions" />
                    </div>
                </template>
            </CardChart>

            <CardChart title="Vistas por sector ISIC">
                <template #actions>
                    <DropdownMenuItem @click="downloadChart(pieChartRef, 'vistas-isic')">
                        Descargar
                        <DropdownMenuShortcut>
                            <BaseIcon :path="mdiDownload" />
                        </DropdownMenuShortcut>
                    </DropdownMenuItem>
                    <DropdownMenuItem @click="printChart(pieChartRef, 'Vistas por Sector ISIC')">
                        Imprimir
                        <DropdownMenuShortcut>
                            <BaseIcon :path="mdiPrinter" />
                        </DropdownMenuShortcut>
                    </DropdownMenuItem>
                </template>

                <template #chart>
                    <div class="h-80">
                        <Pie ref="pieChartRef" :data="isicPieData" :options="pieOptions" />
                    </div>
                </template>
            </CardChart>
        </div>

        <CardChart title="Tiempos de publicación (días promedio)" class="mb-6">
            <template #actions>
                <DropdownMenuItem @click="downloadChart(lineChartRef, 'tiempos-publicacion')">
                    Descargar
                    <DropdownMenuShortcut>
                        <BaseIcon :path="mdiDownload" />
                    </DropdownMenuShortcut>
                </DropdownMenuItem>
                <DropdownMenuItem @click="printChart(lineChartRef, 'Tiempos de Publicación')">
                    Imprimir
                    <DropdownMenuShortcut>
                        <BaseIcon :path="mdiPrinter" />
                    </DropdownMenuShortcut>
                </DropdownMenuItem>
            </template>

            <template #chart>
                <div class="h-80 flex items-center justify-center">
                    <Line ref="lineChartRef" :data="publicationLineData" :options="lineOptions" />
                </div>
            </template>
        </CardChart>

        <CapabilityRecords :publications="data.publicationsTable" :table-filters="tableFilters"
            @update:filters="onFiltersChange" @clear="onClearFilters" />
    </template>

    <CardBoxComponentEmpty v-else />
</template>

<script setup>
import { ref, toRef } from 'vue';
import BaseIcon from '@/Components/BaseIcon.vue';
import CardBoxComponentEmpty from '@/Components/CardBoxComponentEmpty.vue';
import CardChart from './CardChart.vue';
import { DropdownMenuItem, DropdownMenuShortcut } from '@/Components/ui/dropdown-menu';
import { mdiDownload, mdiPrinter } from '@mdi/js';
import { Bar, Line, Pie } from 'vue-chartjs';
import { useCapabilitiesCharts } from '../Composables/useCapabilitiesCharts';
import { useChartExport } from '../Composables/useChartExport';
import { useReportTableTab } from '../Composables/useReportTableTab';
import { Chart, Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale, PointElement, LineElement, ArcElement } from 'chart.js';
import CapabilityRecords from './CapabilityRecords.vue';

Chart.register(Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale, PointElement, LineElement, ArcElement);

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
    'api.reports.capabilities',
    'capabilitiesRequirements',
    toRef(props, 'appliedFilters'),
    toRef(props, 'filtersVersion')
);

const { downloadChart, printChart } = useChartExport();
const barChartRef = ref(null);
const pieChartRef = ref(null);
const lineChartRef = ref(null);

const { stackedBarOptions, pieOptions, lineOptions, oecdBarData, isicPieData, publicationLineData } = useCapabilitiesCharts(data);
</script>