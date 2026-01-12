<template>
    <div id="snii-map" class="w-full h-96 z-0 rounded-lg"></div>
</template>

<script setup>
import { onMounted, watch, toRef, onUnmounted } from 'vue';
import L from "leaflet";
import "leaflet/dist/leaflet.css";
import "leaflet.heat";

const props = defineProps({
    data: {
        type: Array,
        default: () => []
    }
});

let map = null;
let heatLayer = null;
const morelosCenter = [18.75, -99.05];
const defaultZoom = 9;

const initMap = () => {
    if (map) return;

    map = L.map('snii-map').setView(morelosCenter, defaultZoom);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 18,
        attribution: '© OpenStreetMap contributors'
    }).addTo(map);

    updateHeatmap();
};

const updateHeatmap = () => {
    if (!map) return;

    if (heatLayer) {
        map.removeLayer(heatLayer);
    }

    if (!props.data || props.data.length === 0) return;

    const points = props.data
        .filter(point => point.lat && point.lng)
        .map(point => [point.lat, point.lng, 0.5]);

    if (points.length === 0) return;

    heatLayer = L.heatLayer(points, {
        radius: 20,
        blur: 15,
        maxZoom: 12,
        max: 1.0,
        gradient: {
            0.0: '#3b82f6',
            0.4: '#22c55e',
            0.7: '#eab308',
            1.0: '#ef4444'
        }
    }).addTo(map);

    if (points.length > 0) {
        const bounds = L.latLngBounds(points.map(p => [p[0], p[1]]));
        map.fitBounds(bounds, { padding: [20, 20] });
    }
};

watch(() => props.data, () => {
    updateHeatmap();
}, { deep: true });

onMounted(() => {
    setTimeout(() => {
        initMap();
    }, 100);
});

onUnmounted(() => {
    if (map) {
        map.remove();
        map = null;
    }
});
</script>
