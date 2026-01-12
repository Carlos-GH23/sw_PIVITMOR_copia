<template>
    <div class="p-8 bg-forest-400 mx-auto">
        <div class="max-w-7xl mx-auto">
            <div class="w-full border-b-2 border-earth-150 pb-4 mb-5">
                <h2 class="text-earth-150 text-xl md:text-2xl font-medium text-center">
                    Solicita el registro de tu organización
                </h2>
            </div>
            <div class="py-5">
                <FormCompany :states="states" :municipalities="municipalities" :organizationTypes="organizationTypes" />
            </div>
        </div>
    </div>
</template>
<script setup>
import FormCompany from "./FormCompany.vue";

defineProps({
    states: Array,
    municipalities: Array,
    organizationTypes: Array,
});
</script>