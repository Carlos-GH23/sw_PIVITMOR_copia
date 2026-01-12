<template>
    <TitleLineWithIcon class="mx-auto mb-6">
        ¡Únete a la comunidad de <strong class="font-extrabold">innovadores en Morelos</strong>!
    </TitleLineWithIcon>
    <div class="max-w-4xl mx-auto text-center mb-16">
        <p class="text-xl mx-auto leading-relaxed">
            Forma parte de una red colaborativa en la que las ideas se convierten en soluciones tecnológicas reales. La
            innovación no ocurre sola: comienza cuando participas, te vinculas y decides impulsar el cambio.
        </p>
    </div>

    <div class="grid md:grid-cols-2 gap-8 mb-12">
        <RegistrationCard v-for="user in typeUsers" :key="user.title" v-bind="user" />
    </div>
</template>

<script setup>
import TitleLineWithIcon from '@/Components/TitleLineWithIcon.vue';
import { typeUsers } from '../Composables/useDictionaries';
import RegistrationCard from './RegistrationCard.vue';
</script>