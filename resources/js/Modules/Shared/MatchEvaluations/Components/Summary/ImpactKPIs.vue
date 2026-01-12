<template>
    <CardSection title="Resumen de impacto"
        :description="`Notas: KPIs calculados a fecha de corte el día 15 de cada mes. Metodología: ${form.emissions_methodology ?? 'N/A'}`"
        :has-divider="false">
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
            <CardKPI title="Patentes / Prototipos" :icon="mdiHeadLightbulb">
                <template #content>
                    <span class="text-3xl font-bold py-2">
                        {{ form.patents.length }} / {{ form.prototypes.length }}
                    </span>
                </template>
            </CardKPI>

            <CardKPI title="Publicaciones conjuntas" :icon="mdiBookInformationVariant">
                <template #content>
                    <span class="text-3xl font-bold py-2">
                        {{ form.joint_publications.length }}
                    </span>
                </template>
                <template #footer>
                    {{ metricIndicatorNames('joint_publications') }}
                </template>
            </CardKPI>

            <CardKPI title="Incremento de productividad (%)" :icon="mdiChartLineVariant">
                <template #content>
                    <span class="text-3xl font-bold py-2 line-clamp-1">
                        {{ form.productivity_increase ?? 0 }}%
                    </span>
                </template>
                <template #footer>
                    {{ metricIndicatorNames('productivity_increases') }}
                </template>
            </CardKPI>

            <CardKPI title="Empleo generado" :icon="mdiBriefcase">
                <template #content>
                    <span class="text-3xl font-bold py-2">
                        {{ form.direct_jobs_generated.length }} / {{ form.indirect_jobs_generated.length }}
                    </span>
                </template>
                <template #footer>
                    Directos/Indirectos
                </template>
            </CardKPI>

            <CardKPI title="Beneficiarios" :icon="mdiAccountGroup">
                <template #content>
                    <span class="text-3xl font-bold py-2">
                        {{ form.direct_beneficiaries.length }} / {{ form.indirect_beneficiaries.length }}
                    </span>
                </template>
                <template #footer>
                    Directos/Indirectos
                </template>
            </CardKPI>

            <CardKPI title="Valor económico (MXN)" :icon="mdiCurrencyUsd">
                <template #content>
                    <span class="text-3xl font-bold py-2">
                        ${{ useAbbreviateNumber(form.economic_estimate) }}
                    </span>
                </template>
            </CardKPI>
        </div>

        <div class="flex flex-wrap gap-2 py-4">
            <Badge v-if="form.technology_level_transitions?.length" color="green" size="md" rounded="rounded-sm"
                class="flex items-center gap-1 w-full sm:w-auto">
                {{ firstTechnologyTransition?.initial?.level }}
                <BaseIcon :path="mdiArrowRight" size="16" h="h-4" w="w-4" />
                {{ firstTechnologyTransition?.final?.level }}
            </Badge>

            <Badge v-if="form.technological_transfer_metrics?.length" color="green" size="md" rounded="rounded-sm"
                class="w-full sm:w-auto">
                Transferencias tecnológicas:
                <strong>{{ technologicalTransferNames }}</strong>
            </Badge>

            <Badge color="wine" size="md" rounded="rounded-sm" class="w-full sm:w-auto">
                {{ form.products.length }} productos /
                {{ form.services.length }} servicios
            </Badge>

            <Badge color="forest" size="md" rounded="rounded-sm" class="w-full sm:w-auto">
                Reducción de emisiones(tCO2/año): {{ form.emissions_percentage }}
            </Badge>

            <Badge color="forest" size="md" rounded="rounded-sm" class="w-full sm:w-auto">
                Impacto comunitario: {{ form.community_impact_level }}
            </Badge>

            <Badge color="yellow" size="md" rounded="rounded-sm" class="w-full sm:w-auto">
                Colaboración: {{ form.continuity_percentage ?? 0 }}%
            </Badge>
        </div>

        <h3 class="font-medium">
            ODS relacionados: {{ sustainableDevelopmentGoalNames.length }}
        </h3>
        <div class="flex flex-wrap gap-2 py-4">
            <Badge v-for="name in sustainableDevelopmentGoalNames" :key="name" color="gray" size="md"
                rounded="rounded-sm" class="flex items-center gap-1 w-full sm:w-auto">
                {{ name }}
            </Badge>
        </div>
        <BaseDivider />
    </CardSection>
</template>
<script setup>
import CardSection from '@/Components/CardSection.vue';
import CardKPI from './CardKPI.vue';
import { mdiAccountGroup, mdiArrowRight, mdiBookInformationVariant, mdiBriefcase, mdiChartLineVariant, mdiCurrencyUsd, mdiHeadLightbulb } from '@mdi/js';
import { inject } from 'vue';
import { useAbbreviateNumber } from '@/Hooks/useFormat';
import Badge from '@/Components/Badge.vue';
import BaseIcon from '@/Components/BaseIcon.vue';
import { useSummary } from '../../Composables/useSummary';
import BaseDivider from '@/Components/BaseDivider.vue';

const form = inject('matchEvaluationForm')
const { technologyLevels, impactMetrics } = inject('props')

const {
    metricIndicatorNames,
    firstTechnologyTransition,
    technologicalTransferNames,
    sustainableDevelopmentGoalNames
} = useSummary(form, { technologyLevels, impactMetrics })
</script>