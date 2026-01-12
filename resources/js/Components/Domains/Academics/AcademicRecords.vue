<template>
    <table v-if="academics?.length > 0">
        <thead class="text-gray-700 bg-gray-100">
            <tr>
                <th>Nombre</th>
                <th>Departamento</th>
                <th>Puesto</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="item in academics" :key="item.id">
                <td data-label="Nombre">
                    <div class="flex items-center gap-2">
                        <img class="w-10 h-10 rounded-full object-cover" :src="item.photo?.url ?? IMAGES.user.src"
                            :alt="item.photo?.filename ?? IMAGES.user.alt" />
                        <div class="ps-3">
                            <div class="text-base">{{ item.name }}</div>
                            <div class="font-normal text-gray-500">{{ item.email }}</div>
                        </div>
                    </div>
                </td>
                <td data-label="Departamento">
                    {{ item.department?.name }}
                </td>
                <td data-label="Puesto">
                    {{ item.academic_position?.name }}
                </td>
            </tr>
        </tbody>
    </table>

    <CardBoxComponentEmpty v-else />
</template>

<script setup>
import CardBoxComponentEmpty from '@/Components/CardBoxComponentEmpty.vue';
import { IMAGES } from "@/Utils/Image";

defineProps({
    academics: {
        type: Array,
    }
});
</script>