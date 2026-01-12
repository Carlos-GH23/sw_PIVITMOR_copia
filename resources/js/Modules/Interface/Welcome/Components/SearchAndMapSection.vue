<template>
    <TitleLineWithIcon class="mx-auto mb-6">
        Buscador <strong class="font-extrabold">inteligente</strong>
    </TitleLineWithIcon>
    <div class="max-w-7xl mx-auto text-center mb-16">
        <p class="text-lg mx-auto leading-relaxed">
            Explora, desde un solo lugar, la riqueza del ecosistema de innovación de Morelos. El Buscador Inteligente de
            PIVITMor te permite localizar instituciones de educación superior (IES), centros de investigación (CI),
            oferta educativa, capacidades y servicios tecnológicos, así como necesidades del sector productivo,
            instalaciones especializadas, infraestructura tecnológica y conferencias impartidas por académicos. Basta
            con escribir una palabra clave o seleccionar un sector para descubrir oportunidades reales de vinculación,
            colaboración e innovación. Aquí, la información se convierte en conexiones que sí generan valor.
        </p>
    </div>

    <div class="max-w-2xl mx-auto px-4 sm:px-0">
        <div class="relative">
            <input v-model="searchQuery" type="text" placeholder="¿Qué estás buscando?" class="w-full px-6 py-4 text-lg border-2 border-wine-400 rounded-full shadow-lg
               outline-none focus:outline-none
               focus:border-wine-400
               focus:ring-2 focus:ring-wine-400 focus:ring-offset-0" />

            <button @click="search" class="bg-wine-400 hover:opacity-90 text-white rounded-full font-semibold transition-colors
               flex items-center justify-center gap-2
               cursor-pointer select-none active:scale-95 active:opacity-90
               w-full mt-3 py-3 px-6
               sm:w-auto sm:mt-0 sm:px-8 sm:py-2 sm:absolute sm:right-2 sm:top-2.5">
                <BaseIcon :path="mdiMagnify" :size="20" class="shrink-0 w-5 h-5" />
                <span class="whitespace-nowrap">Busca soluciones ahora</span>
            </button>
        </div>
    </div>

    <h2 class="text-earth-100 text-3xl lg:text-4xl font-bold mb-6">
        Mapa del ecosistema de Innovación en Morelos
    </h2>
    <div class="grid lg:grid-cols-2 gap-12 items-start">
        <div class="space-y-6">
            <p class="text-lg text-justify leading-relaxed mb-4">
                Explora el Ecosistema de Innovación de Morelos desde una perspectiva integral y dinámica. El Mapa del
                Ecosistema de Innovación de PIVITMor te permite identificar instituciones de educación superior, centros
                de investigación, empresas, laboratorios y proyectos estratégicos distribuidos en el estado. Descubre
                quiénes generan conocimiento y tecnología, dónde se desarrollan las iniciativas de innovación y cómo
                integrarte a una red activa de colaboración que facilita la conexión entre actores clave para fortalecer
                el desarrollo tecnológico regional.
            </p>
            <EntityMap :resources="ecosystemResources" />
        </div>

        <div class="space-y-6">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div v-for="item in ecosystemSectors" :key="item.category"
                    class="bg-white rounded-xl p-4 shadow-lg transition-all duration-300 hover:shadow-2xl hover:-translate-y-1 hover:scale-105">
                    <div class="flex items-center gap-3 mb-2">
                        <img :src="item.icon" :alt="item.category" class="w-10 h-10 aspect-square object-contain"
                            loading="lazy" />
                        <span class="font-bold text-gray-600">{{ item.amount ?? 0 }}+</span>
                    </div>
                    <p class="text-sm text-gray-600">{{ item.category }}</p>
                </div>
            </div>
        </div>
    </div>
</template>
<script setup>
import TitleLineWithIcon from '@/Components/TitleLineWithIcon.vue';
import { ref, toRef } from 'vue'
import EntityMap from './EntityMap.vue';
import { router } from "@inertiajs/vue3";
import { useEcosystem } from '../Composables/useEcosystem';
import { mdiMagnify } from '@mdi/js';
import BaseIcon from '@/Components/BaseIcon.vue';

const props = defineProps({
    ecosystemResources: {
        type: Array,
        default: () => []
    },
    ecosystemStats: {
        type: Object,
        required: true
    }
});

const { ecosystemSectors } = useEcosystem(toRef(props, 'ecosystemStats'));

const searchQuery = ref('')
const search = () => {
    router.get(route("welcome.smartSearch"), {
        search: searchQuery.value
    })
}
</script>