<template>
    <HeadLogo title="¿Qué es PIVITMor?" />
    <LayoutWelcome>
        <SectionWrapper>
            <div class="text-center mb-16">
                <TitleLineWithIcon class="mx-auto mb-6">
                    ¿Qué es <strong class="font-extrabold">PIVITMor</strong>?
                </TitleLineWithIcon>
                <div class="w-24 h-1 bg-wine-50 mx-auto rounded-full" />
            </div>

            <div class="grid lg:grid-cols-2 gap-12 items-center">
                <div class="order-2 lg:order-1">
                    <div
                        class="bg-wine-50 rounded-3xl p-8 md:p-10 shadow-2xl transform hover:scale-105 transition-all duration-300">
                        <div class="text-white">
                            <h2 class="text-2xl md:text-3xl font-bold mb-6 leading-tight">
                                Únete a PIVITMor y conecta con la innovación
                            </h2>

                            <p class="text-rose-100 text-lg mb-8 leading-relaxed text-justify">
                                Descubre oportunidades, impulsa proyectos y colabora para transformar
                                el futuro de Morelos.
                            </p>

                            <button @click="handleRegister"
                                class="bg-earth-100 hover:text-wine-400 text-wine-800 font-semibold px-8 py-4 rounded-xl transition-all duration-300 transform hover:scale-105 hover:shadow-lg text-lg w-full md:w-auto cursor-pointer">
                                Regístrate y comienza ahora
                            </button>
                        </div>
                    </div>
                </div>

                <div class="order-1 lg:order-2">
                    <div class="prose prose-lg max-w-none">
                        <p class="text-lg leading-relaxed mb-6 text-justify">
                            PIVITMor es la <strong class="text-wine-50">Plataforma Inteligente de Vinculación</strong>
                            para la Innovación y el Desarrollo Tecnológico de Morelos.
                        </p>

                        <p class="text-lg leading-relaxed mb-8 text-justify">
                            Diseñada para conectar de forma ágil y estratégica a gobierno, academia,
                            industria y sociedad. Integra herramientas de inteligencia artificial,
                            geolocalización y gestión colaborativa para transformar ideas en
                            <span class="text-wine-50 font-semibold">soluciones reales</span> que impulsan la
                            innovación,
                            la competitividad y el desarrollo sostenible.
                        </p>

                        <div class="grid md:grid-cols-2 gap-4 mt-8">
                            <div class="flex items-center space-x-3">
                                <div class="w-3 h-3 bg-earth-100 rounded-full"></div>
                                <span class="text-slate-700 font-medium">Inteligencia Artificial</span>
                            </div>
                            <div class="flex items-center space-x-3">
                                <div class="w-3 h-3 bg-earth-100 rounded-full"></div>
                                <span class="text-slate-700 font-medium">Geolocalización</span>
                            </div>
                            <div class="flex items-center space-x-3">
                                <div class="w-3 h-3 bg-earth-100 rounded-full"></div>
                                <span class="text-slate-700 font-medium">Gestión Colaborativa</span>
                            </div>
                            <div class="flex items-center space-x-3">
                                <div class="w-3 h-3 bg-earth-100 rounded-full"></div>
                                <span class="text-slate-700 font-medium">Desarrollo Sostenible</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </SectionWrapper>
        <SectionWrapper :has-layer="false">
            <div class="text-center mb-16">
                <TitleLineWithIcon class="mx-auto mb-6">
                    <strong class="font-extrabold">Beneficios</strong> para tipo de usuario
                </TitleLineWithIcon>
                <p class="text-lg max-w-3xl mx-auto">
                    PIVITMor ofrece soluciones específicas para cada sector, creando un ecosistema integral de
                    innovación
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 max-w-7xl mx-auto">
                <div v-for="item in benefits"
                    class="group bg-gradient-to-br from-white to-gray-50 rounded-2xl p-8 shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 border border-gray-100">
                    <div class="flex items-center mb-6">
                        <div
                            class="w-18 h-18 b rounded-2xl flex items-center justify-center mr-4 group-hover:scale-110 transition-transform duration-300">
                            <img :src="item.src" :alt="item.title" loading="lazy" >
                        </div>
                        <h3 class="text-2xl font-bold text-wine-50">
                            {{ item.title }}
                        </h3>
                    </div>
                    <p class="leading-relaxed">
                        {{ item.description }}
                    </p>
                </div>
            </div>
        </SectionWrapper>
    </LayoutWelcome>
</template>
<script setup>
import HeadLogo from '@/Components/HeadLogo.vue';
import LayoutWelcome from '@/Layouts/LayoutWelcome.vue';
import { router } from "@inertiajs/vue3";
import { benefits } from '../Composables/useDictionaries';
import TitleLineWithIcon from '@/Components/TitleLineWithIcon.vue';
import SectionWrapper from '../Components/SectionWrapper.vue';

const handleRegister = () => {
    router.get(route('register'));
}
</script>