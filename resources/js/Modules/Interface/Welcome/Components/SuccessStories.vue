<template>
    <div class="text-center mb-16">
        <TitleLineWithIcon class="mx-auto mb-6">
            Casos de <strong class="font-extrabold">éxito</strong>
        </TitleLineWithIcon>
        <p class="text-lg mx-auto leading-relaxed">
            Conoce experiencias reales de colaboración y resultados tangibles. En la sección Casos de Éxito, descubrirás
            cómo empresas, instituciones de educación superior, centros de investigación y académicos han concretado
            alianzas estratégicas, desarrollado soluciones tecnológicas y atendido necesidades reales mediante el uso de
            PIVITMor. Estos casos evidencian que una vinculación bien estructurada genera impacto, fortalece capacidades
            y acelera la innovación. Inspírate en resultados comprobables y forma parte del ecosistema que impulsa el
            desarrollo tecnológico en Morelos.
        </p>
    </div>

    <div v-if="successStories?.length > 0" class="grid md:grid-cols-2 gap-8 mb-12">
        <CardSuccessStory v-for="(item, index) in successStories" :key="index" :successStory="item" />
    </div>
    <CardBoxComponentEmpty v-else />

    <div class="flex flex-col sm:flex-row gap-4 justify-center">
        <Link v-if="successStories?.length > 0" :href="route('welcome.successStories')"
            class="bg-wine-400 text-white px-8 py-3 rounded-lg font-semibold transition-colors duration-200 shadow-lg hover:shadow-xl hover:opacity-90 cursor-pointer">
            Ver casos de éxito
        </Link>
        <Link :href="route('register')"
            class="bg-wine-400 text-white px-8 py-3 rounded-lg font-semibold transition-colors duration-200 shadow-lg hover:shadow-xl hover:opacity-90 cursor-pointer">
            ¡Quiero registrarme!
        </Link>
    </div>
</template>
<script setup>
import { Link } from '@inertiajs/vue3';
import TitleLineWithIcon from '@/Components/TitleLineWithIcon.vue';
import CardSuccessStory from './CardSuccessStory.vue';
import CardBoxComponentEmpty from '@/Components/CardBoxComponentEmpty.vue';

defineProps({
    successStories: {
        type: Object,
        default: () => ({}),
    },
})

</script>