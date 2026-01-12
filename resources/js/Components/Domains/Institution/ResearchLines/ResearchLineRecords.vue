<template>
    <table v-if="researchLines?.length > 0">
        <thead class="text-gray-700 bg-gray-100">
            <tr>
                <th>Nombre</th>
                <th>Departamento</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="item in researchLines" :key="item.id">
                <td data-label="Nombre">
                    <div class="flex items-center gap-2 lg:flex-row lg:justify-start">
                        <img class="w-10 h-10 rounded-lg object-cover" :src="item.logo?.url ?? IMAGES.image.src"
                            :alt="item.logo?.filename ?? IMAGES.image.alt" />
                        <div class="text-base">{{ item.name }}</div>
                    </div>
                </td>

                <td data-label="Departamento">
                    {{ item.department?.name }}
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
    researchLines: {
        type: Array,
    }
});
</script>