<template>
    <div class="grid lg:grid-cols-2 gap-12 items-center bg-sand-50 rounded-tr-4xl rounded p-4">
        <div class="space-y-8">
            <TitleLineWithIcon>
                ¿Qué es <strong class="font-extrabold">PIVITMor</strong>?
            </TitleLineWithIcon>
            <p class="text-lg text-justify">
                PIVITMor es una plataforma pionera que potencia la colaboración
                estratégica entre Gobierno, Academia, Industria y Sociedad,
                mediante un proceso de vinculación automático e inteligente. Este
                ecosistema digital permite que la oferta científica y tecnológica del
                estado de Morelos llegue rápidamente a quienes más la necesitan,
                maximizando el impacto de la investigación, acelerando la
                innovación y fortaleciendo la soberanía tecnológica regional.
            </p>

            <div class="flex items-center justify-center">
                <div class="w-max h-28">
                    <Link :href="route('aboutPivitmor')">
                    <img src="/img/container/CTA1.png"
                        class="h-22 transition-all duration-500 transform hover:scale-110" />
                    </Link>
                </div>
            </div>
        </div>
        <div class="w-full">
            <iframe class="w-full md:h-96 h-72" src="https://www.youtube.com/embed/-rcHhBzyjPc?si=UXkec9CZDzjqpiqc"
                title="YouTube video player" frameborder="0"
                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
        </div>
    </div>
</template>
<script setup>
import TitleLineWithIcon from '@/Components/TitleLineWithIcon.vue';
import { Link } from '@inertiajs/vue3';

</script>