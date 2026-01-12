<template>
    <CardForm>
        <template #header>
            <div class="flex gap-2 items-center py-4">
                <BaseIcon class="bg-forest-400 text-mono-100 rounded-lg" :path="mdiShape" size="24" h="h-10" w="w-10" />
                <div>
                    <p class="text-forest-400 text-xl font-bold">
                        Clasificación
                    </p>
                    <p class=" text-sm font-light text-slate-800 dark:text-slate-300">
                        Disciplinas y sectores económicos de la institución
                    </p>
                </div>
            </div>
        </template>

        <CardSection title="Disciplinas científicas y tecnológicas (OCDE)"
            description="Clasificación de disciplinas según la OCDE" :hasDivider="false">
            <OecdSectorRecords :sectors="institution.oecd_sectors" />
        </CardSection>

        <CardSection title="Sectores económicos y productivos (ISIC)"
            description="Clasificación de sectores económicos según ISIC">
            <EconomicSectorRecords :sectors="institution.economic_sectors" />
        </CardSection>

        <!-- <CardSection title="Áreas de conocimiento" description="Áreas de conocimiento de la institución">
            <div v-if="institution.knowledge_areas?.length" class="space-y-2">
                <div v-for="area in institution.knowledge_areas" :key="area.id" class="p-3 border rounded-lg">
                    <p class="font-medium">{{ area.name }}</p>
                </div>
            </div>
            <CardBoxComponentEmpty v-else />
        </CardSection> -->
    </CardForm>
</template>

<script setup>
import BaseIcon from '@/Components/BaseIcon.vue';
import CardForm from '@/Components/CardForm.vue';
import CardSection from '@/Components/CardSection.vue';
import OecdSectorRecords from '@/Components/Domains/Sectors/OecdSectorRecords.vue';
import EconomicSectorRecords from '@/Components/Domains/Sectors/EconomicSectorRecords.vue';
import CardBoxComponentEmpty from '@/Components/CardBoxComponentEmpty.vue';
import { mdiShape } from '@mdi/js';
import { computed, inject, unref } from 'vue';

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

const institution = computed(() => {
    return props.data || unref(inject('institution')) || {};
});
</script>
