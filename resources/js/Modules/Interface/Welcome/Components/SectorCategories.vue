<template>
    <div class="mb-12">
        <div class="flex flex-wrap justify-center gap-4">
            <div v-for="(sector) in economicSectors" :key="sector.name" @click="$emit('search', sector.name)"
                :class="[
                    'flex flex-col items-center cursor-pointer transition-all p-2 rounded-lg relative',
                    selectedSector === sector.name 
                        ? 'shadow-xl border-b-4 border-wine-50 bg-gray-100' 
                        : 'hover:opacity-80 hover:shadow-md'
                ]">
                <img :src="sector.src" loading="lazy" class="w-14 h-14 md:w-16 md:h-16 object-fit" :alt="sector.name" />
                <div v-if="selectedSector === sector.name" 
                    class="absolute -top-2 -right-2 bg-wine-50 text-white rounded-full w-6 h-6 flex items-center justify-center text-sm font-bold shadow-lg">
                    ✕
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { economicSectors } from '../Composables/useDictionaries';

defineProps({
    selectedSector: {
        type: String,
        default: null
    }
});

defineEmits(['search']);
</script>

<style scoped>
.scrollbar-hide::-webkit-scrollbar {
    display: none;
}

.scrollbar-hide {
    -ms-overflow-style: none;
    scrollbar-width: none;
}
</style>
