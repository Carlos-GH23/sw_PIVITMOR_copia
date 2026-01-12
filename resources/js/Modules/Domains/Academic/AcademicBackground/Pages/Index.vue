<template>
    <HeadLogo :title="title" />
    <loading v-model:active="isLoading" :can-cancel="false" :is-full-page="true" loader="dots" color="#283C2A" />
    <LayoutAuthenticated>
        <SectionTitleLineWithButton :icon="mdiSchool" :title="title" main>
            <template #right>
                <BaseButton :icon="mdiPlus" color="success" :routeName="`${routeName}create`" label="Crear" small />
            </template>
        </SectionTitleLineWithButton>

        <SearchBar @apply-filters="applyFilters" @clear-filters="clearFilters" v-model:search="filters.search"
            v-model:rows="filters.rows" :routeName="routeName" title=" "
            :total="academicBackgrounds?.meta?.total || 0" />

        <CardBox v-if="academicBackgrounds?.data && academicBackgrounds.data.length > 0">
            <table>
                <thead>
                    <tr>
                        <SortableHeader @sort="sortByColumn" :filters="filters" column="academic_degree" label="Grado"/>
                        <SortableHeader @sort="sortByColumn" :filters="filters" column="academic_title" label="Título"/>
                        <SortableHeader @sort="sortByColumn" :filters="filters" column="knowledge_area" label="Área de conocimiento"/>
                        <SortableHeader @sort="sortByColumn" :filters="filters" column="degree_obtained_at" label="Fecha de obtención"/>
                        <SortableHeader @sort="sortByColumn" :filters="filters" column="certificate_number" label="No. de cédula"/>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="item in academicBackgrounds.data" :key="item.id">
                        <td data-label="Grado">{{ item.academic_degree?.name ?? '-' }}</td>
                        <td data-label="Título">{{ item.academic_title }}</td>
                        <td data-label="Área de conocimiento">{{ item.knowledge_area?.name ?? '-' }}</td>
                        <td data-label="Fecha de obtención">{{ item.degree_obtained_at }}</td>
                        <td data-label="No. de cédula">{{ item.certificate_number }}</td>
                        <td data-label="Acciones">
                            <BaseButtons>
                                <BaseButton color="info" :icon="mdiPencil" small :routeName="`${routeName}edit`"
                                    :parameter="item.id" title="Editar" />
                                <BaseButton color="danger" :icon="mdiTrashCan" small
                                    @click="deleteAcademicBackground(item.id)" title="Eliminar formación académica" />
                            </BaseButtons>
                        </td>
                    </tr>
                </tbody>
            </table>
        </CardBox>
        <CardBoxComponentEmpty v-else />

        <Pagination v-if="academicBackgrounds?.meta" :links="academicBackgrounds.meta.links"
            :total="academicBackgrounds.meta.total" :to="academicBackgrounds.meta.to"
            :from="academicBackgrounds.meta.from" :per_page="Number(filters.rows)"
            typeRecords="formaciones académicas" />
    </LayoutAuthenticated>
</template>

<script setup>
import CardBox from "@/Components/CardBox.vue";
import SectionTitleLineWithButton from "@/Components/SectionTitleLineWithButton.vue";
import { mdiSchool, mdiPencil, mdiPlus, mdiTrashCan } from "@mdi/js";
import BaseButton from "@/Components/BaseButton.vue";
import BaseButtons from "@/Components/BaseButtons.vue";
import CardBoxComponentEmpty from "@/Components/CardBoxComponentEmpty.vue";
import Pagination from "@/Components/Pagination.vue";
import HeadLogo from "@/Components/HeadLogo.vue";
import LayoutAuthenticated from "@/Layouts/LayoutAuthenticated.vue";
import { useFilters } from "@/Hooks/useFilters";
import SearchBar from "@/Components/SearchBar.vue";
import { deleteAcademicBackground } from "../Composables/useAcademicBackground";
import SortableHeader from '@/Components/Table/SortableHeader.vue';

const props = defineProps({
    title: { type: String, default: "Formación académica" },
    routeName: { type: String, required: true },
    academicBackgrounds: { type: Object, required: true },
    filters: {
        type: Object,
        default: () => ({ search: "", rows: 10, withTrashed: false }),
    },
});

const { filters, clearFilters, applyFilters, isLoading, sortByColumn } = useFilters(props.filters, props.routeName);
</script>