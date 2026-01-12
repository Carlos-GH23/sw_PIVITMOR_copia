<template>
    <CardBox>
        <div class="mb-4">
            <div class="flex items-center">
                <BaseIcon class="text-forest-400" :path="mdiHandshakeOutline" size="24" h="h-10" w="w-10" />
                <h3 class="text-forest-400 text-xl font-bold">Vinculaciones</h3>
            </div>
            <span class="text-sm font-light text-slate-800 dark:text-slate-300">
                Listado de vinculaciones entre capacidades y necesidades
            </span>
        </div>

        <TableFiltersApi :model-value="tableFilters" @update:model-value="$emit('update:filters', $event)"
            @clear="$emit('clear')" />

        <div v-if="matches.data.length > 0" class="border rounded-xl mb-4">
            <table>
                <thead>
                    <tr>
                        <th>Capacidad</th>
                        <th>Necesidad</th>
                        <th>Entidad</th>
                        <th>Estado</th>
                        <th>Duración (días)</th>
                    </tr>
                </thead>

                <tbody>
                    <tr v-for="item in matches.data" :key="item.id">
                        <td data-label="Capacidad">
                            {{ item.capability }}
                        </td>
                        <td data-label="Necesidad">
                            {{ item.requirement }}
                        </td>
                        <td data-label="Entidad">
                            {{ item.owner_entity.name }}
                        </td>
                        <td data-label="Estado">
                            <Badge :color="item.match_status.color" size="md" showDot
                                :title="item.match_status.description">
                                {{ item.match_status.name }}
                            </Badge>
                        </td>
                        <td data-label="Duración (días)">
                            {{ item.duration }}
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <CardBoxComponentEmpty v-else />

        <PaginationApi :links="matches.links" :total="matches.total" :to="matches.to" :from="matches.from"
            @page-change="updatePage" />
    </CardBox>
</template>

<script setup>
import CardBoxComponentEmpty from '@/Components/CardBoxComponentEmpty.vue';
import CardBox from '@/Components/CardBox.vue';
import BaseIcon from '@/Components/BaseIcon.vue';
import PaginationApi from '@/Components/PaginationApi.vue';
import TableFiltersApi from '@/Components/TableFiltersApi.vue';
import Badge from '@/Components/Badge.vue';
import { mdiHandshakeOutline } from '@mdi/js';

const props = defineProps({
    matches: {
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