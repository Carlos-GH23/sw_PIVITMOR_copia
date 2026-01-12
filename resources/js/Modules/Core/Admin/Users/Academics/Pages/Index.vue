<template>
    <HeadLogo :title="title" />
    <loading v-model:active="isLoading" :can-cancel="false" :is-full-page="true" loader="dots" color="#283C2A" />
    <LayoutAuthenticated>
        <SectionTitleLineWithButton :icon="mdiSchoolOutline" :title="title" main />
        <SearchBar @apply-filters="applyFilters" @clear-filters="clearFilters" v-model:search="filters.search"
            v-model:rows="filters.rows" :routeName="routeName" :total="academics.meta.total" />

        <CardBox v-if="academics.data.length > 0">
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
                        <SortableHeader @sort="sortByColumn" :filters="filters" column="department.name"
                            label="Departamento" />
                        <SortableHeader @sort="sortByColumn" :filters="filters" column="department.institution.name"
                            label="Institución" />
                        <SortableHeader @sort="sortByColumn" :filters="filters"
                            column="active_technology_services_count" label="Servicios Tecnológicos Activos" />
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="item in academics.data" :key="item.id">
                        <td>
                            <TableCheckboxCell v-if="canEnable()" @confirm="enableService(item)" type="switch"
                                :model-value="item.is_active === 1" confirm />
                        </td>
                        <td data-label="Nombre">
                            {{ item.name }}
                        </td>
                        <td data-label="Departamento">
                            {{ item.department?.name || 'Sin departamento' }}
                        </td>
                        <td data-label="Institución">
                            {{ item.department?.institution?.name || 'Sin institución' }}
                        </td>
                        <td data-label="Servicios Tecnológicos Activos">
                            {{ item.active_technology_services_count ?? 0 }}
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
            <AcademicModal :academic="selectedAcademic" :modelValue="showModal"
                @update:modelValue="showModal = $event" />
        </CardBox>
        <CardBoxComponentEmpty v-else />
        <Pagination :links="academics.meta.links" :total="academics.meta.total" :to="academics.meta.to"
            :from="academics.meta.from" />
    </LayoutAuthenticated>
</template>
<script setup>
import { ref } from 'vue';
import { router } from '@inertiajs/vue3';
import AcademicModal from '../Components/AcademicModal.vue';
import CardBox from "@/Components/CardBox.vue";
import SectionTitleLineWithButton from "@/Components/SectionTitleLineWithButton.vue";
import { mdiEye, mdiFileExcel, mdiFilePdfBox, mdiSchoolOutline } from "@mdi/js";
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
    academics: {
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
const canEnable = () => verifyPermission('users.academicProfile.enable');

const enableService = async (academic) => {
    router.patch(route("users.academicProfile.enable", academic.id), {
        preserveState: true,
        preserveScroll: true,
    });
};

const exportPdf = () => {
    window.open(route('users.academicProfile.exportPdf'), '_blank');
};

const exportExcel = () => {
    window.open(route('users.academicProfile.exportExcel'), '_blank');
};

const showModal = ref(false);
const selectedAcademic = ref({});

function openModal(item) {
    selectedAcademic.value = item;
    showModal.value = true;
}
</script>
