<template>
    <loading v-model:active="isLoading" :can-cancel="false" :is-full-page="true" loader="dots" color="#283C2A" />
    <template v-if="data">
        <div class="grid lg:grid-cols-2 gap-6 mb-6">
            <CardChart title="Líneas · IES/CI más activos" has-divider>
                <template #actions>
                    <DropdownMenuItem @click="downloadChart(institutionsChartRef, 'ranking-instituciones')">
                        Descargar
                        <DropdownMenuShortcut>
                            <BaseIcon :path="mdiDownload" />
                        </DropdownMenuShortcut>
                    </DropdownMenuItem>
                    <DropdownMenuItem @click="printChart(institutionsChartRef, 'IES/CI más activos')">
                        Imprimir
                        <DropdownMenuShortcut>
                            <BaseIcon :path="mdiPrinter" />
                        </DropdownMenuShortcut>
                    </DropdownMenuItem>
                </template>
                <template #chart>
                    <div class="h-80">
                        <Line ref="institutionsChartRef" :data="institutionsChartData" :options="lineOptions" />
                    </div>
                </template>
                <template #legend>
                    <p class="text-sm text-neutral-600 text-center text-pretty">
                        Evolución de vinculaciones exitosas por institución
                    </p>
                </template>
            </CardChart>

            <CardChart title="Barras · Dependencias de gobierno participantes" has-divider>
                <template #actions>
                    <DropdownMenuItem @click="downloadChart(agenciesChartRef, 'dependencias-gobierno')">
                        Descargar
                        <DropdownMenuShortcut>
                            <BaseIcon :path="mdiDownload" />
                        </DropdownMenuShortcut>
                    </DropdownMenuItem>
                    <DropdownMenuItem @click="printChart(agenciesChartRef, 'Dependencias de Gobierno Participantes')">
                        Imprimir
                        <DropdownMenuShortcut>
                            <BaseIcon :path="mdiPrinter" />
                        </DropdownMenuShortcut>
                    </DropdownMenuItem>
                </template>
                <template #chart>
                    <div class="h-80">
                        <Bar ref="agenciesChartRef" :data="agenciesChartData" :options="horizontalBarOptions" />
                    </div>
                </template>
                <template #legend>
                    <p class="text-sm text-neutral-600 text-center text-pretty">
                        Vinculaciones por dependencia gubernamental
                    </p>
                </template>
            </CardChart>
        </div>

        <InstitutionalRecords :matches="data.matchesTable" :table-filters="tableFilters"
            @update:filters="onFiltersChange" @clear="onClearFilters" />
    </template>

    <CardBoxComponentEmpty v-else />
</template>

<script setup>
import { ref, toRef } from 'vue';
import BaseIcon from '@/Components/BaseIcon.vue';
import CardBoxComponentEmpty from '@/Components/CardBoxComponentEmpty.vue';
import CardChart from './CardChart.vue';
import InstitutionalRecords from './InstitutionalRecords.vue';
import { DropdownMenuItem, DropdownMenuShortcut } from '@/Components/ui/dropdown-menu';
import { mdiDownload, mdiPrinter } from '@mdi/js';
import { Bar, Line } from 'vue-chartjs';
import { useInstitutionalCharts } from '../Composables/useInstitutionalCharts';
import { useChartExport } from '../Composables/useChartExport';
import { useReportTableTab } from '../Composables/useReportTableTab';
import { Chart, Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale, PointElement, LineElement } from 'chart.js';

Chart.register(Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale, PointElement, LineElement);

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
    'api.reports.institucional.perfomance',
    'institutions',
    toRef(props, 'appliedFilters'),
    toRef(props, 'filtersVersion')
);

const { downloadChart, printChart } = useChartExport();
const institutionsChartRef = ref(null);
const agenciesChartRef = ref(null);

const { institutionsChartData, agenciesChartData, lineOptions, horizontalBarOptions } = useInstitutionalCharts(data);
</script>