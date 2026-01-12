<template>
    <table v-if="academicCertifications?.length > 0">
        <thead class="text-gray-700 bg-gray-100">
            <tr>
                <th>Nombre</th>
                <th>Nivel</th>
                <th>Descripción</th>
                <th>Entidad certificadora</th>
                <th>Acreditación</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="item in academicCertifications" :key="item.id">
                <td data-label="Nombre">
                    {{ item.name }}
                </td>
                <td data-label="Nivel">
                    {{ item.certification_level?.name }}
                </td>
                <td data-label="Descripción">
                    {{ item.description }}
                </td>
                <td data-label="Entidad certificadora">
                    {{ item.certifying_entity }}
                </td>
                <td data-label="Acreditación">
                    {{ item.accreditation_entity?.name }}
                </td>
            </tr>
        </tbody>
    </table>

    <CardBoxComponentEmpty v-else />
</template>

<script setup>
import CardBoxComponentEmpty from '@/Components/CardBoxComponentEmpty.vue';

defineProps({
    academicCertifications: Array
});
</script>