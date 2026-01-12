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
                        Proporciona los datos básicos de la oferta laboral
                    </p>
                </div>
            </div>
        </template>
        <div class="grid grid-cols-1 md:grid-cols-2 md:gap-4">
            <FormField label="Nombre de la oferta" required :error="form.errors.name">
                <FormControl v-model="form.name" placeholder="Ingresa el nombre de la oferta" maxLength="255" />
            </FormField>
            <FormField label="Puesto" required :error="form.errors.position">
                <FormControl v-model="form.position" placeholder="Ingresa el puesto" maxLength="255" />
            </FormField>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 md:gap-4">
            <FormField label="Género" :error="form.errors.gender" required>
                <FormControl v-model="form.gender" :options="genderOptions" placeholder="Selecciona un género" />
            </FormField>
            <FormField label="Requerimientos para viajar" :error="form.errors.travel_requirements">
                <FormControl v-model.number="form.travel_requirements" :options="travelOptions" value-select="value"
                    value-option="label" />
            </FormField>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 md:gap-4">
            <FormField label="Tipo de oferta" :error="form.errors.job_offer_type_id" required>
                <FormControl v-model="form.job_offer_type_id" :options="jobOfferTypes" option-label="name"
                    option-value="id" placeholder="Selecciona un tipo de oferta" />
            </FormField>
            <FormField label="Grado académico requerido" :error="form.errors.academic_degree_id">
                <FormControl v-model="form.academic_degree_id" :options="academicDegrees" option-label="name"
                    option-value="id" placeholder="Selecciona un grado académico" />
            </FormField>
        </div>
        <CardSection title="Periodo de publicación" description="Periodo de publicación de la oferta laboral"
            iconClasses="bg-forest-400 text-mono-100" :icon="mdiCalendarBlankOutline">
            <div class="grid grid-cols-2 gap-4">
                <FormField label="Fecha de inicio" :error="form.errors.start_date" required>
                    <FormControl v-model="form.start_date" type="date" />
                </FormField>
                <FormField label="Fecha de cierre" :error="form.errors.end_date">
                    <FormControl v-model="form.end_date" type="date" />
                </FormField>
            </div>
        </CardSection>
    </CardForm>
</template>
<script setup>
import FormControl from "@/Components/FormControl.vue";
import FormField from "@/Components/FormField.vue";
import { inject } from "vue";
import CardForm from "@/Components/CardForm.vue";
import { mdiCalendarBlankOutline, mdiInformation } from "@mdi/js";
import BaseIcon from "@/Components/BaseIcon.vue";
import CardSection from "@/Components/CardSection.vue";
import { computed } from "vue";

const props = defineProps({
    academicDegrees: {
        type: Array,
        default: () => []
    },
    genders: {
        type: Array,
        default: () => []
    },
    jobOfferTypes: {
        type: Array,
        default: () => []
    }
});

const genderOptions = computed(() => {
    return props.genders.map(gender => gender.value);
});

const travelOptions = computed(() => [
    { label: 'Si', value: 1 },
    { label: 'No', value: 0 }
]);

const form = inject("formJobOffer")
</script>