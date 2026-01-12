<template>
    <HeadLogo :title="title" />
    <loading v-model:active="isLoading" :can-cancel="false" :is-full-page="true" loader="dots" color="#283C2A" />

    <LayoutAuthenticated>
        <SectionTitleLineWithButton :icon="mdiOfficeBuilding" :title="title" main>
            <template #right>
                <BaseButton :icon="mdiPlus" color="success" :routeName="`${routeName}create`" label="Crear" small />
            </template>
        </SectionTitleLineWithButton>

        <SearchBar @apply-filters="applyFilters" @clear-filters="clearFilters" v-model:search="filters.search"
            v-model:rows="filters.rows" :routeName="routeName" :total="certificationData?.meta?.total" />

        <CardBox isForm>
            <CSVUpload :model_class="model_class" />
        </CardBox>

        <CardBox v-if="certificationData?.data && certificationData.data.length > 0" class="mt-2">
            <table>
                <thead>
                    <tr>
                        <th v-if="canEnable"></th>
                        <SortableHeader @sort="sortByColumn" :filters="filters" column="name" label="Nombre" />
                        <SortableHeader @sort="sortByColumn" :filters="filters" column="certification_type"
                            label="Tipo de certificación" />
                        <SortableHeader @sort="sortByColumn" :filters="filters" column="department"
                            label="Departamento" />
                        <SortableHeader @sort="sortByColumn" :filters="filters" column="certifying_entity"
                            label="Entidad Certificadora" />
                        <th class="w-32">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="item in certificationData.data" :key="item.id">
                        <TableCheckboxCell v-if="canEnable" @confirm="enableCertification(item.id)" type="switch"
                            v-model="item.is_active" confirm />
                        <td data-label="Nombre">{{ item.name }}</td>
                        <td data-label="Tipo de Certificación">{{ item.certification_type?.name }}</td>
                        <td data-label="Departamento">{{ item.department?.name }}</td>
                        <td data-label="Entidad Certificadora">{{ item.certifying_entity }}</td>
                        <td data-label="Acciones">
                            <BaseButtons>
                                <BaseButton color="info" :icon="mdiPencil" small :routeName="`${routeName}edit`"
                                    :parameter="item.id" title="Editar" />
                                <BaseButton color="danger" :icon="mdiTrashCan" small @click="deleteCertification(item)"
                                    title="Eliminar certificación" />
                            </BaseButtons>
                        </td>
                    </tr>
                </tbody>
            </table>
        </CardBox>
        <CardBoxComponentEmpty v-else />

        <Pagination v-if="certificationData?.meta" :links="certificationData.meta.links"
            :total="certificationData.meta.total" :to="certificationData.meta.to" :from="certificationData.meta.from" />
    </LayoutAuthenticated>
</template>

<script setup>
import BaseButton from "@/Components/BaseButton.vue";
import BaseButtons from "@/Components/BaseButtons.vue";
import CardBox from "@/Components/CardBox.vue";
import CardBoxComponentEmpty from "@/Components/CardBoxComponentEmpty.vue";
import CSVUpload from "@/Components/CSVUpload.vue";
import HeadLogo from "@/Components/HeadLogo.vue";
import LayoutAuthenticated from "@/Layouts/LayoutAuthenticated.vue";
import Pagination from "@/Components/Pagination.vue";
import SearchBar from "@/Components/SearchBar.vue";
import SectionTitleLineWithButton from "@/Components/SectionTitleLineWithButton.vue";
import SortableHeader from '@/Components/Table/SortableHeader.vue';
import { mdiOfficeBuilding, mdiPencil, mdiPlus, mdiTrashCan } from "@mdi/js";
import { useCertification, enableCertification } from "../Composables/useCertification";
import { useFilters } from "@/Hooks/useFilters";
import { verifyPermission } from "@/Hooks/usePermissions";
import TableCheckboxCell from "@/Components/TableCheckboxCell.vue";

const props = defineProps({
    title: {
        type: String,
        required: true
    },
    routeName: {
        type: String,
        required: true
    },
    certificationData: {
        type: Object,
        required: true
    },
    filters: {
        type: Object,
        required: true
    },
    model_class: {
        type: String,
        required: true,
    }
});

const { filters, clearFilters, applyFilters, isLoading, sortByColumn } = useFilters(props.filters, props.routeName);
const { deleteForm } = useCertification(props.routeName);

const canEnable = verifyPermission('institutions.certifications.enable');

const deleteCertification = (certification) => {
    deleteForm(certification);
}

</script>
