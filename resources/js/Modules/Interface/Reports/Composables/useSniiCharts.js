import { computed } from 'vue';

export function useSniiCharts(data) {
    const levelsChartData = computed(() => {
        if (!data.value?.charts?.levelsChart) {
            return { labels: [], datasets: [] };
        }

        return {
            labels: data.value.charts.levelsChart.labels,
            datasets: data.value.charts.levelsChart.datasets,
        };
    });

    const researchAreasChartData = computed(() => {
        if (!data.value?.charts?.researchAreasChart) {
            return { labels: [], datasets: [] };
        }

        return {
            labels: data.value.charts.researchAreasChart.labels,
            datasets: data.value.charts.researchAreasChart.datasets,
        };
    });

    const institutionTypeChartData = computed(() => {
        if (!data.value?.charts?.institutionTypeChart) {
            return { labels: [], datasets: [] };
        }
        return {
            labels: data.value.charts.institutionTypeChart.labels,
            datasets: data.value.charts.institutionTypeChart.datasets,
        };
    });

    const genderChartData = computed(() => {
        if (!data.value?.charts?.genderChart) {
            return { labels: [], datasets: [] };
        }
        return {
            labels: data.value.charts.genderChart.labels,
            datasets: data.value.charts.genderChart.datasets,
        };
    });

    const funnelChartData = computed(() => {
        if (!data.value?.funnelChart) {
            return { labels: [], datasets: [] };
        }
        return {
            labels: data.value.funnelChart.labels,
            datasets: data.value.funnelChart.datasets,
        };
    });

    const verticalStackedBarOptions = {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                position: 'bottom',
            },
            tooltip: {
                callbacks: {
                    label: (context) => `${context.dataset.label}: ${context.parsed.y}`,
                },
            },
        },
        scales: {
            x: {
                stacked: true,
                grid: {
                    display: false,
                },
            },
            y: {
                stacked: true,
                beginAtZero: true,
                ticks: {
                    stepSize: 1,
                    precision: 0,
                },
                grid: {
                    display: true,
                    color: 'rgba(0, 0, 0, 0.05)',
                },
                title: {
                    display: true,
                    text: 'Total',
                },
            },
        },
    };

    const horizontalBarOptions = {
        indexAxis: 'y',
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                display: false,
            },
            tooltip: {
                callbacks: {
                    label: (context) => `${context.parsed.x} integrantes`,
                },
            },
        },
        scales: {
            x: {
                beginAtZero: true,
                ticks: {
                    stepSize: 1,
                    precision: 0,
                },
                grid: {
                    display: true,
                    color: 'rgba(0, 0, 0, 0.05)',
                },
                title: {
                    display: true,
                    text: 'Conteo',
                },
            },
            y: {
                grid: {
                    display: false,
                },
                ticks: {
                    autoSkip: false,
                    font: {
                        size: 11,
                    },
                    callback: function (value) {
                        const label = this.getLabelForValue(value);
                        return label.length > 30 ? label.substring(0, 30) + '...' : label;
                    },
                },
            },
        },
    };

    const doughnutOptions = {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                position: 'bottom',
            },
            tooltip: {
                callbacks: {
                    label: function (context) {
                        const label = context.label || '';
                        const value = context.parsed || 0;
                        const total = context.dataset.data.reduce((a, b) => a + b, 0);
                        const percentage = total > 0 ? ((value / total) * 100).toFixed(1) : 0;
                        return `${label}: ${value} (${percentage}%)`;
                    },
                },
            },
        },
    };

    const funnelOptions = {
        indexAxis: 'y',
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                display: false,
            },
            tooltip: {
                callbacks: {
                    label: function (context) {
                        const label = context.dataset.label || '';
                        const value = context.parsed.x || 0;
                        const dataset = context.chart.data.datasets[0].data;
                        const total = dataset[0];
                        const percentage = total > 0 ? ((value / total) * 100).toFixed(1) : 0;

                        return `${label}: ${value} (${percentage}%)`;
                    }
                }
            }
        },
        scales: {
            x: {
                display: true,
                beginAtZero: true,
            },
            y: {
                display: true,
            }
        }
    };

    const municipalityDistribution = computed(() => {
        return data.value?.charts?.municipalityDistribution || { ranking: [], heatmap: [] };
    });

    const matchActivityChartData = computed(() => {
        if (!data.value?.charts?.matchActivityChart) {
            return { labels: [], datasets: [] };
        }
        return {
            labels: data.value.charts.matchActivityChart.labels,
            datasets: data.value.charts.matchActivityChart.datasets,
        };
    });

    return {
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
        matchActivityChartData,
    };
}
