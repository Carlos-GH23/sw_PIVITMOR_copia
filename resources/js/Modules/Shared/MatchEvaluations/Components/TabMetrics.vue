<template>
    <CardForm>
        <template #header>
            <div class="flex gap-2 items-center py-4">
                <BaseIcon class="bg-forest-400 text-mono-100 rounded-lg" :path="mdiChartBox" size="24" h="h-10"
                    w="w-10" />
                <div>
                    <p class="text-forest-400 text-xl font-bold">
                        Métricas de impacto
                    </p>
                    <p class=" text-sm font-light text-slate-800 dark:text-slate-300">
                        Define los indicadores clave de rendimiento (KPIs) para medir el éxito y el impacto del
                        proyecto.
                    </p>
                </div>
            </div>
        </template>

        <Accordion type="single" collapsible class="w-full">
            <AccordionItem v-for="item in items" :key="item.value" :value="item.value" :disabled="item.isDisabled">
                <AccordionTrigger>
                    <div class="flex gap-2 items-center pb-2 cursor-pointer">
                        <BaseIcon class="bg-wine-100 text-mono-100 rounded-full" :path="item.icon" size="20" h="h-8"
                            w="w-8" />
                        <p class=" text-lg font-bold" :class="item.hasError ? 'text-error-400' : 'text-forest-400'">
                            {{ item.title }}
                        </p>
                    </div>
                </AccordionTrigger>

                <AccordionContent>
                    <div class="p-1">
                        <component :is="item.component" />
                    </div>
                </AccordionContent>
            </AccordionItem>
        </Accordion>
    </CardForm>
</template>
<script setup>
import BaseIcon from "@/Components/BaseIcon.vue";
import CardForm from "@/Components/CardForm.vue";
import { mdiChartBox } from "@mdi/js";
import {
    Accordion,
    AccordionContent,
    AccordionItem,
    AccordionTrigger,
} from '@/Components/ui/accordion'
import { inject } from "vue";
import { useAccordion } from "../Composables/useAccordion";

const { allowedImpactMetrics } = inject("props");
const items = useAccordion(allowedImpactMetrics);
</script>