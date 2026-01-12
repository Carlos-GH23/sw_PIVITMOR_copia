<template>
    <HeadLogo :title="title" />
    <loading v-model:active="isLoading" :can-cancel="false" :is-full-page="true" loader="dots" color="#283C2A" />
    <LayoutAuthenticated>
        <SectionTitleLineWithButton :icon="mdiFactory" :title="title" main />

        <SearchBar @apply-filters="applyFilters" @clear-filters="clearFilters" v-model:search="filters.search"
            v-model:rows="filters.rows" :routeName="routeName" :total="companies.meta.total" />

        <CardBox v-if="companies.data.length > 0">
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
                        <SortableHeader @sort="sortByColumn" :filters="filters" column="legal_name"
                            label="Razón Social" />
                        <SortableHeader @sort="sortByColumn" :filters="filters" column="rfc" label="RFC" />
                        <SortableHeader @sort="sortByColumn" :filters="filters" column="year" label="Año" />
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="item in companies.data" :key="item.id">
                        <td>
                            <TableCheckboxCell v-if="canEnable()" @confirm="enableCompany(item)" type="switch"
                                :model-value="item.is_active === 1" confirm />
                        </td>
                        <td data-label="Nombre">
                            {{ item.name }}
                        </td>
                        <td data-label="Razón Social">
                            {{ item.legal_name || 'Sin razón social' }}
                        </td>
                        <td data-label="RFC">
                            {{ item.rfc || 'Sin RFC' }}
                        </td>
                        <td data-label="Año">
                            {{ item.year || 'Sin año' }}
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
            <CompanyModal :company="selectedCompany" v-model:modelValue="showModal" />
        </CardBox>
        <CardBoxComponentEmpty v-else />
        <Pagination :links="companies.meta.links" :total="companies.meta.total" :to="companies.meta.to"
            :from="companies.meta.from" />
    </LayoutAuthenticated>
</template>
<script setup>
import { ref } from 'vue';
import { router } from '@inertiajs/vue3';
import CardBox from "@/Components/CardBox.vue";
import SectionTitleLineWithButton from "@/Components/SectionTitleLineWithButton.vue";
import { mdiEye, mdiFactory, mdiFileExcel, mdiFilePdfBox } from "@mdi/js";
import BaseButton from "@/Components/BaseButton.vue";
import BaseButtons from "@/Components/BaseButtons.vue";
import CardBoxComponentEmpty from "@/Components/CardBoxComponentEmpty.vue";
import Pagination from "@/Components/Pagination.vue";
import HeadLogo from "@/Components/HeadLogo.vue";
import { verifyPermission } from '@/Hooks/usePermissions';
import LayoutAuthenticated from "@/Layouts/LayoutAuthenticated.vue";
import { useFilters } from "@/Hooks/useFilters";
import SearchBar from "@/Components/SearchBar.vue";
import TableCheckboxCell from "@/Components/TableCheckboxCell.vue";
import SortableHeader from '@/Components/Table/SortableHeader.vue';
import CompanyModal from '../Components/CompanyModal.vue';

const props = defineProps({
    title: {
        type: String,
        required: true,
    },
    companies: {
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
const canEnable = () => verifyPermission('users.companyProfile.enable');

const enableCompany = async (company) => {
    router.patch(route("users.companyProfile.enable", company.id), {
        preserveState: true,
        preserveScroll: true,
    });
};

const exportPdf = () => {
    window.open(route('users.companyProfile.exportPdf'), '_blank');
};

const exportExcel = () => {
    window.open(route('users.companyProfile.exportExcel'), '_blank');
};

const showModal = ref(false);
const selectedCompany = ref({});

function openModal(item) {
    selectedCompany.value = item;
    showModal.value = true;
}
</script>
