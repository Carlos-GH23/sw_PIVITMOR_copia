<template>
    <div v-if="entity.government_level" class="flex items-center space-x-2">
        <label class="text-md font-medium text-forest-400">Nivel de gobierno:
            <span class="text-foreground font-light">
                {{ entity.government_level?.name || 'Sin datos' }}
            </span>
        </label>
    </div>

    <div v-if="entity.government_sector" class="flex items-center space-x-2">
        <label class="text-md font-medium text-forest-400">Sector:
            <span class="text-foreground font-light">
                {{ entity.government_sector?.name || 'Sin datos' }}
            </span>
        </label>
    </div>
</template>

<script setup>
const props = defineProps({
    entity: {
        type: Object,
        required: true,
    }
});
</script>