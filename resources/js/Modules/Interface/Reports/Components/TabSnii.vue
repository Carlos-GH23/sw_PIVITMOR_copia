<template>
    <loading v-model:active="isLoading" :can-cancel="false" :is-full-page="true" loader="dots" color="#283C2A" />
    <template v-if="data">
        <KpiSummary v-if="data.kpis" :data="data.kpis" />
        <div class="grid lg:grid-cols-2 gap-6 mb-6 py-6">
            <CardChart title="Distribución por Nivel SNII y Género" has-divider>
                <template #actions>
                    <DropdownMenuItem @click="downloadChart(levelsChartRef, 'snii-niveles-genero')">
                        Descargar
                        <DropdownMenuShortcut>
                            <BaseIcon :path="mdiDownload" />
                        </DropdownMenuShortcut>
                    </DropdownMenuItem>
                    <DropdownMenuItem @click="printChart(levelsChartRef, 'Nivel SNII por Género')">
                        Imprimir
                        <DropdownMenuShortcut>
                            <BaseIcon :path="mdiPrinter" />
                        </DropdownMenuShortcut>
                    </DropdownMenuItem>
                </template>
                <template #chart>
                    <div class="h-80">
                        <Bar ref="levelsChartRef" :data="levelsChartData" :options="verticalStackedBarOptions" />
                    </div>
                </template>
                <template #legend>
                    <p class="text-sm text-neutral-600 text-center text-pretty">
                        Investigadores por nivel SNII y género
                    </p>
                </template>
            </CardChart>

            <CardChart title="Áreas de Investigación con más SNII" has-divider>
                <template #actions>
                    <DropdownMenuItem @click="downloadChart(areasChartRef, 'snii-areas-investigacion')">
                        Descargar
                        <DropdownMenuShortcut>
                            <BaseIcon :path="mdiDownload" />
                        </DropdownMenuShortcut>
                    </DropdownMenuItem>
                    <DropdownMenuItem @click="printChart(areasChartRef, 'Áreas de Investigación')">
                        Imprimir
                        <DropdownMenuShortcut>
                            <BaseIcon :path="mdiPrinter" />
                        </DropdownMenuShortcut>
                    </DropdownMenuItem>
                </template>
                <template #chart>
                    <div class="h-80">
                        <Bar ref="areasChartRef" :data="researchAreasChartData" :options="horizontalBarOptions" />
                    </div>
                </template>
                <template #legend>
                    <p class="text-sm text-neutral-600 text-center text-pretty">
                        Áreas con mayor número de integrantes
                    </p>
                </template>
            </CardChart>
        </div>
        <div class="grid lg:grid-cols-2 gap-6 mb-6 py-6">
            <CardChart title="Embudo de Contribución">
                <template #actions>
                    <DropdownMenuItem @click="downloadChart(funnelChartRef, 'embudo-contribucion')">
                        Descargar
                        <DropdownMenuShortcut>
                            <BaseIcon :path="mdiDownload" />
                        </DropdownMenuShortcut>
                    </DropdownMenuItem>
                    <DropdownMenuItem @click="printChart(funnelChartRef, 'Embudo de Contribución')">
                        Imprimir
                        <DropdownMenuShortcut>
                            <BaseIcon :path="mdiPrinter" />
                        </DropdownMenuShortcut>
                    </DropdownMenuItem>
                </template>

                <template #chart>
                    <div class="h-80">
                        <Bar ref="funnelChartRef" :data="funnelChartData" :options="funnelOptions" />
                    </div>
                </template>
                <template #legend>
                    <p class="text-sm text-neutral-600 text-center text-pretty">
                        Flujo de participación de usuarios SNII desde el registro hasta casos de éxito.
                    </p>
                </template>
            </CardChart>

            <CardChart title="Actividad de vinculación">
                <template #actions>
                    <DropdownMenuItem @click="downloadChart(matchActivityChartRef, 'actividad-vinculacion')">
                        Descargar
                        <DropdownMenuShortcut>
                            <BaseIcon :path="mdiDownload" />
                        </DropdownMenuShortcut>
                    </DropdownMenuItem>
                    <DropdownMenuItem @click="printChart(matchActivityChartRef, 'Actividad de Vinculación')">
                        Imprimir
                        <DropdownMenuShortcut>
                            <BaseIcon :path="mdiPrinter" />
                        </DropdownMenuShortcut>
                    </DropdownMenuItem>
                </template>

                <template #chart>
                    <div class="h-80">
                        <Bar ref="matchActivityChartRef" :data="matchActivityChartData" :options="verticalStackedBarOptions" />
                    </div>
                </template>
                <template #legend>
                    <p class="text-sm text-neutral-600 text-center text-pretty">
                        Activas vs concluidas por mes.
                    </p>
                </template>
            </CardChart>
        </div>

        <div class="grid lg:grid-cols-2 gap-6 mb-6">
            <CardChart title="SNII por tipo de institución" has-divider>
                <template #actions>
                    <DropdownMenuItem @click="downloadChart(institutionTypeChartRef, 'snii-tipo-institucion')">
                        Descargar
                        <DropdownMenuShortcut>
                            <BaseIcon :path="mdiDownload" />
                        </DropdownMenuShortcut>
                    </DropdownMenuItem>
                    <DropdownMenuItem @click="printChart(institutionTypeChartRef, 'SNII por Tipo de Institución')">
                        Imprimir
                        <DropdownMenuShortcut>
                            <BaseIcon :path="mdiPrinter" />
                        </DropdownMenuShortcut>
                    </DropdownMenuItem>
                </template>
                <template #chart>
                    <div class="h-80">
                        <Doughnut ref="institutionTypeChartRef" :data="institutionTypeChartData"
                            :options="doughnutOptions" />
                    </div>
                </template>
                <template #legend>
                    <p class="text-sm text-neutral-600 text-center text-pretty">
                        Proporción IES vs CI
                    </p>
                </template>
            </CardChart>

            <CardChart title="SNII por género" has-divider>
                <template #actions>
                    <DropdownMenuItem @click="downloadChart(genderChartRef, 'snii-genero')">
                        Descargar
                        <DropdownMenuShortcut>
                            <BaseIcon :path="mdiDownload" />
                        </DropdownMenuShortcut>
                    </DropdownMenuItem>
                    <DropdownMenuItem @click="printChart(genderChartRef, 'SNII por Género')">
                        Imprimir
                        <DropdownMenuShortcut>
                            <BaseIcon :path="mdiPrinter" />
                        </DropdownMenuShortcut>
                    </DropdownMenuItem>
                </template>
                <template #chart>
                    <div class="h-80">
                        <Doughnut ref="genderChartRef" :data="genderChartData" :options="doughnutOptions" />
                    </div>
                </template>
                <template #legend>
                    <p class="text-sm text-neutral-600 text-center text-pretty">
                        Distribución total por género
                    </p>
                </template>
            </CardChart>
        </div>

        <div class="mb-6">
            <CardChart title="Distribución Geográfica de SNII en Morelos" has-divider>
                <template #actions>
                    <div class="flex items-center bg-neutral-100 p-1 rounded-md">
                        <button @click="mapRankingViewMode = 'map'" :class="[
                            'p-1.5 rounded transition-all duration-200',
                            mapRankingViewMode === 'map' ? 'bg-white shadow text-primary-700' : 'text-neutral-500 hover:text-neutral-700'
                        ]" title="Ver Mapa">
                            <BaseIcon :path="mdiMap" class="w-4 h-4" />
                        </button>
                        <button @click="mapRankingViewMode = 'ranking'" :class="[
                            'p-1.5 rounded transition-all duration-200',
                            mapRankingViewMode === 'ranking' ? 'bg-white shadow text-primary-700' : 'text-neutral-500 hover:text-neutral-700'
                        ]" title="Ver Ranking">
                            <BaseIcon :path="mdiFormatListNumbered" class="w-4 h-4" />
                        </button>
                    </div>
                </template>
                <template #chart>
                    <div class="h-96 w-full">
                        <SniiMap v-if="mapRankingViewMode === 'map'" :data="municipalityDistribution.heatmap" />
                        <SniiMunicipalityRanking v-else :data="municipalityDistribution.ranking" />
                    </div>
                </template>
                <template #legend>
                    <p class="text-sm text-neutral-600 text-center text-pretty">
                        {{ mapRankingViewMode === 'map'
                            ? 'Mapa de calor basado en la ubicación de las instituciones'
                            : 'Listado de municipios con mayor número de integrantes SNII'
                        }}
                    </p>
                </template>
            </CardChart>
        </div>
        
        <SniiRecords :levels="data.levelsTable" :table-filters="tableFilters"
            @update:filters="onFiltersChange" @clear="onClearFilters" />
    </template>
