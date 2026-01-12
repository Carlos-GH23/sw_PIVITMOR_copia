<template>
    <CardBox>
        <div class="mb-4">
            <div class="flex items-center">
                <BaseIcon class="text-forest-400" :path="mdiCogOutline" size="24" h="h-10" w="w-10" />
                <h3 class="text-forest-400 text-xl font-bold">Servicios Tecnológicos</h3>
            </div>
            <span class="text-sm font-light text-slate-800 dark:text-slate-300">
                Listado de servicios publicados
            </span>
        </div>

        <TableFiltersApi :model-value="tableFilters" @update:model-value="$emit('update:filters', $event)"
            @clear="$emit('clear')" />

        <div v-if="services.data.length > 0" class="border rounded-xl mb-4">
            <table>
                <thead>
                    <tr>
                        <th>Servicio</th>
                        <th>Categoría</th>
                        <th>OCDE</th>
                        <th>ISIC</th>
                        <th>Vistas</th>
                    </tr>
                </thead>

                <tbody>
                    <tr v-for="item in services.data" :key="item.id">
                        <td data-label="Servicio">
                            {{ item.title }}
                        </td>
                        <td data-label="Categoría">
                            {{ item.category ?? 'N/A' }}
                        </td>
                        <td data-label="OCDE">
                            <SectorList v-if="item.ocde_area?.length" :sectors="item.ocde_area" :max-visible="2" />
                        </td>
                        <td data-label="ISIC">
                            <SectorList v-if="item.isic_sector?.length" :sectors="item.isic_sector" :max-visible="2" />
                        </td>
                        <td data-label="Vistas">
                            {{ item.views }}
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <CardBoxComponentEmpty v-else />

        <PaginationApi :links="services.links" :total="services.total" :to="services.to" :from="services.from"
            @page-change="updatePage" />
    </CardBox>
</template>

<script setup>
import CardBoxComponentEmpty from '@/Components/CardBoxComponentEmpty.vue';
import CardBox from '@/Components/CardBox.vue';
import BaseIcon from '@/Components/BaseIcon.vue';
import PaginationApi from '@/Components/PaginationApi.vue';
import TableFiltersApi from '@/Components/TableFiltersApi.vue';
import SectorList from './SectorList.vue';
import { mdiCogOutline } from '@mdi/js';

const props = defineProps({
    services: {
        type: Object,
        required: true,
    },
    tableFilters: {
        type: Object,
        required: true,
    },
});

const emit = defineEmits(['update:filters', 'clear']);

const updatePage = (page) => {
    emit('update:filters', { ...props.tableFilters, page });
};
</script>