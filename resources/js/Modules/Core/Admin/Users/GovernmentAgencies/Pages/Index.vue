<template>
    <HeadLogo :title="title" />
    <loading v-model:active="isLoading" :can-cancel="false" :is-full-page="true" loader="dots" color="#283C2A" />
    <LayoutAuthenticated>
        <SectionTitleLineWithButton :icon="mdiTownHall" :title="title" main />

        <SearchBar @apply-filters="applyFilters" @clear-filters="clearFilters" v-model:search="filters.search"
            v-model:rows="filters.rows" :routeName="routeName" :total="agencies.meta.total" />

        <CardBox v-if="agencies.data.length > 0">
            <table>
                <thead>
                    <tr>
                        <th colspan="7" class="pb-0">
                            <div class="flex justify-start">
                                <BaseButtons>
                                    <BaseButton color="danger" :icon="mdiFilePdfBox" :iconSize="32" small
                                        title="Exportar PDF" @click="exportPdf" />
                                    <BaseButton color="success" :icon="mdiFileExcel" :iconSize="32" small
                                        title="Exportar Excel" @click="exportExcel" />
                                </BaseButtons>
                            </div>
                        </th>
                    </tr>
                    <tr>
                        <th v-if="canEnable()"></th>
                        <SortableHeader @sort="sortByColumn" :filters="filters" column="name" label="Nombre" />
                        <SortableHeader @sort="sortByColumn" :filters="filters" column="acronym" label="Acrónimo" />
                        <SortableHeader @sort="sortByColumn" :filters="filters" column="government_sector_id"
                            label="Sector Económico" />
                        <SortableHeader @sort="sortByColumn" :filters="filters" column="government_level_id"
                            label="Nivel de Gobierno" />
                        <SortableHeader @sort="sortByColumn" :filters="filters" column="objectives" label="Objetivos" />
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="item in agencies.data" :key="item.id">
                        <td>
                            <TableCheckboxCell v-if="canEnable()" @confirm="enableAgency(item)" type="switch"
                                :model-value="item.is_active === 1" confirm />
                        </td>
                        <td data-label="Nombre">
                            {{ item.name }}
                        </td>
                        <td data-label="Acrónimo">
                            {{ item.acronym || 'Sin acrónimo' }}
                        </td>
                        <td data-label="Sector Económico">
                            {{ item.government_sector?.name || 'Sin sector' }}
                        </td>
                        <td data-label="Nivel de Gobierno">
                            {{ item.government_level?.name || 'Sin nivel' }}
                        </td>
                        <td data-label="Objetivos">
                            {{ item.objectives || 'Sin objetivos' }}
                        </td>
                        <td data-label="Acciones">
                            <BaseButtons>
                                <BaseButton color="info" :icon="mdiEye" small title="Ver detalles"
                                    @click="openModal(item)" />
                            </BaseButtons>
                        </td>
                    </tr>
                </tbody>
            </table>
        </CardBox>
        <CardBoxComponentEmpty v-else />
        <Pagination :links="agencies.meta.links" :total="agencies.meta.total" :to="agencies.meta.to"
            :from="agencies.meta.from" />
        <GovernmentAgencyModal :agency="selectedAgency" v-model="showModal" />
    </LayoutAuthenticated>
</template>
<script setup>
import { router } from '@inertiajs/vue3';
import CardBox from "@/Components/CardBox.vue";
import SectionTitleLineWithButton from "@/Components/SectionTitleLineWithButton.vue";
import { mdiEye, mdiFileExcel, mdiFilePdfBox, mdiTownHall } from "@mdi/js";
import CardBoxComponentEmpty from "@/Components/CardBoxComponentEmpty.vue";
import Pagination from "@/Components/Pagination.vue";
import HeadLogo from "@/Components/HeadLogo.vue";
import { verifyPermission } from '@/Hooks/usePermissions';
import LayoutAuthenticated from "@/Layouts/LayoutAuthenticated.vue";
import { useFilters } from "@/Hooks/useFilters";
import SearchBar from "@/Components/SearchBar.vue";
import TableCheckboxCell from "@/Components/TableCheckboxCell.vue";
import BaseButtons from "@/Components/BaseButtons.vue";
import BaseButton from "@/Components/BaseButton.vue";
import { ref } from 'vue';
import SortableHeader from '@/Components/Table/SortableHeader.vue';
import GovernmentAgencyModal from '../Components/GovernmentAgencyModal.vue';

const props = defineProps({
    title: {
        type: String,
        required: true,
    },
    agencies: {
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
const canEnable = () => verifyPermission('users.governmentAgencyProfile.enable');

const enableAgency = async (agency) => {
    router.patch(route("users.governmentAgencyProfile.enable", agency.id), {
        preserveState: true,
        preserveScroll: true,
    });
};

const exportPdf = () => {
    window.open(route('users.governmentAgencyProfile.exportPdf'), '_blank');
};

const exportExcel = () => {
    window.open(route('users.governmentAgencyProfile.exportExcel'), '_blank');
};

const showModal = ref(false);
const selectedAgency = ref({});

function openModal(item) {
    selectedAgency.value = item;
    showModal.value = true;
}
</script>
