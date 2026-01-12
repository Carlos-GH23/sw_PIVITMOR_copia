<template>
    <div class="h-full flex flex-col items-center justify-center gap-2 px-4">
        <img class="h-20 w-20" loading="lazy" :src="ICONS.assistantGold.src" :alt="ICONS.assistantGold.alt" />
        <h3 class="text-2xl font-bold">Asistente virtual PIVITMor</h3>
        <p class="text-gray-700">¿En qué puedo ayudarte hoy?</p>
    </div>
</template>

<script setup lang="ts">
import { ICONS } from '@/Utils/Icons';

</script>
