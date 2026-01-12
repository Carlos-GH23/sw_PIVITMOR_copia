<template>
    <CardBox>
        <div class="mb-4">
            <div class="flex items-center">
                <BaseIcon class="text-forest-400" :path="mdiFileDocumentOutline" size="24" h="h-10" w="w-10" />
                <h3 class="text-forest-400 text-xl font-bold">Publicaciones</h3>
            </div>
            <span class="text-sm font-light text-slate-800 dark:text-slate-300">
                Publicaciones por categoría
            </span>
        </div>

        <TableFiltersApi :model-value="tableFilters" @update:model-value="$emit('update:filters', $event)"
            @clear="$emit('clear')" />

        <div v-if="publications.data.length > 0" class="border rounded-xl mb-4">
            <table>
                <thead>
                    <tr>
                        <th>Publicación</th>
                        <th>Tipo</th>
                        <th>OCDE</th>
                        <th>ISIC</th>
                        <th>Vistas</th>
                    </tr>
                </thead>

                <tbody>
                    <tr v-for="item in publications.data" :key="`${item.type_key}-${item.id}`">
                        <td data-label="Publicación">
                            {{ item.publication }}
                        </td>
                        <td data-label="Tipo">
                            {{ item.type }}
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

        <PaginationApi :links="publications.links" :total="publications.total" :to="publications.to"
            :from="publications.from" @page-change="updatePage" />
    </CardBox>
</template>

<script setup>
import CardBoxComponentEmpty from '@/Components/CardBoxComponentEmpty.vue';
import CardBox from '@/Components/CardBox.vue';
import BaseIcon from '@/Components/BaseIcon.vue';
import PaginationApi from '@/Components/PaginationApi.vue';
import TableFiltersApi from '@/Components/TableFiltersApi.vue';
import SectorList from './SectorList.vue';
import { mdiFileDocumentOutline } from '@mdi/js';

const props = defineProps({
    publications: {
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