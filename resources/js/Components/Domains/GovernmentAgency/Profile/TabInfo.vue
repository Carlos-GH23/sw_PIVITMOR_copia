<template>
    <CardForm>
        <template #header>
            <div class="flex gap-2 items-center py-4">
                <BaseIcon class="bg-forest-400 text-mono-100 rounded-lg" :path="mdiInformation" size="24" h="h-10"
                    w="w-10" />
                <div>
                    <p class="text-forest-400 text-xl font-bold">
                        Información general
                    </p>
                    <p class=" text-sm font-light text-slate-800 dark:text-slate-300">
                        Datos básicos de la dependencia gubernamental
                    </p>
                </div>
            </div>
        </template>

        <div class="flex flex-col md:items-center md:flex-row gap-4">
            <ImageFrame :src="data.logo?.path" alt="Logo de la dependencia" type="image" />

            <div class="flex flex-col space-y-4">
                <h3 class="text-lg font-semibold text-foreground mb-2">{{ data.name }}</h3>

                <div class="flex items-center space-x-2">
                    <label class="text-md font-medium text-forest-400">Siglas:
                        <span class="text-foreground font-light">
                            {{ data.acronym || 'Sin datos' }}
                        </span>
                    </label>
                </div>

                <div class="flex items-center space-x-2">
                    <label class="text-md font-medium text-forest-400">Nivel de gobierno:
                        <span class="text-foreground font-light">
                            {{ data.government_level?.name || 'Sin datos' }}
                        </span>
                    </label>
                </div>

                <div class="flex items-center space-x-2">
                    <label class="text-md font-medium text-forest-400">Sector:
                        <span class="text-foreground font-light">
                            {{ data.government_sector?.name || 'Sin datos' }}
                        </span>
                    </label>
                </div>

                <div class="flex items-center space-x-2">
                    <label class="text-md font-medium text-forest-400">Ubicación:
                        <span class="text-foreground font-light">
                            {{ data.location?.full_address || 'Sin datos' }}
                        </span>
                    </label>
                </div>
            </div>
        </div>

        <LabelText label="Misión" :text="data.mission" />
        <LabelText label="Visión" :text="data.vision" />
        <LabelText label="Objetivos" :text="data.objectives" />

        <LabelText label="Palabras clave">
            <BadgeList :items="data.keywords" />
        </LabelText>
    </CardForm>
</template>

<script setup>
import BadgeList from '@/Components/BadgeList.vue';
import BaseIcon from '@/Components/BaseIcon.vue';
import CardForm from '@/Components/CardForm.vue';
import ImageFrame from '@/Components/ImageFrame.vue';
import LabelText from '@/Components/LabelText.vue';
import { mdiInformation } from '@mdi/js';

const props = defineProps({
    hasBorder: {
        type: Boolean,
        default: false,
    },
    data: {
        type: Object,
        required: false,
    },
});
</script>
