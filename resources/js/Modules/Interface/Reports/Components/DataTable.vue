<template>
    <CardBox>
        <div class="mb-4">
            <div class="flex items-center">
                <BaseIcon class="text-forest-400" :path="mdiFileDocumentOutline" size="24" h="h-10" w="w-10" />
                <h3 class="text-forest-400 text-xl font-bold">{{ title }}</h3>
            </div>
            <span class="text-sm font-light text-slate-800 dark:text-slate-300">
                {{ description }}
            </span>
        </div>

        <div class="overflow-x-auto border rounded-xl mb-4">
            <table>
                <slot />
            </table>
        </div>
    </CardBox>
</template>
<script setup>
import BaseIcon from '@/Components/BaseIcon.vue';
import CardBox from '@/Components/CardBox.vue';
import { mdiFileDocumentOutline } from '@mdi/js';

defineProps({
    title: {
        type: String,
        default: "Datos",
    },
    description: {
        type: String,
        default: "Registros en sistema",
    },
    icon: {
        type: String,
        default: mdiFileDocumentOutline,
    }
});

</script>