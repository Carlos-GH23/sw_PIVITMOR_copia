<template>
    <div v-if="entity.legal_representative" class="flex items-center space-x-2">
        <label class="text-md font-medium text-forest-400">Representante legal:
            <span class="text-foreground font-light">
                {{ entity?.legal_representative || 'Sin datos' }}
            </span>
        </label>
    </div>

    <div v-if="entity.legal_entity_type" class="flex items-center space-x-2">
        <label class="text-md font-medium text-forest-400">Figura jurídica:
            <span class="text-foreground font-light">
                {{ entity.legal_entity_type?.name || 'Sin datos' }}
            </span>
        </label>
    </div>

    <div v-if="entity.economic_sector" class="flex items-center space-x-2">
        <label class="text-md font-medium text-forest-400">Sector:
            <span class="text-foreground font-light">
                {{ entity.economic_sector?.name || 'Sin datos' }}
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