<template>
    <div class="bg-sand-50 rounded rounded-tr-4xl py-10">
        <TitleLineWithIcon class="mx-auto mb-6">
            Buscador <strong class="font-extrabold">inteligente</strong>
        </TitleLineWithIcon>
        <div class="mx-auto text-center mb-16">
            <p class="text-xl mx-auto leading-relaxed">
                Explora las capacidades tecnológicas, demandas del sector productivo, IES/CIs o
                académicos afines a tu objetivo. con un motor de búsqueda potenciado por
                inteligencia artificial.
            </p>
        </div>

        <div class="mx-auto max-w-2xl flex flex-col items-center space-y-4 px-2">
            <input v-model="searchQuery" type="text" placeholder="¿Qué estás buscando?"
                class="w-full max-w-md px-6 py-4 text-lg border-2 border-wine-400 rounded-full focus:border-wine-400 focus:outline-none shadow-lg" />

            <button @click="search"
                class="bg-wine-400 hover:opacity-90 text-white px-8 py-2 rounded-full font-semibold transition-colors cursor-pointer">
                Busca soluciones ahora
            </button>
        </div>


    </div>

    <h2 class="text-earth-100 text-3xl lg:text-4xl font-bold mb-6 text-center">
        Consulta el catálogo de ofertas y necesidades tecnológicas por sector
    </h2>
    <div class="mx-auto text-center mb-16">
        <p class="text-xl mx-auto leading-relaxed">
            Navega por sectores estratégicos como salud, TIC, energía, agroindustria y más.
            Encuentra oportunidades de colaboración alineadas a tu campo.
        </p>
    </div>
    <swiper :navigation="true" :keyboard="true" :autoplay="{
        delay: 2500,
        disableOnInteraction: false
    }" :modules="[Navigation, Pagination, Keyboard, Autoplay]" :slides-per-view="6" :pagination="{ clickable: true }"
        :space-between="20" class="mySwiper">
        <swiper-slide v-for="sector in economicSectors" :key="sector.name"
            class="flex items-center justify-center py-8">
            <Link :href="route('welcome.smartSearch')">
            <div
                class="flex flex-col items-center justify-center transform hover:scale-110 transition-all duration-300">
                <img :src="sector.src" :alt="sector.name" class="w-28 h-28 object-contain mx-auto" />
            </div>
            </Link>
        </swiper-slide>
    </swiper>

    <p class="text-xl text-earth-100 text-center">
        Selecciona un sector para explorar capacidades tecnológicas asociadas.
    </p>
</template>
<script setup>
import TitleLineWithIcon from '@/Components/TitleLineWithIcon.vue';
import { ref } from 'vue'
import { router } from "@inertiajs/vue3";
import { Swiper, SwiperSlide } from 'swiper/vue';
import { Navigation, Pagination, Keyboard, Autoplay } from 'swiper/modules';
import 'swiper/css';
import 'swiper/css/navigation';
import 'swiper/css/pagination';
import 'swiper/css/keyboard';
import 'swiper/css/autoplay';
import { Link } from '@inertiajs/vue3';
import { economicSectors } from '../../Composables/useDictionaries';

const searchQuery = ref('')
const search = () => { router.get(route("welcome.smartSearch")) }

</script>