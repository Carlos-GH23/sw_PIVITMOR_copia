<template>
    <HeadLogo :title="title" />
    <loading v-model:active="isLoading" :can-cancel="false" :is-full-page="true" loader="dots" color="#283C2A" />
    <LayoutMain>
        <SectionTitleLineWithButton :icon="mdiViewModule" :title="title" main />

        <SearchBar @apply-filters="applyFilters" @clear-filters="clearFilters" v-model:search="filters.search"
            v-model:rows="filters.rows" :routeName="routeName" title="Propiedades Intelectuales"
            :total="intellectualProperties?.meta?.total || 0" />

        <CardBox v-if="intellectualProperties && intellectualProperties.data.length > 0">
            <table>
                <thead>
                    <tr>
                        <SortableHeader @sort="sortByColumn" :filters="filters" column="id" label="ID" />
                        <SortableHeader @sort="sortByColumn" :filters="filters" column="name" label="Propiedad Intelectual" />
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="property in intellectualProperties.data" :key="property.id">
                        <td data-label="id">{{ property.id }}</td>
                        <td data-label="Nombre">{{ property.name }}</td>
                        <td data-label="Acciones">
                            <BaseButtons>
                                <BaseButton color="info" :icon="mdiPencil" small :routeName="`${routeName}edit`"
                                    :parameter="property.id" title="Editar Propiedad Intelectual" />
                                <BaseButton color="danger" :icon="mdiTrashCan" small @click="deleteForm(property)"
                                    title="Eliminar instalación" />
                            </BaseButtons>
                        </td>
                    </tr>
                </tbody>
            </table>
        </CardBox>
        <CardBoxComponentEmpty v-else />
        <pagination :links="intellectualProperties?.meta?.links || []" :total="intellectualProperties?.meta?.total || 0"
            :to="intellectualProperties?.meta?.to || 0" :from="intellectualProperties?.meta?.from || 0" />
    </LayoutMain>
</template>

<script setup>
import CardBox from "@/Components/CardBox.vue";
import LayoutMain from "@/Layouts/LayoutMain.vue";
import SectionTitleLineWithButton from "@/Components/SectionTitleLineWithButton.vue";
import { mdiViewModule, mdiPencil, mdiTrashCan } from "@mdi/js";
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
    title: String,
    intellectualProperties: Object,
    routeName: String,
    filters: Object,
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
