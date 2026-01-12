<template>
    <table v-if="academicBackgrounds?.length > 0">
        <thead class="text-gray-700 bg-gray-100">
            <tr>
                <th>Título del grado</th>
                <th>Institución</th>
                <th>Grado académico</th>
                <th>Área de conocimiento</th>
                <th>País</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="item in academicBackgrounds" :key="item.id">
                <td data-label="Título del grado">
                    {{ item.academic_title }}
                </td>
                <td data-label="Institución">
                    {{ item.institution_name }}
                </td>
                <td data-label="Grado académico">
                    {{ item.academic_degree?.name }}
                </td>
                <td data-label="Área de conocimiento">
                    {{ item.knowledge_area?.name }}
                </td>
                <td data-label="País">
                    {{ item.country?.name }}
                </td>
            </tr>
        </tbody>
    </table>

    <CardBoxComponentEmpty v-else />
</template>

<script setup>
import CardBoxComponentEmpty from '@/Components/CardBoxComponentEmpty.vue';

defineProps({
    academicBackgrounds: {
        type: Array,
    }
});
</script>