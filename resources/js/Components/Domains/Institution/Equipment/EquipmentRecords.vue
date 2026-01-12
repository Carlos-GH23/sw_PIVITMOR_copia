<template>
    <table v-if="equipments?.length > 0">
        <thead class="text-gray-700 bg-gray-100">
            <tr>
                <th>Nombre</th>
                <th>Descripción</th>
                <th>Tipo</th>
                <th v-if="equipments[0].facility">Instalación</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="item in equipments" :key="item.id">
                <td data-label="Nombre" class="flex flex-row gap-2 justify-start">
                    {{ item.name }}
                </td>
                <td data-label="Descripción">
                    {{ item.description }}
                </td>
                <td data-label="Tipo">
                    {{ item.equipmentType.name }}
                </td>
                <td data-label="Instalación" v-if="item.facility">
                    {{ item.facility.name }}
                </td>
            </tr>
        </tbody>
    </table>

    <CardBoxComponentEmpty v-else />
</template>

<script setup>
import CardBoxComponentEmpty from '@/Components/CardBoxComponentEmpty.vue';

defineProps({
    equipments: {
        type: Array,
    }
});
</script>