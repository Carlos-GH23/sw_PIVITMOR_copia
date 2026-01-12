<template>
    <CardBox class="mt-5" isForm>
        <h3 class="text-lg md:text-xl font-semibold text-forest-400 mb-4">Filtros globales</h3>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-x-4">
            <FormField label="Rango desde:">
                <FormControl type="date" v-model="filtersReport.startDate" />
            </FormField>

            <FormField label="Rango hasta:">
                <FormControl type="date" v-model="filtersReport.endDate" />
            </FormField>

            <template v-if="!isSniiTab">
                <FormField label="Tipo de usuario">
                    <FormControl :options="userTypes" v-model="filtersReport.userType" :icon="mdiAccount" />
                </FormField>

                <FormField label="Área OCDE:">
                    <FormControl :options="oecdSectors" v-model="filtersReport.oecdSector" />
                </FormField>

                <FormField label="Sector ISIC:" class="lg:col-span-2">
                    <FormControl :options="economicSectors" v-model="filtersReport.economicSector" />
                </FormField>
            </template>

            <template v-if="isSniiTab">
                <FormField label="Categoría de institución:">
                    <FormControl :options="categories" v-model="filtersReport.category" />
                </FormField>

                <FormField label="Área de investigación:">
                    <FormControl :options="researchAreas" v-model="filtersReport.researchArea" />
                </FormField>

                <FormField label="Nivel SNI:">
                    <FormControl :options="sniLevels" v-model="filtersReport.sniLevel" />
                </FormField>

                <FormField label="Género:">
                    <FormControl :options="genders" v-model="filtersReport.gender" />
                </FormField>
            </template>
        </div>

        <template v-if="isSniiTab">
            <FormField label="Municipio:">
                <FormControl :options="municipalities" v-model="filtersReport.municipality" />
            </FormField>
        </template>

        <div class="flex justify-end space-x-2 mt-2">
            <BaseButton label="Limpiar" color="lightDark" @click="$emit('clear')" />
            <BaseButton label="Aplicar filtros" color="info" @click="$emit('apply')" />
        </div>
    </CardBox>
</template>

<script setup>
import { computed } from 'vue';
import BaseButton from '@/Components/BaseButton.vue';
import CardBox from '@/Components/CardBox.vue';
import FormControl from '@/Components/FormControl.vue';
import FormField from '@/Components/FormField.vue';
import { mdiAccount } from '@mdi/js';

const props = defineProps({
    activeTab: String,
    filtersReport: Object,
    userTypes: Object,
    oecdSectors: Object,
    economicSectors: Object,
    categories: Object,
    researchAreas: Object,
    sniLevels: Object,
    genders: Object,
    municipalities: Object,
});
const emit = defineEmits(['apply', 'clear']);
const isSniiTab = computed(() => props.activeTab === 'snii');
</script>