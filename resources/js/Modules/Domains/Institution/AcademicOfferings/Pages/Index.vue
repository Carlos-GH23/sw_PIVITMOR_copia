<template>
    <HeadLogo :title="title" />
    <loading v-model:active="isLoading" :can-cancel="false" :is-full-page="true" loader="dots" color="#283C2A" />
    <LayoutMain>
        <SectionTitleLineWithButton :icon="mdiOfficeBuilding" :title="title" main />

        <SearchBar @apply-filters="applyFilters" @clear-filters="clearFilters" v-model:search="filters.search"
            v-model:rows="filters.rows" :routeName="routeName" :total="offerings.meta.total" />

        <CardBox v-if="offerings.data.length > 0" class="mb-6">
            <table>
                <thead>
                    <tr>
                        <th />
                        <SortableHeader @sort="sortByColumn" :filters="filters" column="name" label="Nombre"/>
                        <SortableHeader @sort="sortByColumn" :filters="filters" column="educational_level" label="Nivel Educativo"/>
                        <SortableHeader @sort="sortByColumn" :filters="filters" column="department" label="Departamento"/>
                        <SortableHeader @sort="sortByColumn" :filters="filters" column="is_active" label="Estatus"/>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="item in offerings.data" :key="item.id">
                        <TableCheckboxCell @confirm="enableForm(item.id)" type="switch"
                            v-model="item.is_active" confirm />
                        <td data-label="Nombre">
                            {{ item.name }}
                        </td>
                        <td data-label="Nivel Educativo">
                            {{ item.educational_level?.name }}
                        </td>
                        <td data-label="Departamento">
                            {{ item.department?.name }}
                        </td>
                        <td data-label="Estatus">
                            <Badge :color="item.is_active ? 'green' : 'red'">
                                {{ item.is_active ? 'Activo' : 'Inactivo' }}
                            </Badge>
                        </td>
                        <td class="before:hidden lg:w-1 whitespace-nowrap">
                            <BaseButtons>
                                <BaseButton color="info" :icon="mdiPencil" :route-name="`${routeName}edit`"
                                    :parameter="item.id" title="Editar" />
                                <BaseButton @click="deleteAcademicOffering(item.id)" color="danger" :icon="mdiTrashCan"
                                    title="Eliminar oferta educativa" />
                            </BaseButtons>
                        </td>
                    </tr>
                </tbody>
            </table>
        </CardBox>
        <CardBoxComponentEmpty v-else />
        <Pagination :links="offerings.meta.links" :total="offerings.meta.total" :to="offerings.meta.to"
            :from="offerings.meta.from" />
    </LayoutMain>
</template>

<script setup>
import LayoutMain from '@/Layouts/LayoutMain.vue';
import SectionTitleLineWithButton from '@/Components/SectionTitleLineWithButton.vue';
import CardBox from '@/Components/CardBox.vue';
import BaseButton from '@/Components/BaseButton.vue';
import BaseButtons from '@/Components/BaseButtons.vue';
import HeadLogo from '@/Components/HeadLogo.vue';
import CardBoxComponentEmpty from '@/Components/CardBoxComponentEmpty.vue';
import Pagination from '@/Components/Pagination.vue';
import SearchBar from "@/Components/SearchBar.vue";
import { mdiOfficeBuilding, mdiPencil, mdiTrashCan } from '@mdi/js';
import { useFilters } from '@/Hooks/useFilters';
import { useAcademicOffering } from '../Composables/useAcademicOffering';
import Badge from '@/Components/Badge.vue';
import SortableHeader from '@/Components/Table/SortableHeader.vue';
import TableCheckboxCell from '@/Components/TableCheckboxCell.vue';

const props = defineProps({
    title: { type: String, required: true },
    offerings: { type: Object, required: true },
    routeName: { type: String, required: true },
    filters: { type: Object, required: true },
});
const { filters, clearFilters, applyFilters, isLoading, sortByColumn } = useFilters(props.filters, props.routeName);
const { deleteAcademicOffering, enableForm } = useAcademicOffering({});

</script>
