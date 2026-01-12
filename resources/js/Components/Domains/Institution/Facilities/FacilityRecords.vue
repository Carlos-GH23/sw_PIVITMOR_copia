<template>
    <table v-if="facilities?.length > 0">
        <thead class="text-gray-700 bg-gray-100">
            <tr>
                <th>Nombre</th>
                <th>Tipo</th>
                <th>Departamento</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="item in facilities" :key="item.id">
                <td data-label="Nombre" class="flex flex-row gap-2 justify-start">
                    {{ item.name }}
                </td>
                <td data-label="Tipo">
                    {{ item.facility_type.name }}
                </td>
                <td data-label="Departamento">
                    {{ item.department.name }}
                </td>
            </tr>
        </tbody>
    </table>

    <CardBoxComponentEmpty v-else />
</template>

<script setup>
import CardBoxComponentEmpty from '@/Components/CardBoxComponentEmpty.vue';

defineProps({
    facilities: {
        type: Array,
    }
});
</script>