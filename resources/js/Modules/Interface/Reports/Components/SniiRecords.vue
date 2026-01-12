<template>
    <CardBox>
        <div class="mb-4">
            <div class="flex items-center">
                <BaseIcon class="text-forest-400" :path="mdiFileDocumentOutline" size="24" h="h-10" w="w-10" />
                <h3 class="text-forest-400 text-xl font-bold">Resumen por nivel SNII</h3>
            </div>
            <span class="text-sm font-light text-slate-800 dark:text-slate-300">
                Tabla de valor por nivel
            </span>
        </div>

        <TableFiltersApi :model-value="tableFilters" @update:model-value="$emit('update:filters', $event)"
            @clear="$emit('clear')" />

        <div v-if="levels.data.length > 0" class="border rounded-xl mb-4">
            <table>
                <thead>
                    <tr>
                        <th>Nivel SNII</th>
                        <th>Servicios tecnológicos</th>
                        <th>Capacidades tecnológicas</th>
                        <th>Necesidades tecnológicas</th>
                        <th>Vinculaciones activas</th>
                        <th>Vinculaciones concluidas</th>
                        <th>Resumen cualitativo</th>
                    </tr>
                </thead>

                <tbody>
                    <tr v-for="item in levels.data" :key="`${item.type_key}-${item.id}`">
                        <td data-label="Publicación">
                            {{ item.sni_level }}
                        </td>
                        <td data-label="Servicios tecnológicos">
                            {{ item.tech_service }}
                        </td>
                        <td data-label="Capacidades tecnológicas">
                            {{ item.tech_capability }}
                        </td>
                        <td data-label="Necesidades tecnológicas">
                            {{ item.tech_requirement }}
                        </td>
                        <td data-label="Vinculaciones activas">
                            {{ item.active_links }}
                        </td>
                        <td data-label="Vinculaciones concluidas">
                            {{ item.concluded_links }}
                        </td>
                        <td data-label="Resumen cualitativo">
                            {{ item.qualitative_summary }}
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <CardBoxComponentEmpty v-else />

        <PaginationApi :links="levels.links" :total="levels.total" :to="levels.to"
            :from="levels.from" @page-change="updatePage" />
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
    levels: {
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