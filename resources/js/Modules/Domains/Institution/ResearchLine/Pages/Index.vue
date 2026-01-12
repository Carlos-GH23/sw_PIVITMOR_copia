<template>
    <HeadLogo :title="title" />
    <loading v-model:active="isLoading" :can-cancel="false" :is-full-page="true" loader="dots" color="#283C2A" />
    <LayoutMain>
        <SectionTitleLineWithButton :icon="mdiLayersSearchOutline" :title="title" main />

        <SearchBar @apply-filters="applyFilters" @clear-filters="clearFilters" v-model:search="filters.search"
            v-model:rows="filters.rows" :routeName="routeName" title="grupos académicos"
            :total="researchLines.meta.total" />

        <CardBox isForm>
            <CSVUpload :model_class="modelClass" />
        </CardBox>

        <CardBox v-if="researchLines.data.length > 0" class="mt-2">
            <table>
                <thead>
                    <tr>
                        <th v-if="canEnable"></th>
                        <SortableHeader @sort="sortByColumn" :filters="filters" column="name" label="Nombre" />
                        <SortableHeader @sort="sortByColumn" :filters="filters" column="department"
                            label="Departamento Académico" />
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="item in researchLines.data" :key="item.id">
                        <TableCheckboxCell v-if="canEnable" @confirm="enable(item.id)" type="switch"
                            v-model="item.is_active" confirm />
                        <td data-label="Nombre">
                            {{ item.name }}
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
        <pagination :links="researchLines.meta.links" :total="researchLines.meta.total" :to="researchLines.meta.to"
            :from="researchLines.meta.from" />
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
import { useResearchLine } from "../Composables/useResearchLine.js";
import { mdiLayersSearchOutline, mdiPencil, mdiTrashCan } from "@mdi/js";

const props = defineProps({
    title: String,
    routeName: String,
    researchLines: Object,
    filters: Object,
    modelClass: String,
});

const { filters, clearFilters, applyFilters, isLoading, sortByColumn } = useFilters(props.filters, props.routeName);
const { deleteForm, enable } = useResearchLine(props);
const canEnable = () => verifyPermission(`${props.routeName}enable`);
</script>
