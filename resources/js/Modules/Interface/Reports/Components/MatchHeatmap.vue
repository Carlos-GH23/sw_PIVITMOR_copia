<template>
    <div class="relative">
        <div :id="mapId" class="w-full h-80 z-0 rounded-lg"></div>

        <div class="absolute bottom-4 right-4 bg-white/90 rounded-lg p-2 shadow-md text-xs">
            <div class="flex items-center gap-2">
                <span class="text-neutral-600">Baja</span>
                <div class="w-24 h-3 rounded"
                    style="background: linear-gradient(to right, #3b82f6, #06b6d4, #22c55e, #f59e0b, #ef4444)">
                </div>
                <span class="text-neutral-600">Alta</span>
            </div>
            <p class="text-center text-neutral-500 mt-1">Concentración de vinculaciones</p>
        </div>
    </div>
</template>

<script setup>
import { computed, onMounted, onUnmounted, watch } from 'vue';
import { useMatchHeatmap } from '../Composables/useMatchHeatmap';

const props = defineProps({
    data: {
        type: Array,
        default: () => []
    }
});

const mapId = `heatmap-${Date.now()}`;
const dataRef = computed(() => props.data);
const hasData = computed(() => props.data?.length > 0);

const { initMap, updateHeatmap, destroy } = useMatchHeatmap(mapId, dataRef);

onMounted(() => {
    initMap();
    if (hasData.value) {
        updateHeatmap();
    }
});

watch(() => props.data, () => {
    updateHeatmap();
}, { deep: true });

onUnmounted(() => {
    destroy();
});
</script>