<template>
    <HeadLogo :title="title" />
    <loading v-model:active="isLoading" :can-cancel="false" :is-full-page="true" loader="dots" color="#283C2A" />
    <LayoutMain>
        <SectionTitleLineWithButton :icon="mdiDomain" :title="title" main />

        <SearchBar @apply-filters="applyFilters" @clear-filters="clearFilters" v-model:search="filters.search"
            :routeName="routeName" title=" " :total="facilities?.meta?.total || 0" />

        <CardBox v-if="facilities?.data && facilities.data.length > 0" class="mt-2">
            <table>
                <thead>
                    <tr>
                        <th v-if="canEnable"></th>
                        <SortableHeader @sort="sortByColumn" :filters="filters" column="name" label="Nombre" />
                        <SortableHeader @sort="sortByColumn" :filters="filters" column="facility_type" label="Tipo" />
                        <SortableHeader @sort="sortByColumn" :filters="filters" column="department"
                            label="Departamento" />
                        <SortableHeader @sort="sortByColumn" :filters="filters" column="is_active" label="Estatus" />
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="item in facilities.data" :key="item.id">
                        <TableCheckboxCell v-if="canEnable" @confirm="enable(item.id)" type="switch"
                            v-model="item.is_active" confirm />
                        <td data-label="Nombre">
                            {{ item.name }}
                        </td>
                        <td data-label="Tipo">
                            <span v-if="item.facility_type">
                                {{ item.facility_type.name }}
                            </span>
                            <span v-else class="text-gray-500">No asignado</span>
                        </td>
                        <td data-label="Departamento">
                            <span v-if="item.department">
                                {{ item.department.name }}
                            </span>
                            <span v-else class="text-gray-500">No asignado</span>
                        </td>
                        <td data-label="Estatus">
                            <Badge :color="item.is_active ? 'green' : 'gray'" variant="soft">
                                {{ item.is_active ? 'Activo' : 'Inactivo' }}
                            </Badge>
                        </td>
                        <td data-label="Acciones">
                            <BaseButtons>
                                <BaseButton color="info" :icon="mdiPencil" small :routeName="`${routeName}edit`"
                                    :parameter="item.id" title="Editar instalación" />
                                <BaseButton color="danger" :icon="mdiTrashCan" small @click="deleteFacility(item)"
                                    title="Eliminar instalación" />
                            </BaseButtons>
                        </td>
                    </tr>
                </tbody>
            </table>
        </CardBox>
        <CardBoxComponentEmpty v-else />
        <pagination v-if="facilities?.meta" :links="facilities.meta.links" :total="facilities.meta.total"
            :to="facilities.meta.to" :from="facilities.meta.from" />
    </LayoutMain>
</template>

<script setup>
import BaseButton from "@/Components/BaseButton.vue";
import BaseButtons from "@/Components/BaseButtons.vue";
import CardBox from "@/Components/CardBox.vue";
import CardBoxComponentEmpty from "@/Components/CardBoxComponentEmpty.vue";
import CSVUpload from "@/Components/CSVUpload.vue";
import HeadLogo from "@/Components/HeadLogo.vue";
import LayoutMain from "@/Layouts/LayoutMain.vue";
import Pagination from "@/Components/Pagination.vue";
import SearchBar from "@/Components/SearchBar.vue";
import SectionTitleLineWithButton from "@/Components/SectionTitleLineWithButton.vue";
import SortableHeader from "@/Components/Table/SortableHeader.vue";
import { useFilters } from "@/Hooks/useFilters";
import { useFacility } from "../Composables/useFacility";
import TableCheckboxCell from "@/Components/TableCheckboxCell.vue";
import {
    mdiDomain,
    mdiPencil,
    mdiTrashCan,
} from "@mdi/js";
import Badge from "@/Components/Badge.vue";

const props = defineProps({
    title: {
        type: String,
        required: true,
    },
    facilities: {
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
    model_class: {
        type: String,
        required: true,
    }
});

const { filters, clearFilters, applyFilters, isLoading, sortByColumn } = useFilters(props.filters, props.routeName);

const { deleteForm, enable } = useFacility(props.routeName);

const canEnable = () => verifyPermission(`${props.routeName}enable`);

const deleteFacility = (facility) => {
    deleteForm(facility);
}
</script>