</template>

<script setup>
import { ref, toRef } from 'vue';
import { useReportTableTab } from '../Composables/useReportTableTab';
import KpiSummary from './KpiSummary.vue';
import CardChart from './CardChart.vue';
import SniiMap from './SniiMap.vue';
import SniiMunicipalityRanking from './SniiMunicipalityRanking.vue';
import BaseIcon from '@/Components/BaseIcon.vue';
import { DropdownMenuItem, DropdownMenuShortcut } from '@/Components/ui/dropdown-menu';
import { mdiDownload, mdiPrinter, mdiMap, mdiFormatListNumbered } from '@mdi/js';
import { Bar, Doughnut } from 'vue-chartjs';
import { useSniiCharts } from '../Composables/useSniiCharts';
import { useChartExport } from '../Composables/useChartExport';
import { Chart, Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale, ArcElement } from 'chart.js';
import SniiRecords from './SniiRecords.vue';

Chart.register(Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale, ArcElement);

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
    onClearFilters } = useReportTableTab(props, 'api.reports.snii', 'snii', toRef(props, 'appliedFilters'), toRef(props, 'filtersVersion'));

const { downloadChart, printChart } = useChartExport();
const levelsChartRef = ref(null);
const areasChartRef = ref(null);
const institutionTypeChartRef = ref(null);
const genderChartRef = ref(null);
const funnelChartRef = ref(null);
const matchActivityChartRef = ref(null);

const {
    levelsChartData,
    researchAreasChartData,
    institutionTypeChartData,
    genderChartData,
    municipalityDistribution,
    verticalStackedBarOptions,
    horizontalBarOptions,
    doughnutOptions,
    funnelChartData,
    funnelOptions,
    matchActivityChartData
} = useSniiCharts(data);

const mapRankingViewMode = ref('map');
</script>
