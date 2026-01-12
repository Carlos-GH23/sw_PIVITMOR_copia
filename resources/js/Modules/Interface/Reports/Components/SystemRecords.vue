<template>
    <DataTable title="Módulos" description="Tiempo promedio por visita">
        <thead>
            <tr>
                <th>Módulo</th>
                <th>Visitas</th>
                <th>Rol más activo</th>
                <th>Duración media</th>
            </tr>
        </thead>

        <tbody>
            <tr v-for="module in modules" :key="module.key">
                <td data-label="Módulo">
                    {{ module.name }}
                </td>
                <td data-label="Visitas">
                    {{ module.visits }}
                </td>
                <td data-label="Rol más activo">
                    <ul class="flex gap-2">
                        <li v-for="(user, index) in limitList(module.users, limit)" :key="index">
                            <Badge variant="soft">
                                {{ user }}
                            </Badge>
                        </li>

                        <li v-if="module.users && module.users.length > limit" class="flex flex-wrap">
                            <Badge color="green">
                                +{{ module.users.length - limit }} más
                            </Badge>
                        </li>
                    </ul>
                </td>
                <td data-label="Duración media">
                    {{ module.average_duration }}
                </td>
            </tr>
        </tbody>
    </DataTable>
</template>

<script setup>
import { limitList } from '@/Helpers/list';
import DataTable from './DataTable.vue';
import Badge from '@/Components/Badge.vue';

const props = defineProps({
    modules: {
        type: Array,
        default: () => [],
    },
});

const limit = 3;
</script>