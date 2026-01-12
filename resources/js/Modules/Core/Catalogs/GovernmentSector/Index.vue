<template>
    <HeadLogo :title="title" />
    <loading v-model:active="isLoading" :can-cancel="false" :is-full-page="true" loader="dots" color="#283C2A" />
    <LayoutMain>
        <SectionTitleLineWithButton :icon="mdiViewModule" :title="title" main />

        <SearchBar @apply-filters="applyFilters" @clear-filters="clearFilters" v-model:search="filters.search"
            v-model:rows="filters.rows" :routeName="routeName" title="Tipo de Instalación"
            :total="governmentSectors.meta.total" />

        <CardBox v-if="governmentSectors.data.length > 0">
            <table>
                <thead>
                    <tr>
                        <SortableHeader @sort="sortByColumn" :filters="filters" column="name" label="Nombre" />
                        <SortableHeader @sort="sortByColumn" :filters="filters" column="description" label="Descripción" />
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="item in governmentSectors.data" :key="item.id">
                        <td data-label="Nombre">
                            {{ item.name }}
                        </td>
                        <td data-label="Descripción">
                            {{ item.description }}
                        </td>
                        <td data-label="acciones">
                            <BaseButtons>
                                <BaseButton color="info" :icon="mdiPencil" small :routeName="`${routeName}edit`"
                                    :parameter="item.id" title="Editar módulo" />
                                    :parameter="item.id" title="Editar métrica" />
                                <BaseButton color="danger" :icon="mdiTrashCan" small @click="deleteForm(item)"
                                    title="Eliminar instalación" />
                            </BaseButtons>
                        </td>
                    </tr>
                </tbody>
            </table>
        </CardBox>
        <CardBoxComponentEmpty v-else />
        <pagination :links="governmentSectors.meta.links" :total="governmentSectors.meta.total" :to="governmentSectors.meta.to"
            :from="governmentSectors.meta.from" />
    </LayoutMain>
</template>
<script setup>
import CardBox from "@/Components/CardBox.vue";
import LayoutMain from "@/Layouts/LayoutMain.vue";
import SectionTitleLineWithButton from "@/Components/SectionTitleLineWithButton.vue";
import {
    mdiViewModule,
    mdiPencil,
    mdiTrashCan
} from "@mdi/js";
import BaseButton from "@/Components/BaseButton.vue";
import BaseButtons from "@/Components/BaseButtons.vue";
import CardBoxComponentEmpty from "@/Components/CardBoxComponentEmpty.vue";
import Pagination from "@/Components/Pagination.vue";
import HeadLogo from "@/Components/HeadLogo.vue";
import { useFilters } from "@/Hooks/useFilters";
import SearchBar from "@/Components/SearchBar.vue";
import SortableHeader from "@/Components/Table/SortableHeader.vue";
import { messageConfirm } from "@/Hooks/useErrorsForm";
import { router } from "@inertiajs/vue3";

const props = defineProps({
    title: {
        type: String,
        required: true,
    },
    governmentSectors: {
        type: Object,
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

const deleteForm = (item) => {
    messageConfirm().then((res) => {
        if (res.isConfirmed) {
            router.delete(route(`${props.routeName}destroy`, item));
        }
    });
};
</script>