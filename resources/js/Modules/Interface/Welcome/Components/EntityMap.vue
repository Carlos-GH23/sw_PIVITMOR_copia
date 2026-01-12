<template>
    <div id="map" class="w-full h-96 z-0 rounded-lg"></div>
</template>

<script setup>
import { onMounted, watch, toRef } from 'vue';
import { useEcosystemMap } from '../Composables/useEcosystemMap';

const props = defineProps({
    resources: {
        type: Array,
        default: () => []
    }
});

const resourcesRef = toRef(props, 'resources');
const { initMap, updateMarkers } = useEcosystemMap('map', resourcesRef);

onMounted(() => {
    initMap();
    updateMarkers();
});

watch(() => props.resources, () => {
    updateMarkers();
}, { deep: true });
</script>