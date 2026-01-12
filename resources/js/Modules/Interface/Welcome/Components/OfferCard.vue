<template>
    <div
        class="group rounded overflow-hidden shadow-lg hover:cursor-pointer hover:scale-110 hover:shadow-2xl transition-all duration-300">
        <div class="relative">
            <div>
                <img loading="lazy" class="w-full h-52 object-cover" :src="cover || IMAGES.image.src" 
                    :alt="`Imagen de ${title}`"
                    @error="$event.target.src = IMAGES.image.src">
                <div
                    class="group-hover:bg-transparent transition duration-300 absolute bottom-0 top-0 right-0 left-0 bg-gray-900 opacity-25">
                </div>
            </div>

            <div v-if="resourceType"
                class="absolute top-2 right-2 bg-white/90 backdrop-blur-sm px-3 py-1 rounded-full text-xs font-semibold text-earth-300 shadow-md flex items-center gap-2">
                <template v-if="resourceType === 'institution' && institutionCategory">
                    {{ institutionCategory }}
                </template>
                <template v-else>
                    {{ resourceTypeLabel }}
                </template>
            </div>

            <div
                class="flex absolute bottom-0 left-0 bg-wine-400 px-4 py-2 text-mono-100 text-sm group-hover:bg-wine-50 group-hover:text-mono-50 transition duration-500 ease-in-out">
                {{ sector }}
            </div>
        </div>

        <div class="">
            <div class="px-6 py-4 h-20">
                <h3
                    class="font-semibold line-clamp-3 text-justify text-md text-earth-200 group-hover:text-earth-300 transition duration-300 ease-in-out">
                    {{ title }}
                </h3>
            </div>

            <div v-if="matches && matches.length > 0" class="px-6 pb-2">
                <div class="flex flex-wrap gap-1">
                    <span v-for="match in matches.slice(0, 3)" :key="match"
                        class="text-xs bg-green-100 text-green-800 px-2 py-1 rounded">
                        {{ match }}
                    </span>
                </div>
            </div>

            <div class="px-6 py-4 flex items-center"
                :class="sector && sector !== 'Sin sector' ? 'justify-between' : 'justify-end'">
                <img v-if="sector && sector !== 'Sin sector'" loading="lazy" class="w-12 h-12" :src="icon"
                    :alt="`Icono de ${sector}`" @error="$event.target.style.display = 'none'">

                <span class="py-1 text-sm font-regular text-mono-400 mr-1 flex flex-row items-center text-right">
                    {{ institution }}
                </span>
            </div>
        </div>
    </div>
</template>

<script setup>
import { computed } from 'vue';
import { IMAGES } from '@/Utils/Image';

const props = defineProps({
    title: {
        type: String,
    },
    sector: {
        type: String,
    },
    cover: {
        type: String,
    },
    icon: {
        type: String,
    },
    institution: {
        type: String,
    },
    institutionCategory: {
        type: String,
        default: ''
    },
    description: {
        type: String,
    },
    matches: {
        type: Array,
        default: () => []
    },
    resourceType: {
        type: String,
        default: 'capability'
    }
});

const resourceTypeLabel = computed(() => {
    const labels = {
        'institution': 'Institución',
        'capability': 'Capacidad Tecnológica',
        'requirement': 'Necesidad Tecnológica',
        'technology_service': 'Servicio Tecnológico',
        'academic_offering': 'Oferta Académica',
        'facility': 'Instalación especializada',
        'equipment': 'Infraestructura tecnológica',
        'conference': 'Conferencia',
    };
    return labels[props.resourceType] || 'Capacidad';
});
</script>