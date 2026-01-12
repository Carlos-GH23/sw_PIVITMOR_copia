<template>
    <div class="bg-white border rounded-lg shadow-md p-6 mb-8">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-semibold text-gray-800">Filtrar recursos en el mapa</h3>
            <div class="space-x-2">
                <button @click="$emit('selectAll')"
                    class="text-sm text-wine-50 hover:text-wine-100 font-medium cursor-pointer">
                    Seleccionar todos
                </button>
                <span class="text-gray-400">|</span>
                <button @click="$emit('deselectAll')"
                    class="text-sm text-wine-50 hover:text-wine-100 font-medium cursor-pointer">
                    Deseleccionar todos
                </button>
            </div>
        </div>

        <div class="flex justify-between items-center mb-4">
            <h3 class="text-sm text-gray-700">El ecosistema de Morelos integra de manera estratégica a los
                actores clave del desarrollo tecnológico y la innovación.</h3>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3">
            <label class="flex items-center space-x-2 cursor-pointer transition-colors group">
                <input type="checkbox" v-model="selectedTypes.ies"
                    class="w-4 h-4 text-wine-50 border-gray-300 rounded focus:ring-wine-50">
                <span class="text-sm text-gray-700 border-b-2"
                    :class="!selectedTypes.ies ? 'border-transparent group-hover:border-gray-400' : ''"
                    :style="selectedTypes.ies ? `border-color: ${resourceColors.ies}` : ''">Instituciones de Educación
                    Superior (IES)</span>
            </label>
            <label class="flex items-center space-x-2 cursor-pointer transition-colors group">
                <input type="checkbox" v-model="selectedTypes.ci"
                    class="w-4 h-4 text-wine-50 border-gray-300 rounded focus:ring-wine-50">
                <span class="text-sm text-gray-700 border-b-2"
                    :class="!selectedTypes.ci ? 'border-transparent group-hover:border-gray-400' : ''"
                    :style="selectedTypes.ci ? `border-color: ${resourceColors.ci}` : ''">Centros de Investigación
                    (CI)</span>
            </label>
            <label class="flex items-center space-x-2 cursor-pointer transition-colors group">
                <input type="checkbox" v-model="selectedTypes.company"
                    class="w-4 h-4 text-wine-50 border-gray-300 rounded focus:ring-wine-50">
                <span class="text-sm text-gray-700 border-b-2"
                    :class="!selectedTypes.company ? 'border-transparent group-hover:border-gray-400' : ''"
                    :style="selectedTypes.company ? `border-color: ${resourceColors.company}` : ''">Empresas de base
                    tecnológica</span>
            </label>
            <label class="flex items-center space-x-2 cursor-pointer transition-colors group">
                <input type="checkbox" v-model="selectedTypes.non_profit"
                    class="w-4 h-4 text-wine-50 border-gray-300 rounded focus:ring-wine-50">
                <span class="text-sm text-gray-700 border-b-2"
                    :class="!selectedTypes.non_profit ? 'border-transparent group-hover:border-gray-400' : ''"
                    :style="selectedTypes.non_profit ? `border-color: ${resourceColors.non_profit}` : ''">Organizaciones
                    no gubernamentales</span>
            </label>
            <label class="flex items-center space-x-2 cursor-pointer transition-colors group">
                <input type="checkbox" v-model="selectedTypes.capability"
                    class="w-4 h-4 text-wine-50 border-gray-300 rounded focus:ring-wine-50">
                <span class="text-sm text-gray-700 border-b-2"
                    :class="!selectedTypes.capability ? 'border-transparent group-hover:border-gray-400' : ''"
                    :style="selectedTypes.capability ? `border-color: ${resourceColors.capability}` : ''">Capacidades
                    tecnológicas</span>
            </label>

            <label class="flex items-center space-x-2 cursor-pointer transition-colors group">
                <input type="checkbox" v-model="selectedTypes.tech_service"
                    class="w-4 h-4 text-wine-50 border-gray-300 rounded focus:ring-wine-50">
                <span class="text-sm text-gray-700 border-b-2"
                    :class="!selectedTypes.tech_service ? 'border-transparent group-hover:border-gray-400' : ''"
                    :style="selectedTypes.tech_service ? `border-color: ${resourceColors.tech_service}` : ''">Servicios
                    tecnológicos</span>
            </label>
            <label class="flex items-center space-x-2 cursor-pointer transition-colors group">
                <input type="checkbox" v-model="selectedTypes.academic_offering"
                    class="w-4 h-4 text-wine-50 border-gray-300 rounded focus:ring-wine-50">
                <span class="text-sm text-gray-700 border-b-2"
                    :class="!selectedTypes.academic_offering ? 'border-transparent group-hover:border-gray-400' : ''"
                    :style="selectedTypes.academic_offering ? `border-color: ${resourceColors.academic_offering}` : ''">Oferta
                    educativa</span>
            </label>

        </div>

        <div class="mt-6 pt-6 border-t border-gray-200">
            <h4 class="text-md font-semibold text-gray-800 mb-4">Filtros por sector</h4>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <SectorSelect :model-value="selectedEconomicSector"
                    @update:model-value="$emit('update:selectedEconomicSector', $event)" :items="economicSectors"
                    itemsKey="children" placeholder="Seleccionar un sector económico (ISIC)" />

                <SectorSelect :model-value="selectedOecdSector"
                    @update:model-value="$emit('update:selectedOecdSector', $event)" :items="oecdSectors"
                    itemsKey="children" placeholder="Seleccionar un campo científico y tecnológico (OCDE)" />
            </div>
        </div>
    </div>
</template>

<script setup>
import { resourceColors } from '../Composables/ResourceColors';
import SectorSelect from '../Components/SectorSelect.vue';

defineProps({
    selectedTypes: {
        type: Object,
        required: true
    },
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

defineEmits(['selectAll', 'deselectAll', 'update:selectedEconomicSector', 'update:selectedOecdSector']);
</script>