<template>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-8">
        <select :value="selectedEconomicSector" @change="$emit('update:selectedEconomicSector', $event.target.value)"
            class="px-4 py-2 border-2 border-wine-50 rounded-lg focus:ring-2 focus:ring-wine-50 focus:border-transparent">
            <option value="">Seleccionar un sector económico (ISIC)</option>
            <template v-for="sector in economicSectors" :key="sector.id">
                <optgroup v-if="sector.children && sector.children.length" :label="sector.name">
                    <option v-for="child in sector.children" :key="child.id" :value="child.id">
                        {{ child.name }}
                    </option>
                </optgroup>
                <option v-else :value="sector.id">{{ sector.name }}</option>
            </template>
        </select>

        <select :value="selectedOecdSector" @change="$emit('update:selectedOecdSector', $event.target.value)"
            class="px-4 py-2 border-2 border-wine-50 rounded-lg focus:ring-2 focus:ring-wine-50 focus:border-transparent">
            <option value="">Seleccionar un campo científico y tecnológico (OCDE)</option>
            <template v-for="sector in oecdSectors" :key="sector.id">
                <optgroup v-if="sector.children && sector.children.length" :label="sector.name">
                    <option v-for="child in sector.children" :key="child.id" :value="child.id">
                        {{ child.name }}
                    </option>
                </optgroup>
                <option v-else :value="sector.id">{{ sector.name }}</option>
            </template>
        </select>
    </div>
</template>

<script setup>
defineProps({
    selectedEconomicSector: {
        type: String,
        default: ''
    },
    selectedOecdSector: {
        type: String,
        default: ''
    },
    economicSectors: {
        type: Array,
        required: true
    },
    oecdSectors: {
        type: Array,
        required: true
    }
});

defineEmits(['update:selectedEconomicSector', 'update:selectedOecdSector']);
</script>