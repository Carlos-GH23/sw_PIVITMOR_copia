<template>
    <table v-if="certifications?.length > 0">
        <thead class="text-gray-700 bg-gray-100">
            <tr>
                <th>Nombre</th>
                <th>Descripción</th>
                <th>Tipo</th>
                <th>Entidad certificante</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="item in certifications" :key="item.id">
                <td data-label="Nombre" class="flex flex-row gap-2 justify-start">
                    {{ item.name }}
                </td>
                <td data-label="Descripción">
                    {{ item.description }}
                </td>
                <td data-label="Tipo">
                    {{ item.certification_type.name }}
                </td>
                <td data-label="Entidad certificante">
                    {{ item.certifying_entity }}
                </td>
            </tr>
        </tbody>
    </table>

    <CardBoxComponentEmpty v-else />
</template>

<script setup>
import CardBoxComponentEmpty from '@/Components/CardBoxComponentEmpty.vue';

defineProps({
    certifications: {
        type: Array,
    }
});
</script>