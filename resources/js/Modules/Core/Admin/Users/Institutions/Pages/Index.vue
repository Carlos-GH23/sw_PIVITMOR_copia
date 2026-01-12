<template>
    <HeadLogo :title="title" />
    <loading v-model:active="isLoading" :can-cancel="false" :is-full-page="true" loader="dots" color="#283C2A" />
    <LayoutAuthenticated>
        <SectionTitleLineWithButton :icon="mdiDomain" :title="title" main />

        <SearchBar @apply-filters="applyFilters" @clear-filters="clearFilters" v-model:search="filters.search"
            v-model:rows="filters.rows" :routeName="routeName" :total="institutions.meta.total" />

        <CardBox v-if="institutions.data.length > 0">
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
                        <SortableHeader @sort="sortByColumn" :filters="filters" column="institution_types.name"
                            label="Tipo" />
                        <SortableHeader @sort="sortByColumn" :filters="filters" column="institution_categories.name"
                            label="Categoría" />
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="item in institutions.data" :key="item.id">
                        <td>
                            <TableCheckboxCell v-if="canEnable()" @confirm="enableService(item)" type="switch"
                                :model-value="item.is_active === 1" confirm />
                        </td>
                        <td data-label="Nombre">
                            {{ item.name }}
                        </td>
                        <td data-label="Tipo">
                            {{ item.institution_type?.name || 'Sin tipo' }}
                        </td>
                        <td data-label="Categoría">
                            {{ item.institution_type?.institution_category?.name || 'Sin categoría' }}
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
        <Pagination :links="institutions.meta.links" :total="institutions.meta.total" :to="institutions.meta.to"
            :from="institutions.meta.from" />
        <InstitutionModal :institution="selectedInstitution" :modelValue="showModal"
            @update:modelValue="showModal = $event" />
    </LayoutAuthenticated>
</template>
<script setup>
import { ref } from 'vue';
import { router } from '@inertiajs/vue3';
import InstitutionModal from '../Components/InstitutionModal.vue';
import { mdiFilePdfBox, mdiDomain, mdiEye, mdiFileExcel } from '@mdi/js';
import CardBox from "@/Components/CardBox.vue";
import SectionTitleLineWithButton from "@/Components/SectionTitleLineWithButton.vue";
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

const props = defineProps({
    title: {
        type: String,
        required: true,
    },
    institutions: {
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
const canEnable = () => verifyPermission('users.institutionProfile.enable');

const enableService = async (institution) => {
    router.patch(route("users.institutionProfile.enable", institution.id), {
        preserveState: true,
        preserveScroll: true,
    });
};

const exportPdf = () => {
    window.open(route('users.institutionProfile.exportPdf'), '_blank');
};

const exportExcel = () => {
    window.open(route('users.institutionProfile.exportExcel'), '_blank');
};

const showModal = ref(false);
const selectedInstitution = ref({});

function openModal(item) {
    selectedInstitution.value = item;
    showModal.value = true;
}
</script>
