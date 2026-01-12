<template>
    <CardBox v-if="technologyServices?.data?.length > 0">
        <table>
            <thead>
                <tr>
                    <th v-if="canEnable()"></th>
                    <SortableHeader label="Título" column="title" />
                    <SortableHeader label="Fecha Inicio" column="start_date" />
                    <SortableHeader label="Fecha Cierre" column="end_date" />
                    <SortableHeader v-if="useRoles(['IES/CI', 'Academico'])" label="Departamento Académico" column="department" />
                    <SortableHeader label="Estatus" column="status" />
                    <th>Acciones</th>
                </tr>
            </thead>

            <tbody>
                <tr v-for="item in technologyServices?.data || []" :key="item.id">

                    <TableCheckboxCell v-if="canEnable()" @confirm="enableService(item.id)" type="switch"
                        v-model="item.is_active" confirm />

                    <td data-label="Título">
                        {{ item.title }}
                    </td>
                    <td data-label="Fecha Inicio">
                        <span v-if="item.start_date?.human">
                            {{ item.start_date?.human }}
                        </span>

                        <Badge v-else variant="soft">
                            No especificado
                        </Badge>
                    </td>
                    <td data-label="Fecha Fin">
                        <span v-if="item.end_date?.human">
                            {{ item.end_date?.human }}
                        </span>

                        <Badge v-else variant="soft">
                            No especificado
                        </Badge>
                    </td>
                    <td data-label="Departamento Académico" v-if="useRoles(['Academico', 'IES/CI'])">
                        <span v-if="item.department">
                            {{ item.department.name }}
                        </span>

                        <Badge v-else variant="soft">
                            No asignado
                        </Badge>
                    </td>
                    <td data-label="Estatus">
                        <Badge v-if="item.status?.name" :color="item.status.color" showDot variant="soft">
                            {{ item.status.name }}
                        </Badge>
                    </td>
                    <td data-label="Acciones">
                        <BaseButtons>
                            <BaseButton color="info" :icon="mdiEye" small title="Ver necesidad"
                                :routeName="`${routeName}show`" :parameter="item.id" />
                            <BaseButton v-if="canEdit(item.technology_service_status_id)" color="info" :icon="mdiPencil"
                                :routeName="`${routeName}edit`" :parameter="item.id" title="Editar" />
                            <BaseButton v-if="canDelete(item.technology_service_status_id)" color="danger"
                                :icon="mdiTrashCan" title="Eliminar" @click="deleteService(item.id)" />
                            <BaseButton v-if="canExtendValidity(item.technology_service_status_id)" color="info"
                                :icon="mdiCalendarRefresh" @click="openForm(item)" small title="Ampliar vigencia" />
                        </BaseButtons>
                    </td>
                </tr>
            </tbody>
        </table>
    </CardBox>

    <CardBoxComponentEmpty v-else />

    <Pagination :links="technologyServices?.meta?.links || []" :total="technologyServices?.meta?.total || 0"
        :to="technologyServices?.meta?.to || 0" :from="technologyServices?.meta?.from || 0" />
</template>

<script setup>
import Badge from '@/Components/Badge.vue';
import BaseButton from '@/Components/BaseButton.vue';
import BaseButtons from '@/Components/BaseButtons.vue';
import CardBox from '@/Components/CardBox.vue';
import CardBoxComponentEmpty from '@/Components/CardBoxComponentEmpty.vue';
import Pagination from '@/Components/Pagination.vue';
import SortableHeader from '@/Components/Table/SortableHeader.vue';
import { mdiCalendarRefresh, mdiEye, mdiPencil, mdiTrashCan } from '@mdi/js';
import { verifyPermission, useRoles } from '@/Hooks/usePermissions';
import { deleteService, enableService } from '../Composables/useService';
import TableCheckboxCell from '@/Components/TableCheckboxCell.vue';

const props = defineProps({
    technologyServices: Object,
    routeName: String,
});

const emit = defineEmits(['openForm']);

const openForm = (item) => emit('openForm', item);

const canEdit = (status) => verifyPermission(`${props.routeName}update`) && !(status === 2 || status === 3 || status === 5 || status === 6)
const canDelete = (status) => verifyPermission(`${props.routeName}delete`) && status !== 2
const canEnable = () => verifyPermission(`${props.routeName}enable`)
const canExtendValidity = (status) => verifyPermission(`${props.routeName}update`) && status === 6
</script>