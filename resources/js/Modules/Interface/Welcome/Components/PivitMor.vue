<template>
    <div class="grid lg:grid-cols-2 gap-12 items-center">
        <div class="space-y-8">
            <TitleLineWithIcon>
                ¿Qué es <strong class="font-extrabold">PIVITMor</strong>?
            </TitleLineWithIcon>
            <p class="text-lg text-justify">
                PIVITMor es una plataforma estratégica que articula la colaboración entre Gobierno, Academia, Industria
                y Sociedad mediante un mecanismo de vinculación inteligente y automatizado. Este ecosistema digital
                facilita que la oferta científica y tecnológica del estado de Morelos se conecte de manera eficiente con
                necesidades reales, impulsando la transferencia de conocimiento, acelerando los procesos de innovación y
                fortaleciendo el desarrollo y la soberanía tecnológica regional.
            </p>

            <div class="w-max h-28">
                <Link :href="route('aboutPivitmor')">
                    <img :src="IMAGES.cta.src" :alt="IMAGES.cta.alt"
                        class="h-22 transition-all duration-500 transform hover:scale-110" loading="lazy" />
                </Link>
            </div>
        </div>
        <div class="w-full flex justify-center">
            <div class="relative w-full overflow-hidden rounded-2xl shadow-2xl bg-slate-100">
                <video lazy autoplay muted controls playsinline loop class="w-full h-auto object-cover md:h-96 h-72"
                    poster="video_poster_pivitmor.avif">
                    <source src="/videos/pivitmor.webm" type="video/webm">
                    Tu navegador no soporta el formato de video.
                </video>
            </div>
        </div>
    </div>
</template>
<script setup>
import TitleLineWithIcon from '@/Components/TitleLineWithIcon.vue';
import { IMAGES } from '@/Utils/Image';
import { Link } from '@inertiajs/vue3';

</script>