<template>
    <table v-if="sectors?.length > 0">
        <thead class="text-gray-700 bg-gray-100">
            <tr>
                <th>Nombre</th>
                <th>Descripción</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="sector in sectors" :key="sector.id">
                <td data-label="Nombre">
                    {{ sector.name }}
                </td>
                <td data-label="Descripción">
                    {{ sector.description }}
                </td>
            </tr>
        </tbody>
    </table>

    <CardBoxComponentEmpty v-else />
</template>

<script setup>
import CardBoxComponentEmpty from '@/Components/CardBoxComponentEmpty.vue';

defineProps({
    sectors: {
        type: Array,
    }
});
</script>
