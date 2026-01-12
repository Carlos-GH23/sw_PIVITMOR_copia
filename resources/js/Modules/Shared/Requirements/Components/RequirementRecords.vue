<template>
    <CardBox v-if="requirements.data.length > 0">
        <table>
            <thead>
                <tr>
                    <th v-if="canEnable()" />
                    <SortableHeader column="title" label="Titulo" />
                    <SortableHeader column="department" v-if="useRoles(['Academico', 'IES/CI'])" label="Departamento" />
                    <SortableHeader column="start_date" label="Fecha de inicio" />
                    <SortableHeader column="end_date" label="Fecha de cierre" />
                    <SortableHeader column="status" label="Estatus" />
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="item in requirements.data" :key="item.id">
                    <TableCheckboxCell v-if="canEnable()" @confirm="enableForm(item.id)" type="switch"
                        v-model="item.is_active" confirm />
                    <td data-label="Titulo">
                        <div class="leading-relaxed line-clamp-2">
                            {{ item.title }}
                        </div>
                    </td>
                    <td data-label="Departamento" v-if="useRoles(['Academico', 'IES/CI'])">
                        {{ item.department?.name }}
                    </td>
                    <td data-label="Inicio">
                        {{ item.start_date.human }}
                    </td>
                    <td data-label="Fin">
                        {{ item.end_date.human }}
                    </td>
                    <td data-label="Estatus">
                        <Badge :color="item.requirement_status.color" size="md" showDot
                            :title="item.requirement_status.description">
                            {{ item.requirement_status.name }}
                        </Badge>
                    </td>
                    <td data-label="acciones">
                        <BaseButtons>
                            <BaseButton color="info" :icon="mdiEye" small title="Ver necesidad"
                                :routeName="`${routeName}show`" :parameter="item.id" />
                            <BaseButton v-if="canEdit(item.requirement_status.id)" color="info" :icon="mdiPencil"
                                :routeName="`${routeName}edit`" :parameter="item.id" title="Editar" />
                            <BaseButton v-if="canDelete(item.requirement_status.id)" color="danger" :icon="mdiTrashCan"
                                title="Eliminar" @click="deleteForm(item.id)" />
                            <BaseButton v-if="canExtendValidity(item.requirement_status.id)" color="info"
                                :icon="mdiCalendarRefresh" @click="openForm(item)" small title="Ampliar vigencia" />
                        </BaseButtons>
                    </td>
                </tr>
            </tbody>
        </table>
    </CardBox>
    <CardBoxComponentEmpty v-else />
    <pagination :links="requirements.meta.links" :total="requirements.meta.total" :to="requirements.meta.to"
        :from="requirements.meta.from" />
</template>
<script setup>
import CardBox from "@/Components/CardBox.vue";
import {
    mdiCalendarRefresh,
    mdiEye,
    mdiPencil,
    mdiTrashCan,
} from "@mdi/js";
import BaseButton from "@/Components/BaseButton.vue";
import BaseButtons from "@/Components/BaseButtons.vue";
import CardBoxComponentEmpty from "@/Components/CardBoxComponentEmpty.vue";
import Pagination from "@/Components/Pagination.vue";
import Badge from "@/Components/Badge.vue";
import { useRoles, verifyPermission } from "@/Hooks/usePermissions";
import { deleteForm, enableForm } from "../Composables/useRequirement";
import TableCheckboxCell from "@/Components/TableCheckboxCell.vue";
import SortableHeader from "@/Components/Table/SortableHeader.vue";

const props = defineProps({
    requirements: Object,
    routeName: String,
});

const canEdit = (status) => verifyPermission(`${props.routeName}update`) && (status === 1 || status === 4 || status === 5)
const canDelete = (status) => verifyPermission(`${props.routeName}delete`) && status !== 2
const canEnable = () => verifyPermission(`${props.routeName}enable`)
const canExtendValidity = (status) => verifyPermission(`${props.routeName}update`) && status === 6

const emit = defineEmits(['openForm']);

const openForm = (item) => emit('openForm', item);
</script>