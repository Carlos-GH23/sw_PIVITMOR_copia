<template>
    <HeadLogo :title="title" />
    <loading v-model:active="isLoading" :can-cancel="false" :is-full-page="true" loader="dots" color="#283C2A" />
    <LayoutAuthenticated>
        <SectionTitleLineWithButton :icon="mdiHandshakeOutline" :title="title" main />

        <SearchBar @apply-filters="applyFilters" @clear-filters="clearFilters" v-model:search="filters.search"
            v-model:rows="filters.rows" :routeName="routeName" :total="organizations.meta.total" />

        <CardBox v-if="organizations.data.length > 0">
            <table>
                <thead>
                    <tr>
                        <th colspan="6" class="pb-0">
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
                        <SortableHeader @sort="sortByColumn" :filters="filters" column="description"
                            label="Descripción" />
                        <SortableHeader @sort="sortByColumn" :filters="filters" column="rfc" label="RFC" />
                        <SortableHeader @sort="sortByColumn" :filters="filters" column="legal_representative"
                            label="Representante Legal" />
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="item in organizations.data" :key="item.id">
                        <td v-if="canEnable()">
                            <TableCheckboxCell @confirm="enableOrganization(item)" type="switch"
                                :model-value="item.is_active === 1" confirm />
                        </td>
                        <td data-label="Nombre">
                            {{ item.name }}
                        </td>
                        <td data-label="Descripción">
                            {{ item.description || '-' }}
                        </td>
                        <td data-label="RFC">
                            {{ item.rfc || '-' }}
                        </td>
                        <td data-label="Representante Legal">
                            {{ item.legal_representative || '-' }}
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
            <NonProfitOrganizationModal :organization="selectedOrganization" v-model="showModal" />
        </CardBox>
        <CardBoxComponentEmpty v-else />
        <Pagination :links="organizations.meta.links" :total="organizations.meta.total" :to="organizations.meta.to"
            :from="organizations.meta.from" />
    </LayoutAuthenticated>
</template>
<script setup>
import { ref } from 'vue';
import { router } from '@inertiajs/vue3';
import { useFilters } from "@/Hooks/useFilters";
import { verifyPermission } from '@/Hooks/usePermissions';
import { mdiEye, mdiFileExcel, mdiFilePdfBox, mdiHandshakeOutline } from "@mdi/js";
import CardBox from "@/Components/CardBox.vue";
import SectionTitleLineWithButton from "@/Components/SectionTitleLineWithButton.vue";
import CardBoxComponentEmpty from "@/Components/CardBoxComponentEmpty.vue";
import Pagination from "@/Components/Pagination.vue";
import HeadLogo from "@/Components/HeadLogo.vue";
import LayoutAuthenticated from "@/Layouts/LayoutAuthenticated.vue";
import SearchBar from "@/Components/SearchBar.vue";
import TableCheckboxCell from "@/Components/TableCheckboxCell.vue";
import SortableHeader from '@/Components/Table/SortableHeader.vue';
import BaseButton from '@/Components/BaseButton.vue';
import BaseButtons from '@/Components/BaseButtons.vue';
import NonProfitOrganizationModal from '../Components/NonProfitOrganizationModal.vue';

const props = defineProps({
    title: {
        type: String,
        required: true,
    },
    organizations: {
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
const canEnable = () => verifyPermission('users.nonProfitOrganizationProfile.enable');

const enableOrganization = async (organization) => {
    router.patch(route("users.nonProfitOrganizationProfile.enable", organization.id), {
        preserveState: true,
        preserveScroll: true,
    });
};

const exportPdf = () => {
    window.open(route('users.nonProfitOrganizationProfile.exportPdf'), '_blank');
};

const exportExcel = () => {
    window.open(route('users.nonProfitOrganizationProfile.exportExcel'), '_blank');
};

const showModal = ref(false);
const selectedOrganization = ref({});

function openModal(item) {
    selectedOrganization.value = item;
    showModal.value = true;
}
</script>
