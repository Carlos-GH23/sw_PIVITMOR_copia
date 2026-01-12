<template>
    <HeadLogo :title="title" />
    <loading v-model:active="isLoading" :can-cancel="false" :is-full-page="true" loader="dots" color="#283C2A" />
    <LayoutMain>
        <SectionTitleLineWithButton :icon="mdiHandCoin" :title="title" main />

        <SearchBar @apply-filters="applyFilters" @clear-filters="clearFilters" v-model:search="filters.search"
            v-model:rows="filters.rows" :total="requirements.meta.total" />

        <CardBox v-if="requirements.data.length > 0">
            <table>
                <thead>
                    <tr>
                        <SortableHeader @sort="sortByColumn" :filters="filters" column="title" label="Titulo" />
                        <SortableHeader @sort="sortByColumn" :filters="filters" column="department" label="Departamento" />
                        <SortableHeader @sort="sortByColumn" :filters="filters" column="start_date" label="Inicio" />
                        <SortableHeader @sort="sortByColumn" :filters="filters" column="end_date" label="Cierre" />
                        <th>Estatus </th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="item in requirements.data" :key="item.id">
                        <td data-label="Titulo">
                            <div class="leading-relaxed line-clamp-2">
                                {{ item.title }}
                            </div>
                        </td>
                        <td data-label="Departamento">
                            {{ item.department?.name }}
                        </td>
                        <td data-label="Inicio">
                            {{ item.start_date.human }}
                        </td>
                        <td data-label="Fin">
                            {{ item.end_date.human }}
                        </td>
                        <td data-label="Estatus">
                            <Badge :color="item.requirement_status.color" size="md" showDot
                                :title="item.requirement_status.description">
                                {{ item.requirement_status.name }}
                            </Badge>
                        </td>
                        <td data-label="acciones">
                            <BaseButtons>
                                <BaseButton color="success" :icon="mdiCheckDecagram" small
                                    :routeName="`${routeName}create`" :parameter="item.id" title="Editar" />
                            </BaseButtons>
                        </td>
                    </tr>
                </tbody>
            </table>
        </CardBox>
        <CardBoxComponentEmpty v-else />
        <pagination :links="requirements.meta.links" :total="requirements.meta.total" :to="requirements.meta.to"
            :from="requirements.meta.from" />
    </LayoutMain>
</template>
<script setup>
import CardBox from "@/Components/CardBox.vue";
import LayoutMain from "@/Layouts/LayoutMain.vue";
import SectionTitleLineWithButton from "@/Components/SectionTitleLineWithButton.vue";
import {
    mdiHandCoin,
    mdiCheckDecagram,
} from "@mdi/js";
import BaseButton from "@/Components/BaseButton.vue";
import BaseButtons from "@/Components/BaseButtons.vue";
import CardBoxComponentEmpty from "@/Components/CardBoxComponentEmpty.vue";
import Pagination from "@/Components/Pagination.vue";
import HeadLogo from "@/Components/HeadLogo.vue";
import { useFilters } from "@/Hooks/useFilters";
import SearchBar from "@/Components/SearchBar.vue";
import Badge from "@/Components/Badge.vue";
import SortableHeader from "@/Components/Table/SortableHeader.vue";

const props = defineProps({
    title: {
        type: String,
        required: true,
    },
    requirements: {
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
});

const { filters, clearFilters, applyFilters, isLoading, sortByColumn } = useFilters(props.filters, props.routeName);
</script>