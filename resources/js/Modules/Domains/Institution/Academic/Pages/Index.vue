<template>
    <HeadLogo :title="title" />
    <loading v-model:active="isLoading" :can-cancel="false" :is-full-page="true" loader="dots" color="#283C2A" />
    <LayoutAuthenticated>
        <SectionTitleLineWithButton :icon="mdiAccountGroup" :title="title" main />

        <SearchBar @apply-filters="applyFilters" @clear-filters="clearFilters" v-model:search="filters.search"
            v-model:rows="filters.rows" :routeName="routeName" :title="title" :total="academics.meta.total" />

        <CardBox isForm>
            <CSVUpload :model_class="modelClass" />
        </CardBox>

        <CardBox v-if="academics?.data && academics.data.length > 0" class="mt-2">
            <table>
                <thead>
                    <tr>
                        <th v-if="canEnable"></th>
                        <SortableHeader @sort="sortByColumn" :filters="filters" column="first_name" label="Nombre" />
                        <SortableHeader @sort="sortByColumn" :filters="filters" column="department" label="Departamento" />
                        <SortableHeader @sort="sortByColumn" :filters="filters" column="academic_position" label="Puesto" />
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="item in academics.data" :key="item.id">
                        <TableCheckboxCell v-if="canEnable" @confirm="enable(item.id)" type="switch"
                            v-model="item.is_active" confirm />
                        <td data-label="Nombre">
                            {{ item.name }}
                        </td>
                        <td data-label="Departamento">
                            {{ item.department?.name ?? '-' }}
                        </td>
                        <td data-label="Puesto">
                            {{ item.academic_position?.name ?? '-' }}
                        </td>
                        <td data-label="Acciones">
                            <BaseButtons>
                                <BaseButton color="info" :icon="mdiPencil" small :routeName="`${routeName}edit`"
                                    :parameter="item.id" />
                                <BaseButton color="danger" :icon="mdiTrashCan" small @click="deleteForm(item.id)" />
                            </BaseButtons>
                        </td>
                    </tr>
                </tbody>
            </table>
        </CardBox>
        <CardBoxComponentEmpty v-else />
        <pagination v-if="academics?.meta" :links="academics.meta.links" :total="academics.meta.total"
            :to="academics.meta.to" :from="academics.meta.from" />
    </LayoutAuthenticated>
</template>

<script setup>
import BaseButton from "@/Components/BaseButton.vue";
import BaseButtons from "@/Components/BaseButtons.vue";
import CardBox from "@/Components/CardBox.vue";
import CardBoxComponentEmpty from "@/Components/CardBoxComponentEmpty.vue";
import CSVUpload from "@/Components/CSVUpload.vue";
import HeadLogo from "@/Components/HeadLogo.vue";
import LayoutAuthenticated from "@/Layouts/LayoutAuthenticated.vue";
import Pagination from "@/Components/Pagination.vue";
import SearchBar from "@/Components/SearchBar.vue";
import SectionTitleLineWithButton from "@/Components/SectionTitleLineWithButton.vue";
import SortableHeader from "@/Components/Table/SortableHeader.vue";
import TableCheckboxCell from "@/Components/TableCheckboxCell.vue";
import { useFilters } from "@/Hooks/useFilters";
import { mdiAccountGroup, mdiPencil, mdiTrashCan } from "@mdi/js";
import { useAcademicForm } from "../Composables/useAcademicForm.js";
import { verifyPermission } from '@/Hooks/usePermissions';

const props = defineProps({
    title: {
        type: String,
        required: true,
    },
    academics: {
        type: Object,
        default: () => ({}),
        required: true,
    },
    routeName: {
        type: String,
        required: true,
    },
    filters: {
        type: Object,
        required: true
    },
    modelClass: {
        type: String,
        required: true,
    }
});

const { filters, clearFilters, applyFilters, isLoading, sortByColumn } = useFilters(props.filters, props.routeName);
const { deleteForm, enable } = useAcademicForm(props);
const canEnable = () => verifyPermission(`${props.routeName}enable`)
</script>
