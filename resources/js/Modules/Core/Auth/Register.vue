<script setup>
import HeadLogo from '@/Components/HeadLogo.vue';
import LayoutWelcome from '@/Layouts/LayoutWelcome.vue';
import { IMAGES } from '@/Utils/Image';
</script>

<template>
    <HeadLogo title="Iniciar sesión" />
    <LayoutWelcome>
        <div class="flex min-h-screen items-center justify-center">
            <div class="max-w-4xl h-full rounded-md py-4 px-10 bg-forest-400">
                <h1 class="text-center py-12 text-earth-50 font-bold md:text-4xl">
                    Registro
                </h1>

                <div class="h-96 flex flex-col items-center justify-between p-6 bg-sand-100">
                    <div class="py-6">
                        <img class="w-52 h-32" :src="IMAGES.keyMx.src" loading="lazy" >
                    </div>
                    <button
                        class="w-96 p-2 rounded-sm text-white hover:cursor-pointer hover:opacity-90 transition-all bg-wine-400">
                        Regístrate con Llave MX o Crea tu cuenta
                    </button>

                    <div class="w-full bg-sand-100">
                        <img :src="IMAGES.layerForest" loading="lazy" class="w-full h-10 object-cover">
                    </div>
                </div>
            </div>
        </div>
    </LayoutWelcome>
</template>
