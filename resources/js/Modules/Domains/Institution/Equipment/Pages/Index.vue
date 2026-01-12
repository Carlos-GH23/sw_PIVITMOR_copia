<template>
    <HeadLogo :title="title" />
    <loading v-model:active="isLoading" :can-cancel="false" :is-full-page="true" loader="dots" color="#283C2A" />
    <LayoutMain>
        <SectionTitleLineWithButton :icon="mdiCubeOutline" :title="title" main />

        <SearchBar @apply-filters="applyFilters" @clear-filters="clearFilters" v-model:search="filters.search"
            :routeName="routeName" title=" " :total="equipment?.meta?.total || 0" />

        <CardBox v-if="equipment?.data && equipment.data.length > 0" class="mt-2">
            <table>
                <thead>
                    <tr>
                        <th v-if="canEnable"></th>
                        <SortableHeader @sort="sortByColumn" :filters="filters" column="name" label="Nombre" />
                        <SortableHeader @sort="sortByColumn" :filters="filters" column="equipment_type" label="Tipo" />
                        <SortableHeader @sort="sortByColumn" :filters="filters" column="facility" label="Ubicación" />
                        <SortableHeader @sort="sortByColumn" :filters="filters" column="status" label="Estatus" />
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="item in equipment.data" :key="item.id">
                        <TableCheckboxCell v-if="canEnable" @confirm="enable(item.id)" type="switch"
                            v-model="item.status" confirm />
                        <td data-label="Nombre">
                            {{ item.name }}
                        </td>
                        <td data-label="Tipo">
                            <span v-if="item.equipmentType">{{ item.equipmentType.name }}</span>
                            <span v-else class="text-gray-500 italic">Sin asignar</span>
                        </td>
                        <td data-label="Ubicación">
                            <span v-if="item.facility">{{ item.facility.name }}</span>
                            <span v-else class="text-gray-500 italic">Sin asignar</span>
                        </td>
                        <td data-label="Estatus">
                            <Badge :color="item.status ? 'green' : 'gray'" variant="soft">
                                {{ item.status ? 'Activo' : 'Inactivo' }}
                            </Badge>
                        </td>
                        <td data-label="Acciones">
                            <BaseButtons>
                                <BaseButton color="info" :icon="mdiPencil" small :routeName="`${routeName}edit`"
                                    :parameter="item.id" title="Editar módulo" />
                                <BaseButton color="danger" :icon="mdiTrashCan" small @click="deleteEquipment(item)"
                                    title="Eliminar equipamiento" />
                            </BaseButtons>
                        </td>
                    </tr>
                </tbody>
            </table>
        </CardBox>
        <CardBoxComponentEmpty v-else />
        <pagination v-if="equipment?.meta" :links="equipment.meta.links" :total="equipment.meta.total"
            :to="equipment.meta.to" :from="equipment.meta.from" />
    </LayoutMain>
</template>

<script setup>
import Badge from "@/Components/Badge.vue";
import BaseButton from "@/Components/BaseButton.vue";
import BaseButtons from "@/Components/BaseButtons.vue";
import CardBoxComponentEmpty from "@/Components/CardBoxComponentEmpty.vue";
import CardBox from "@/Components/CardBox.vue";
import HeadLogo from "@/Components/HeadLogo.vue";
import LayoutMain from "@/Layouts/LayoutMain.vue";
import Pagination from "@/Components/Pagination.vue";
import SectionTitleLineWithButton from "@/Components/SectionTitleLineWithButton.vue";
import SortableHeader from '@/Components/Table/SortableHeader.vue';
import SearchBar from "@/Components/SearchBar.vue";
import { useFilters } from "@/Hooks/useFilters";
import { useEquipment } from "../Composables/useEquipment";
import TableCheckboxCell from "@/Components/TableCheckboxCell.vue";
import {
    mdiCubeOutline,
    mdiPencil,
    mdiTrashCan,
} from "@mdi/js";

const props = defineProps({
    title: {
        type: String,
        required: true,
    },
    equipment: {
        type: Object,
        required: true,
    },
    routeName: {
        type: String,
        required: true,
    },
    filters: {
        type: Object,
        required: true,
    },
});

const { filters, clearFilters, applyFilters, isLoading, sortByColumn } = useFilters(props.filters, props.routeName);

const { deleteForm, enable } = useEquipment(props.routeName);

const canEnable = () => verifyPermission(`${props.routeName}enable`);

const deleteEquipment = (equipment) => {
    deleteForm(equipment);
}
</script>
