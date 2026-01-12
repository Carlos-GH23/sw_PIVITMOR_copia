<template>
    <table v-if="knowledgeAreas?.length > 0">
        <thead class="text-gray-700 bg-gray-100">
            <tr>
                <th>Nombre</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="area in knowledgeAreas" :key="area.id">
                <td data-label="Nombre">
                    {{ area.name }}
                </td>
            </tr>
        </tbody>
    </table>

    <CardBoxComponentEmpty v-else />
</template>

<script setup>
import CardBoxComponentEmpty from '@/Components/CardBoxComponentEmpty.vue';

defineProps({
    knowledgeAreas: {
        type: Array,
    }
});
</script>