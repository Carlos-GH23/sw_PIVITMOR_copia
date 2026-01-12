<template>
    <loading v-model:active="isLoading" :can-cancel="false" :is-full-page="true" loader="dots" color="#283C2A" />
    <template v-if="data">
        <div class="grid lg:grid-cols-2 gap-6 mb-6">
            <CardChart title="Visitas por rol y módulo">
                <template #actions>
                    <DropdownMenuItem @click="downloadChart(barChartRef, 'visitas-rol')">
                        Descargar
                        <DropdownMenuShortcut>
                            <BaseIcon :path="mdiDownload" />
                        </DropdownMenuShortcut>
                    </DropdownMenuItem>
                    <DropdownMenuItem @click="printChart(barChartRef, 'Sesiones por rol')">
                        Imprimir
                        <DropdownMenuShortcut>
                            <BaseIcon :path="mdiPrinter" />
                        </DropdownMenuShortcut>
                    </DropdownMenuItem>
                </template>

                <template #chart>
                    <div class="h-80">
                        <Bar ref="barChartRef" :data="data.sessionsBar" :options="barOptions" />
                    </div>
                </template>
            </CardChart>

            <CardChart title="Actividad por tipo de entidad">
                <template #actions>
                    <DropdownMenuItem @click="downloadChart(lineChartRef, 'actividad-entidad')">
                        Descargar
                        <DropdownMenuShortcut>
                            <BaseIcon :path="mdiDownload" />
                        </DropdownMenuShortcut>
                    </DropdownMenuItem>
                    <DropdownMenuItem @click="printChart(lineChartRef, 'Actividad por Entidad')">
                        Imprimir
                        <DropdownMenuShortcut>
                            <BaseIcon :path="mdiPrinter" />
                        </DropdownMenuShortcut>
                    </DropdownMenuItem>
                </template>

                <template #chart>
                    <div class="h-80">
                        <Line ref="lineChartRef" :data="data.activityLine" :options="lineOptions" />
                    </div>
                </template>
            </CardChart>
        </div>



        <SystemRecords :modules="data.modulesTable" />
    </template>

    <CardBoxComponentEmpty v-else />
</template>

<script setup>
import { ref, toRef } from 'vue';
import BaseIcon from '@/Components/BaseIcon.vue';
import CardBoxComponentEmpty from '@/Components/CardBoxComponentEmpty.vue';
import CardChart from './CardChart.vue';
import SystemRecords from './SystemRecords.vue';
import { ArcElement, BarElement, Chart, CategoryScale, Legend, LinearScale, LineElement, LineController, PointElement, Title, Tooltip } from 'chart.js';
import { Line, Bar } from 'vue-chartjs';
import { DropdownMenuItem, DropdownMenuShortcut } from '@/Components/ui/dropdown-menu';
import { mdiDownload, mdiPrinter } from '@mdi/js';
import { useChartExport } from '../Composables/useChartExport';
import { useReportTableTab } from '../Composables/useReportTableTab';

Chart.register(
    ArcElement,
    Title,
    Tooltip,
    Legend,
    BarElement,
    CategoryScale,
    LineController,
    LinearScale,
    PointElement,
    LineElement
);

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


const { data, isLoading, } = useReportTableTab(props, 'api.reports.system', 'system', toRef(props, 'appliedFilters'), toRef(props, 'filtersVersion'));
const { downloadChart, printChart } = useChartExport();
const lineChartRef = ref(null);
const barChartRef = ref(null);

const lineOptions = {
    responsive: true,
    maintainAspectRatio: false,
    plugins: {
        legend: {
            position: 'bottom'
        },
        tooltip: {
            mode: 'index',
            intersect: false
        },
    },
    interaction: {
        mode: 'nearest',
        intersect: false
    },
    scales: {
        x: { display: true },
        y: { display: true, beginAtZero: true },
    },
};



const barOptions = {
    responsive: true,
    maintainAspectRatio: false,
    plugins: {
        legend: {
            display: true,
            position: 'bottom'
        },
        tooltip: {
            mode: 'index',
            intersect: false
        },
    },
    scales: {
        x: {
            display: true
        },
        y: {
            display: true,
            beginAtZero: true,
            title: {
                display: true,
                text: 'Visitas'
            }
        },
    },
};
</script>