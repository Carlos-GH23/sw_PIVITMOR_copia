<template>
    <CardForm>
        <template #header>
            <div class="flex gap-2 items-center py-4">
                <BaseIcon class="bg-forest-400 text-mono-100 rounded-lg" :path="mdiInformation" size="24" h="h-10"
                    w="w-10" />
                <div>
                    <p class="text-forest-400 text-xl font-bold">
                        Entidad
                    </p>
                    <p class=" text-sm font-light text-slate-800 dark:text-slate-300">
                        Información de la entidad propietaria
                    </p>
                </div>
            </div>
        </template>

        <div class="flex flex-col md:items-center gap-4"
            :class="resourceType === 'requirement' ? 'md:flex-col' : 'flex-row'">
            <ImageFrame :src="entity.logo?.path" />

            <div v-if="resourceType !== 'requirement'" class="flex flex-col space-y-4">
                <h3 v-if="resourceType !== 'requirement'" class="text-lg font-semibold text-foreground mb-2">{{
                    entity.name }}
                </h3>

                <div v-if="entity.reniecyt" class="flex items-center space-x-2">
                    <label class="text-md font-medium text-forest-400">RENIIECYT:
                        <span class="text-foreground font-light">
                            {{ entity.reniecyt?.register_number || 'Sin datos' }}
                        </span>
                    </label>
                </div>

                <div v-if="entity.category" class="flex items-center space-x-2">
                    <label class="text-md font-medium text-forest-400">Categoría:
                        <span class="text-foreground font-light">
                            {{ entity.category || 'Sin datos' }}
                        </span>
                    </label>
                </div>
                <div v-if="entity.institution_type" class="flex items-center space-x-2">
                    <label class="text-md font-medium text-forest-400">Tipo de institución:
                        <span class="text-foreground font-light">
                            {{ entity.institution_type?.name || 'Sin datos' }}
                        </span>
                    </label>
                </div>

                <InfoNonProfit :entity="entity" />

                <InfoGovernment :entity="entity" />

                <div v-if="entity.location" class="flex items-center space-x-2">
                    <label class="text-md font-medium text-forest-400">Ubicación:
                        <span class="text-foreground font-light">
                            {{ entity?.location || 'Sin datos' }}
                        </span>
                    </label>
                </div>
            </div>
        </div>


        <LabelText v-if="resourceType === 'requirement'" label="Categoría" :text="entity.category || 'Sin datos'" />

        <LabelText label="Descripción" :text="entity.description" />

        <div class="space-y-6">
            <CardSection title="Contacto" description="Información de contacto">
                <LabelText label="Nombre del contacto" :text="entity.contact?.name" />
            </CardSection>

            <CardSection title="Teléfonos" description="Teléfonos del contacto">
                <PhoneNumbersList :phoneNumbers="entity.contact?.phone_numbers" />
            </CardSection>
        </div>
    </CardForm>
</template>

<script setup>
import BaseIcon from '@/Components/BaseIcon.vue';
import CardForm from '@/Components/CardForm.vue';
import CardSection from '@/Components/CardSection.vue';
import ImageFrame from '@/Components/ImageFrame.vue';
import InfoGovernment from '@/Components/Domains/Entity/InfoGovernment.vue';
import InfoNonProfit from '@/Components/Domains/Entity/InfoNonProfit.vue';
import { mdiInformation } from '@mdi/js';
import { computed } from 'vue';
import LabelText from '@/Components/LabelText.vue';
import PhoneNumbersList from '@/Components/PhoneNumbersList.vue';

const props = defineProps({
    data: {
        type: Object,
        required: true,
    },
    resourceType: {
        type: String,
        required: false,
        default: '',
    }
});

const entity = computed(() => {
    return props.data?.entity || props.data;
});
</script>