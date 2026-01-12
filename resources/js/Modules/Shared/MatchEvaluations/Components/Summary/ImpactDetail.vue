<template>
    <CardBox>
        <h3 class="text-base text-forest-400 font-semibold mb-6">
            Detalle de impacto
        </h3>
        <div class="w-full max-h-[50vh] overflow-y-auto">
            <CardImpact title="TRL Inicial / Final">
                <ul class="max-w-md space-y-2 text-body list-none list-inside">
                    <li v-for="item in allTechnologyTransitions">
                        {{ item.initial?.level }}
                        <BaseIcon :path="mdiArrowRight" size="16" h="h-4" w="w-4" />
                        {{ item.final?.level }}
                    </li>
                </ul>
                <p v-if="form.technology_level_transitions.length === 0">
                    No se han registrado transiciones de TRL.
                </p>
            </CardImpact>

            <CardImpact title="Empleo generado">
                {{ form.direct_jobs_generated.length }} directos /
                {{ form.indirect_jobs_generated.length }} indirectos
            </CardImpact>

            <CardImpact title="Productividad" v-if="form.productivity_increase">
                {{ form.productivity_increase }}% en
                {{ metricIndicatorNames('productivity_increases') }}
            </CardImpact>

            <CardImpact :title="`${form.products.length} Productos / ${form.services.length} Servicios`">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                    <span>
                        {{ metricIndicatorNames('products') }}
                    </span>
                    <span>
                        {{ metricIndicatorNames('services') }}
                    </span>
                </div>
            </CardImpact>

            <CardImpact title="Transferencias tecnológicas">
                {{ technologicalTransferNames }}
            </CardImpact>

            <CardImpact title="ODS Relacionados">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                    <span v-for="item in sustainableDevelopmentGoalNames" :key="item" class="block">
                        {{ item }}
                    </span>
                </div>
            </CardImpact>

            <CardImpact title="Indicadores sociales y ambientales" :hasDivider="false">
                <div>
                    Reducción de emisiones (tCO2e/año): {{ form.emissions_percentage }}
                </div>
                <div>
                    Impacto comunitario: {{ form.community_impact_level }}
                </div>
                <div>
                    Inclusión y equidad: {{ form.inclusion_equity_level }}
                    <p class="text-sm font-thin text-slate-700">
                        {{ metricIndicatorNames('inclusion_equity') }}
                    </p>
                </div>
            </CardImpact>
        </div>
    </CardBox>
</template>
<script setup>
import CardSection from '@/Components/CardSection.vue';
import { inject } from 'vue';
import { mdiArrowRight } from '@mdi/js';
import { useSummary } from '../../Composables/useSummary';
import BaseIcon from '@/Components/BaseIcon.vue';
import CardImpact from './CardImpact.vue';
import CardBoxComponentEmpty from '@/Components/CardBoxComponentEmpty.vue';
import CardBox from '@/Components/CardBox.vue';

const form = inject('matchEvaluationForm')
const { technologyLevels, impactMetrics } = inject('props')

const {
    metricIndicatorNames,
    allTechnologyTransitions,
    technologicalTransferNames,
    sustainableDevelopmentGoalNames,
} = useSummary(form, { technologyLevels, impactMetrics })
</script>