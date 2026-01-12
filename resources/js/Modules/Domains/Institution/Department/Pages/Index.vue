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
            v-model:rows="filters.rows" :routeName="routeName" :total="departmentData?.meta?.total" />

        <CardBox v-if="departmentData?.data && departmentData.data.length > 0">
            <table>
                <thead>
                    <tr>
                        <th v-if="canEnable"></th>
                        <SortableHeader @sort="sortByColumn" :filters="filters" column="name" label="Nombre" />
                        <th class="w-32">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="item in departmentData.data" :key="item.id">
                        <TableCheckboxCell v-if="canEnable" @confirm="enableDepartment(item.id)" type="switch"
                            v-model="item.is_active" confirm />
                        <td data-label="Nombre">{{ item.name }}</td>
                        <td data-label="Acciones">
                            <BaseButtons>
                                <BaseButton color="info" :icon="mdiPencil" small :routeName="`${routeName}edit`"
                                    :parameter="item.id" title="Editar departamento" />
                                <BaseButton color="danger" :icon="mdiTrashCan" small @click="deleteForm(item)"
                                    title="Eliminar departamento" />
                            </BaseButtons>
                        </td>
                    </tr>
                </tbody>
            </table>
        </CardBox>
        <CardBoxComponentEmpty v-else />

        <Pagination :links="departmentData.meta.links" :total="departmentData.meta.total" :to="departmentData.meta.to"
            :from="departmentData.meta.from" />
    </LayoutAuthenticated>
</template>

<script setup>
import BaseButton from "@/Components/BaseButton.vue";
import BaseButtons from "@/Components/BaseButtons.vue";
import CardBox from "@/Components/CardBox.vue";
import CardBoxComponentEmpty from "@/Components/CardBoxComponentEmpty.vue";
import HeadLogo from "@/Components/HeadLogo.vue";
import LayoutAuthenticated from "@/Layouts/LayoutAuthenticated.vue";
import Pagination from "@/Components/Pagination.vue";
import SearchBar from "@/Components/SearchBar.vue";
import SectionTitleLineWithButton from "@/Components/SectionTitleLineWithButton.vue";
import SortableHeader from '@/Components/Table/SortableHeader.vue';
import { useFilters } from "@/Hooks/useFilters";
import { router } from "@inertiajs/vue3";
import { messageConfirm } from '@/Hooks/useErrorsForm';
import { mdiSchool, mdiPencil, mdiPlus, mdiTrashCan } from "@mdi/js";
import TableCheckboxCell from "@/Components/TableCheckboxCell.vue";
import { verifyPermission } from '@/Hooks/usePermissions';

const props = defineProps({
    title: {
        type: String,
        required: true
    },
    routeName: {
        type: String,
        required: true
    },
    departmentData: {
        type: Object,
        required: true
    },
    filters: {
        type: Object,
        required: true,
    },
});

const { filters, clearFilters, applyFilters, isLoading, sortByColumn } = useFilters(props.filters, props.routeName);

const deleteForm = (department) => {
    messageConfirm().then((res) => {
        if (res.isConfirmed) {
            router.delete(route(`${props.routeName}destroy`, department.id));
        }
    });
};

const canEnable = verifyPermission('institutions.departments.enable');

const enableDepartment = async (departmentId) => {
    router.patch(route("institutions.departments.enable", departmentId), {
        preserveScroll: true,
        preserveState: true,
        onSuccess: () => {
            resolve(true);
        },
        onError: () => {
            reject(false);
        },
    });
};
</script>
