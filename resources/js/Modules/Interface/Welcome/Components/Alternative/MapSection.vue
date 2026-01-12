<template>
    <TitleLineWithIcon class="mx-auto mb-6">
        <strong class="font-extrabold">Mapa del ecosistema</strong>de Innovación
    </TitleLineWithIcon>
    <div class="max-w-7xl mx-auto text-center mb-16">
        <p class="text-xl mx-auto leading-relaxed">
            Visualiza a los actores clave que impulsan la innovación en el estado. Conoce instituciones, empresas,
            centros de investigación y proyectos
            activos.
        </p>
    </div>
    <div class="grid lg:grid-cols-2 gap-12 items-start">
        <div class="space-y-6">
            <EntityMap />
            <div class="flex justify-center">
                <div class="w-max h-28">
                <Link :href="route('aboutPivitmor')">
                <img src="/img/container/CTA1.png" class="h-22 transition-all duration-500 transform hover:scale-110" />
                </Link>
            </div>
            </div>
        </div>

        <div class="space-y-6">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div v-for="item in statisticsMap" class="bg-white rounded-xl p-4 shadow-lg">
                    <div class="flex items-center gap-3 mb-2">
                        <img :src="item.src" :alt="item.src" class="w-10 h-10 aspect-square object-contain" />
                        <span class="font-bold text-gray-600">{{ item.title }}</span>
                    </div>
                    <p class="text-sm text-gray-600">{{ item.description }}</p>
                </div>
            </div>
        </div>
    </div>
</template>
<script setup>
import TitleLineWithIcon from '@/Components/TitleLineWithIcon.vue';
import { ref } from 'vue'
import { Link, router } from "@inertiajs/vue3";
import { statisticsMap } from '../../Composables/useDictionaries';
import EntityMap from '../EntityMap.vue';

const searchQuery = ref('')
const search = () => { router.get(route("welcome.smartSearch")) }
</script>