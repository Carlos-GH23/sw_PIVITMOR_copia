<template>
    <div class="mb-5">
        <FormField label="Nombre del sector económico:" required :error="form.errors.name">
            <FormControl v-model="form.name" name="name" placeholder="Nombre del Sector Económico" maxlength="255"
                required />
        </FormField>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-5">
        <FormField label="Nivel en la jerarquía:" required :error="form.errors.level">
            <FormControl v-model="selectedLevel" :options="levelOptions" value-select="value" value-option="label"
                :select-is-disabled="true" placeholder="Seleccione un nivel" @update:modelValue="onLevelChange"
                class="[&_select]:py-2.5" />
        </FormField>

        <FormField label="Sector económico-social:" :error="form.errors.economic_social_sector_id">
            <SimpleSearchSelect v-model="form.economic_social_sector_id" :items="economicSocialSectors"
                placeholder="Buscar sector económico-social..." />
        </FormField>

        <FormField label="Sección:" :required="selectedLevel !== 'section'"
            :error="selectedLevel === 'division' ? form.errors.parent_id : (selectedLevel === 'group' && form.errors.parent_id && !sectionValue ? 'El campo sección es obligatorio.' : null)">
            <SimpleSearchSelect v-model="sectionValue" :items="level1Options"
                :disabled="!selectedLevel || selectedLevel === 'section'" placeholder="Buscar sección..."
                @update:modelValue="onSectionUpdate" />
        </FormField>

        <FormField label="División:" :required="selectedLevel === 'group'"
            :error="selectedLevel === 'group' ? form.errors.parent_id : null">
            <SimpleSearchSelect v-model="divisionValue" :items="level2Options" :disabled="selectedLevel !== 'group'"
                placeholder="Buscar división..." />
        </FormField>
    </div>
</template>

<script setup>
import FormField from "@/Components/FormField.vue";
import FormControl from "@/Components/FormControl.vue";
import SimpleSearchSelect from "@/Components/SimpleSearchSelect.vue";
import { useEconomicSectorForm } from "./useEconomicSectorForm";

const props = defineProps({
    form: { type: Object, required: true },
    categories: { type: Array, default: () => [] },
    economicSocialSectors: { type: Array, default: () => [] },
    levelOptions: { type: Array, default: () => [] },
});

const {
    selectedLevel,
    level1Options,
    level2Options,
    sectionValue,
    divisionValue,
    onLevelChange,
    onSectionUpdate,
} = useEconomicSectorForm(props);
</script>
