<template>
    <CardForm>
        <template #header>
            <div class="flex flex-wrap gap-2 items-start md:items-center py-4">
                <BaseIcon class="bg-forest-400 text-mono-100 rounded-lg" :path="mdiOffer" size="24" h="h-10" w="w-10" />
                <div class="flex flex-col w-full md:w-auto">
                    <p class="text-forest-400 text-lg md:text-xl font-bold">
                        {{ capabilityRequirementMatch.data.capability.title }}
                    </p>
                    <div class="flex flex-col md:flex-row md:flex-wrap gap-3 md:gap-6">
                        <div class="flex gap-1 md:gap-2 text-sm md:text-base">
                            <span>Categoría:</span>
                            <strong>{{ parentCategory }}</strong>
                        </div>
                        <div class="flex gap-1 md:gap-2 text-sm md:text-base">
                            <span>Estatus:</span>
                            <Badge size="md">
                                Borrador
                            </Badge>
                        </div>
                        <div v-if="form.start_date && form.end_date" class="flex gap-1 md:gap-2 text-sm md:text-base">
                            <span>Periodo:</span>
                            <div class="flex items-center gap-2 font-medium">
                                {{ form.start_date }}
                                <BaseIcon :path="mdiArrowRight" size="16" h="h-4" w="w-4" />
                                {{ form.end_date }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </template>
        <ImpactKPIs />
    </CardForm>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
        <StorySummary />
        <ImpactDetail />
    </div>
</template>
<script setup>
import Badge from "@/Components/Badge.vue";
import BaseIcon from "@/Components/BaseIcon.vue";
import CardForm from "@/Components/CardForm.vue";
import { mdiArrowRight, mdiOffer } from "@mdi/js";
import { inject } from "vue";
import ImpactKPIs from "./Summary/ImpactKPIs.vue";
import { useSummary } from "../Composables/useSummary";
import StorySummary from "./Summary/StorySummary.vue";
import ImpactDetail from "./Summary/ImpactDetail.vue";

const form = inject('matchEvaluationForm')
const { capabilityRequirementMatch, categories } = inject('props')

const { parentCategory } = useSummary(form, { categories })
</script>