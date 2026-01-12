import { computed, isRef } from 'vue';

export function useTechServicesCharts(chartData) {
    const data = computed(() => isRef(chartData) ? chartData.value : chartData);

    const barOptions = {
        indexAxis: 'y',
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                display: true,
                position: 'bottom',
            },
            tooltip: {
                mode: 'index',
                intersect: false,
            },
        },
        scales: {
            x: {
                display: true,
                beginAtZero: true,
                title: {
                    display: true,
                    text: 'Cantidad',
                },
            },
            y: {
                display: true,
                ticks: {
                    font: {
                        size: 11,
                    },
                },
            },
        },
    };

    const pieOptions = {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                position: 'right',
                labels: {
                    boxWidth: 12,
                    font: {
                        size: 11,
                    },
                },
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

    const lineOptions = {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                position: 'bottom',
            },
            tooltip: {
                mode: 'index',
                intersect: false,
                callbacks: {
                    label: function (context) {
                        const value = context.parsed.y;
                        if (value === null) return null;
                        return `${context.dataset.label}: ${value} días`;
                    },
                },
            },
        },
        interaction: {
            mode: 'nearest',
            intersect: false,
        },
        scales: {
            x: {
                display: true,
                title: {
                    display: true,
                    text: 'Mes',
                },
            },
            y: {
                display: true,
                beginAtZero: true,
                title: {
                    display: true,
                    text: 'Días promedio',
                },
            },
        },
    };

    const oecdBarData = computed(() => {
        if (!data.value?.oecdStackedBar) {
            return { labels: [], datasets: [] };
        }
        return data.value.oecdStackedBar;
    });

    const isicPieData = computed(() => {
        if (!data.value?.isicPie) {
            return { labels: [], datasets: [] };
        }
        return data.value.isicPie;
    });

    const publicationLineData = computed(() => {
        if (!data.value?.publicationTimes) {
            return { labels: [], datasets: [] };
        }
        return data.value.publicationTimes;
    });

    return {
        barOptions,
        pieOptions,
        lineOptions,
        oecdBarData,
        isicPieData,
        publicationLineData,
    };
}