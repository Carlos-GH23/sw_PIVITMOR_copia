<template>
    <div class="relative min-h-[500px] flex items-center bg-forest-400">
        <div class="container mx-auto px-4 py-16 flex items-center justify-between">
            <div class="hidden xl:block w-1/2">
                <img src="/img/header/PIVITMor-Encabezado.png" alt="Mujeres mexicanas"
                    class="h-full w-full object-contain opacity-80">
            </div>
            <div class="max-w-2xl">
                <h1 class="text-mono-50 text-3xl md:text-6xl font-bold mb-6">
                    Conectando la innovación con las necesidades
                    del sector productivo
                </h1>
                <p class="text-sm md:text-xl mb-8 text-earth-100">
                    Una plataforma inteligente para vincular capacidades
                    tecnológicas de instituciones con demandas de innovación
                    reales del sector industrial de Morelos.
                </p>
                <div class="flex flex-col sm:flex-row gap-4">
                    <button @click="emit('scroll')"
                        class="bg-white/20 hover:bg-white/30 text-white px-8 py-3 rounded-lg font-semibold transition-colors backdrop-blur-sm border border-white/20 flex justify-center gap-1 cursor-pointer">
                        Conoce más
                        <BaseIcon class="animate-bounce animate-once" :path="mdiArrowDown" />
                    </button>
                    <Link :href="route('register')">
                    <button
                        class="bg-transparent hover:bg-white/10 text-white px-8 py-3 rounded-lg font-semibold transition-colors border-2 border-white cursor-pointer">
                        Registrarse
                    </button>
                    </Link>
                </div>
            </div>
        </div>
    </div>
    <div class="w-full bg-forest-400">
        <img src="/img/header/Group.png" alt="" class="w-full h-10 object-cover">
    </div>
</template>
<script setup>
import BaseIcon from '@/Components/BaseIcon.vue';
import { Link } from '@inertiajs/vue3';
import { mdiArrowDown } from '@mdi/js';

const emit = defineEmits(['scroll'])
</script>