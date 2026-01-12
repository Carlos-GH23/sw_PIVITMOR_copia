<template>
    <div class="text-center space-y-4 mb-12">
        <TitleLineWithIcon class="mx-auto">
            Búsquedas específicas por sector
        </TitleLineWithIcon>
        <p class="text-lg max-w-4xl mx-auto">
            PIVITMor atiende una diversidad de sectores estratégicos clave para el desarrollo económico del
            estado.
            Selecciona un sector para explorar capacidades tecnológicas asociadas.
        </p>
    </div>

    <swiper :navigation="true" :keyboard="true" :autoplay="{
        delay: 2500,
        disableOnInteraction: false
    }" :modules="[Navigation, Pagination, Keyboard, Autoplay]" :slides-per-view="2" :pagination="{ clickable: true }"
        :breakpoints="{
            '640': { slidesPerView: 2 },
            '768': { slidesPerView: 4 },
            '1280': { slidesPerView: 6 }
        }" :space-between="20" class="mySwiper">
        <swiper-slide v-for="sector in economicSectors" :key="sector.name"
            class="flex items-center justify-center py-8">
            <Link :href="route('welcome.smartSearch')" :data="{ social_sector: sector.name }">
                <div
                    class="flex flex-col items-center justify-center transform hover:scale-110 transition-all duration-300">
                    <img :src="sector.src" :alt="sector.name" class="w-28 h-28 object-fit mx-auto" loading="lazy" />
                </div>
            </Link>
        </swiper-slide>
    </swiper>
</template>

<script setup>
import TitleLineWithIcon from '@/Components/TitleLineWithIcon.vue'
import { Swiper, SwiperSlide } from 'swiper/vue';
import { Navigation, Pagination, Keyboard, Autoplay } from 'swiper/modules';
import 'swiper/css';
import 'swiper/css/navigation';
import 'swiper/css/pagination';
import 'swiper/css/keyboard';
import 'swiper/css/autoplay';
import { Link } from '@inertiajs/vue3';
import { economicSectors } from '../Composables/useDictionaries';

</script>