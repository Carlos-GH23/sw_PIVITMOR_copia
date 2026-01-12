<template>
    <HeadLogo :title="title" />
    <loading v-model:active="isLoading" :can-cancel="false" :is-full-page="true" loader="dots" color="#283C2A" />
    <LayoutMain>
        <SectionTitleLineWithButton :icon="mdiAccountMultiple" :title="title" main />

        <SearchBar @apply-filters="applyFilters" @clear-filters="clearFilters" v-model:search="filters.search"
            v-model:rows="filters.rows" :routeName="routeName" title="conferencias" :total="conferences.meta.total" />

        <CardBox v-if="conferences.data.length > 0">
            <table>
                <thead>
                    <tr>
                        <th v-if="canEnable"></th>
                        <SortableHeader @sort="sortByColumn" :filters="filters" column="title" label="Título" />
                        <SortableHeader @sort="sortByColumn" :filters="filters" column="modality" label="Modalidad" />
                        <SortableHeader @sort="sortByColumn" :filters="filters" column="department_id" label="Departamento" />
                        <SortableHeader @sort="sortByColumn" :filters="filters" column="conference_status_id" label="Estatus" />
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="item in conferences.data" :key="item.id">
                        <td v-if="!canEnable"></td>
                        <TableCheckboxCell v-if="canEnable && item.conference_status_id !== 1"
                            @confirm="enableConference(item)" type="switch"
                            :model-value="item.conference_status_id === 2" confirm />
                        <td v-else-if="canEnable"></td>

                        <td data-label="Título">
                            <div>
                                <p>{{ item.title }}</p>
                            </div>
                        </td>
                        <td data-label="Modalidad">
                            {{ item.modality || 'N/A' }}
                        </td>
                        <td data-label="Departamento">
                            {{ item.department?.name || 'N/A' }}
                        </td>
                        <td data-label="Estatus">
                            <Badge v-if="item.status?.name" :color="item.status.color" showDot variant="soft">
                                {{ item.status.name }}
                            </Badge>
                            <span v-else>N/A</span>
                        </td>
                        <td data-label="Acciones">
                            <BaseButtons>
                                <BaseButton color="info" :icon="mdiEye" small :routeName="`${routeName}show`"
                                    :parameter="item.id" title="Ver conferencia" />

                                <BaseButton
                                    v-if="canEdit"
                                    color="info" :icon="mdiPencil" small :routeName="`${routeName}edit`"
                                    :parameter="item.id" title="Editar conferencia" />

                                <BaseButton v-if="canDelete"
                                    @click="deleteConference(item)" color="danger" :icon="mdiDelete" small
                                    title="Eliminar conferencia" />
                            </BaseButtons>
                        </td>
                    </tr>
                </tbody>
            </table>
        </CardBox>
        <CardBoxComponentEmpty v-else />
        <pagination :links="conferences.meta.links" :total="conferences.meta.total" :to="conferences.meta.to"
            :from="conferences.meta.from" />
    </LayoutMain>
</template>
<script setup>
import CardBox from "@/Components/CardBox.vue";
import LayoutMain from "@/Layouts/LayoutMain.vue";
import SectionTitleLineWithButton from "@/Components/SectionTitleLineWithButton.vue";
import {
    mdiAccountMultiple,
    mdiDelete,
    mdiPencil,
    mdiEye,
} from "@mdi/js";
import BaseButton from "@/Components/BaseButton.vue";
import BaseButtons from "@/Components/BaseButtons.vue";
import CardBoxComponentEmpty from "@/Components/CardBoxComponentEmpty.vue";
import Pagination from "@/Components/Pagination.vue";
import HeadLogo from "@/Components/HeadLogo.vue";
import { useFilters } from "@/Hooks/useFilters";
import SearchBar from "@/Components/SearchBar.vue";
import { useConference, enableConference } from "../Composables/useConference.js";
import { verifyPermission } from "@/Hooks/usePermissions";
import TableCheckboxCell from "@/Components/TableCheckboxCell.vue";
import Badge from "@/Components/Badge.vue";
import SortableHeader from "@/Components/Table/SortableHeader.vue";
import { usePageTracker } from '@/Hooks/usePageTracker';

const props = defineProps({
    title: String,
    routeName: String,
    conferences: Object,
    filters: Object,
});

const { filters, clearFilters, applyFilters, isLoading, sortByColumn } = useFilters(props.filters, props.routeName);

const { deleteForm } = useConference(props);

const canEnable = verifyPermission('conferences.enable');
const canEdit = verifyPermission('conferences.update');
const canDelete = verifyPermission('conferences.delete');

const deleteConference = (conference) => {
    deleteForm(conference);
}

usePageTracker();
</script>
