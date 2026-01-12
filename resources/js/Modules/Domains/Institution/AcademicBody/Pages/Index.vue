<template>
    <HeadLogo :title="title" />
    <loading v-model:active="isLoading" :can-cancel="false" :is-full-page="true" loader="dots" color="#283C2A" />
    <LayoutMain>
        <SectionTitleLineWithButton :icon="mdiSchoolOutline" :title="title" main />

        <SearchBar @apply-filters="applyFilters" @clear-filters="clearFilters" v-model:search="filters.search"
            v-model:rows="filters.rows" :routeName="routeName" title="grupos académicos"
            :total="academicBodies.meta.total" />

        <CardBox isForm>
            <CSVUpload :model_class="modelClass" />
        </CardBox>

        <CardBox v-if="academicBodies.data.length > 0" class="mt-2" >
            <table>
                <thead>
                    <tr>
                        <th v-if="canEnable"></th>
                        <SortableHeader label="Nombre" column="name" />
                        <SortableHeader label="Nivel" column="degree" />
                        <SortableHeader label="Departamento Académico" column="department" />
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="item in academicBodies.data" :key="item.id">
                        <TableCheckboxCell v-if="canEnable" @confirm="enable(item.id)" type="switch"
                            v-model="item.is_active" confirm />
                        <td data-label="Nombre">
                            {{ item.name }}
                        </td>
                        <td data-label="Nivel">
                            {{ item.consolidation_degree?.level }}
                        </td>
                        <td data-label="Departamento Académico">
                            {{ item.department?.name }}
                        </td>
                        <td data-label="acciones">
                            <BaseButtons>
                                <BaseButton color="info" :icon="mdiPencil" small :routeName="`${routeName}edit`"
                                    :parameter="item.id" title="Editar grupo" />
                                <BaseButton color="danger" :icon="mdiTrashCan" @click="deleteForm(item.id)" />
                            </BaseButtons>
                        </td>
                    </tr>
                </tbody>
            </table>
        </CardBox>
        <CardBoxComponentEmpty v-else />
        <pagination :links="academicBodies.meta.links" :total="academicBodies.meta.total" :to="academicBodies.meta.to"
            :from="academicBodies.meta.from" />
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
import SortableHeader from '@/Components/Table/SortableHeader.vue';
import TableCheckboxCell from "@/Components/TableCheckboxCell.vue";
import { useFilters } from "@/Hooks/useFilters";
import { mdiSchoolOutline, mdiPencil, mdiTrashCan } from "@mdi/js";
import { useAcademicGroup } from "../Composables/useAcademicGroup.js";
import { provide } from "vue";

const props = defineProps({
    title: {
        type: String,
        required: true,
    },
    routeName: {
        type: String,
        required: true,
    },
    academicBodies: {
        type: Object,
        default: () => ({}),
        required: true,
    },
    filters: {
        type: Object,
        required: true,
    },
    modelClass: {
        type: String,
        required: true,
    },
});

const { filters, clearFilters, applyFilters, isLoading, sortByColumn } = useFilters(props.filters, props.routeName);
const { deleteForm, enable } = useAcademicGroup(props);
const canEnable = () => verifyPermission(`${props.routeName}enable`);

provide("filters", filters);
provide('sortByColumn', sortByColumn);

</script>