<template>
    <div v-if="privacityCompliances?.data && privacityCompliances.data.length > 0" class="border rounded-xl mb-4">
        <table>
            <thead>
                <tr>
                    <!--th v-if="canEnable()"></th-->
                    <th></th>
                    <SortableHeader @sort="sortByColumn" :filters="filters" column="version" label="Versión" />
                    <SortableHeader @sort="sortByColumn" :filters="filters" column="created_at"
                        label="Fecha de publicación" :no-caps="true" />
                    <SortableHeader @sort="sortByColumn" :filters="filters" column="is_active" label="Estatus" />
                    <!--
                    th>Acciones</th-->
                </tr>
            </thead>

            <tbody>
                <tr v-for="item in privacityCompliances.data" :key="item.id">
                    <!--td>
                        <TableCheckboxCell v-if="canEnable()" @confirm="enableService(item)" type="switch"
                            :model-value="item.is_active === 1" confirm />
                    </td-->
                    <td>
                        <TableCheckboxCell @confirm="enableService(item)" type="switch"
                            :model-value="item.is_active === 1" confirm />
                    </td>
                    <td data-label="Versión">
                        {{ item.version }}
                    </td>
                    <td data-label="Fecha de publicación">
                        <span v-if="item.formatted_date">{{ item.formatted_date?.human }}</span>
                        <span v-else class="text-gray-400">Sin fecha</span>
                    </td>
                    <td data-label="Estatus">
                        <Badge :color="item.is_active ? 'green' : 'gray'" variant="soft">
                            {{ item.is_active ? 'Activo' : 'Inactivo' }}
                        </Badge>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <CardBoxComponentEmpty v-else />
    <pagination v-if="privacityCompliances?.meta" :links="privacityCompliances.meta.links"
        :total="privacityCompliances.meta.total" :to="privacityCompliances.meta.to"
        :from="privacityCompliances.meta.from" />

</template>

<script setup>
import Badge from '@/Components/Badge.vue';
import CardBoxComponentEmpty from '@/Components/CardBoxComponentEmpty.vue';
import SortableHeader from "@/Components/Table/SortableHeader.vue";
import Pagination from '@/Components/Pagination.vue';
import TableCheckboxCell from "@/Components/TableCheckboxCell.vue";
import { router } from '@inertiajs/vue3';

const props = defineProps({
    privacityCompliances: {
        type: Object,
        required: true,
    },
    filters: {
        type: Object,
        required: true,
    },
    sortByColumn: {
        type: Function,
        required: true,
    },
});

const enableService = async (privacityCompliance) => {
        router.patch(route("privacityCompliance.enable", privacityCompliance.id), {
            preserveState: true,
            preserveScroll: true,
        });
    };

</script>