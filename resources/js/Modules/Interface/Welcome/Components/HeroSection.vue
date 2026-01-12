<template>
    <div id="hero-section" class="relative w-full flex flex-col -mt-20">
        <div class="absolute inset-0">
            <img :src="IMAGES.heroBackground.src" :alt="IMAGES.heroBackground.alt" loading="lazy"
                class="w-full h-full object-cover object-center" />
        </div>

        <div class="relative flex-1 flex flex-col">
            <header
                class="flex flex-col-reverse 2xl:flex-row justify-between items-center px-6 md:px-12 2xl:px-24 gap-6 mb-10 xl:mb-20">
                <img :src="IMAGES.pivitmorIcon.src" :alt="IMAGES.pivitmorIcon.alt" loading="lazy"
                    class="h-30 xl:h-28 w-auto object-contain mx-auto xl:mx-0" />

                <img :src="IMAGES.pivitmorLogoDarkAlt.src" :alt="IMAGES.pivitmorLogoDarkAlt.alt" loading="lazy"
                    class="h-28 xl:h-44 w-auto object-contain mx-auto xl:mx-0" />
            </header>

            <main class="flex-1 flex flex-col-reverse xl:flex-row items-center justify-center">
                <div class="w-full px-0 xl:px-10 xl:max-w-5xl">
                    <img :src="IMAGES.hero.src" :alt="IMAGES.hero.alt" loading="lazy"
                        class="w-full h-auto object-contain drop-shadow-lg" />
                </div>

                <div class="w-full max-w-2xl text-center xl:text-left space-y-8 px-6 xl:px-16">
                    <p class="text-base xl:text-lg text-sand-50 leading-relaxed text-justify">
                        La Plataforma Inteligente de Vinculación para la Innovación y el Desarrollo Tecnológico de
                        Morelos (<strong>PIVITMor</strong>) impulsa la colaboración entre los actores de la Penta-hélice: academia,
                        industria, gobierno, sociedad y medio ambiente, conectando necesidades tecnológicas con
                        capacidades y servicios tecnológicos especializados. <br>
                        Registra tu organización, da visibilidad a tus capacidades, publica tus necesidades y explora un
                        padrón confiable de instituciones para identificar aliados estratégicos que transformen los
                        retos del entorno en soluciones innovadoras con impacto regional y social.

                    </p>
                </div>
            </main>
        </div>
    </div>
</template>
<script setup>
import BaseIcon from '@/Components/BaseIcon.vue';
import { mdiArrowRight, mdiMagnify } from '@mdi/js';
import { ref, onMounted, onUnmounted } from 'vue';
import gsap from 'gsap';
import { ScrollTrigger } from 'gsap/ScrollTrigger';
import { IMAGES } from '@/Utils/Image';

const emit = defineEmits(['scroll'])
const search = ref(null);

onMounted(() => {
    gsap.registerPlugin(ScrollTrigger);

    gsap.set("#navbar", {
        position: 'fixed',
        bottom: 0,
        top: 'auto',
        opacity: 1
    });

    ScrollTrigger.create({
        trigger: "#hero-section",
        start: "top top",
        end: "50% top",
        onEnter: () => {
            gsap.set("#navbar", { top: 0, bottom: 'auto' });
            gsap.fromTo("#navbar",
                { opacity: 0 },
                { opacity: 1, duration: 0.3, ease: 'power2.out' }
            );
        },
        onEnterBack: () => {
            gsap.set("#navbar", { top: 0, bottom: 'auto' });
            gsap.to("#navbar", { opacity: 1, duration: 0.3 });
        },
        onLeaveBack: () => {
            gsap.to("#navbar", {
                opacity: 0,
                duration: 0.3,
                onComplete: () => {
                    gsap.set("#navbar", { bottom: 0, top: 'auto' });
                    gsap.to("#navbar", { opacity: 1, duration: 0.3 });
                }
            });
        }
    });
});

onUnmounted(() => {
    ScrollTrigger.getAll().forEach(trigger => trigger.kill());
})
</script>