import { computed } from 'vue';

export function useInstitutionalCharts(data) {
    const institutionsChartData = computed(() => {
        if (!data.value?.activeInstitutionsChart) {
            return { labels: [], datasets: [] };
        }

        return {
            labels: data.value.activeInstitutionsChart.labels,
            datasets: data.value.activeInstitutionsChart.datasets,
        };
    });

    const agenciesChartData = computed(() => {
        if (!data.value?.governmentAgenciesChart) {
            return { labels: [], datasets: [] };
        }

        return {
            labels: data.value.governmentAgenciesChart.labels,
            datasets: data.value.governmentAgenciesChart.datasets,
        };
    });

    const lineOptions = {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                position: 'bottom',
            },
            tooltip: {
                callbacks: {
                    label: (context) => `${context.dataset.label}: ${context.parsed.y} vinculaciones`,
                },
            },
        },
        scales: {
            x: {
                grid: {
                    display: false,
                },
                ticks: {
                    font: {
                        size: 10,
                    },
                    maxRotation: 45,
                    minRotation: 0,
                },
            },
            y: {
                beginAtZero: true,
                ticks: {
                    stepSize: 1,
                    precision: 0,
                },
                grid: {
                    display: true,
                    color: 'rgba(0, 0, 0, 0.05)',
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
                position: 'bottom',
            },
            tooltip: {
                callbacks: {
                    label: (context) => `${context.parsed.x} vinculaciones`,
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
            },
            y: {
                grid: {
                    display: false,
                },
                ticks: {
                    font: {
                        size: 11,
                    },
                    callback: function (value) {
                        const label = this.getLabelForValue(value);
                        return label.length > 25 ? label.substring(0, 25) + '...' : label;
                    },
                },
            },
        },
    };

    return {
        institutionsChartData,
        agenciesChartData,
        lineOptions,
        horizontalBarOptions,
    };
}