<template>
    <div class="mb-5">
        <FormField label="Nombre de la disciplina OECD:" required :error="form.errors.name">
            <FormControl v-model="form.name" name="name" placeholder="Nombre de la Disciplina OECD" maxlength="255"
                required />
        </FormField>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-5">
        <FormField label="Nivel en la jerarquía:" required :error="form.errors.level">
            <FormControl v-model="selectedLevel" :options="levelOptions" value-select="value" value-option="label"
                :select-is-disabled="true" placeholder="Seleccione un nivel" @update:modelValue="onLevelChange" />
        </FormField>

        <FormField label="Sector económico-social:" :error="form.errors.economic_social_sector_id">
            <SimpleSearchSelect v-model="form.economic_social_sector_id" :items="economicSocialSectors"
                placeholder="Buscar sector económico-social..." />
        </FormField>

        <FormField label="Área principal:" :required="selectedLevel !== 'main_area'"
            :error="selectedLevel === 'subarea' ? form.errors.parent_id : (selectedLevel === 'discipline' && form.errors.parent_id && !areaPrincipalValue ? 'El campo área principal es obligatorio.' : null)">
            <SimpleSearchSelect v-model="areaPrincipalValue" :items="level1Options"
                :disabled="!selectedLevel || selectedLevel === 'main_area'" placeholder="Buscar área principal..."
                @update:modelValue="onAreaPrincipalUpdate" />
        </FormField>

        <FormField label="Subárea:" :required="selectedLevel === 'discipline'"
            :error="selectedLevel === 'discipline' ? form.errors.parent_id : null">
            <SimpleSearchSelect v-model="subAreaValue" :items="level2Options" :disabled="selectedLevel !== 'discipline'"
                placeholder="Buscar subárea..." />
        </FormField>
    </div>
</template>

<script setup>
import FormField from "@/Components/FormField.vue";
import SimpleSearchSelect from "@/Components/SimpleSearchSelect.vue";
import { useOecdForm } from "./useOecdForm";
import FormControl from "@/Components/FormControl.vue";

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
    areaPrincipalValue,
    subAreaValue,
    onLevelChange,
    onAreaPrincipalUpdate,
} = useOecdForm(props);
</script>
