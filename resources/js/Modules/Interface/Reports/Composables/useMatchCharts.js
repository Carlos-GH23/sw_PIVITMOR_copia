import { computed, isRef, onBeforeUnmount, nextTick, ref } from 'vue';
import { Chart, DoughnutController, ArcElement, Tooltip, Legend } from 'chart.js';

Chart.register(DoughnutController, ArcElement, Tooltip, Legend);

export function useMatchCharts(chartData, chartCanvas) {
    const data = computed(() => isRef(chartData) ? chartData.value : chartData);

    const chartInstance = ref(null);

    const initChart = (config) => {
        if (!chartCanvas.value) return;
        if (chartInstance.value) chartInstance.value.destroy();
        chartInstance.value = new Chart(chartCanvas.value, config);
    };

    const destroyChart = () => {
        if (chartInstance.value) {
            chartInstance.value.destroy();
            chartInstance.value = null;
        }
    };

    onBeforeUnmount(destroyChart);

    const donutConfig = (labels, data, colors) => ({
        type: 'doughnut',
        data: {
            labels,
            datasets: [{
                data: data.map(v => Math.max(0, v)),
                backgroundColor: colors,
                hoverOffset: 10
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { position: 'bottom' },
                tooltip: {
                    callbacks: {
                        label: (context) => `${context.label}: ${context.parsed} días promedio`
                    }
                }
            },
            cutout: '70%'
        }
    });

    const funnelChartData = computed(() => {
        if (!data.value?.funnelChart) {
            return { labels: [], data: [], colors: [] };
        }

        const chart = data.value.funnelChart;
        return {
            labels: chart.labels || [],
            data: chart.datasets?.[0]?.data || [],
            colors: chart.datasets?.[0]?.backgroundColor || [],
        };
    });

    const funnelTotals = computed(() => {
        if (!data.value?.funnelChart?.totals) {
            return { matches: 0, with_both_acceptances: 0, with_success: 0 };
        }
        return data.value.funnelChart.totals;
    });

    const renderFunnelChart = async () => {
        await nextTick();
        const chartData = funnelChartData.value;
        if (chartCanvas.value && chartData.labels.length > 0) {
            initChart(donutConfig(chartData.labels, chartData.data, chartData.colors));
        }
    };

    return {
        funnelChartData,
        funnelTotals,
        renderFunnelChart,
        destroyChart,
        chartInstance,
    };
}