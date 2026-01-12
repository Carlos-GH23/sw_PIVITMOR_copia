<template>
    <CardBox v-if="capabilities.data.length > 0">
        <table>
            <thead>
                <tr>
                    <th v-if="canEnable"></th>
                    <SortableHeader column="title" label="Título" />
                    <SortableHeader column="start_date" label="Fecha inicio" />
                    <SortableHeader column="end_date" label="Fecha fin" />
                    <SortableHeader column="department" label="Departamento Académico" />
                    <SortableHeader column="status" label="Estatus" />
                    <th> Acciones </th>
                </tr>
            </thead>

            <tbody>
                <tr v-for="item in capabilities.data" :key="item.id">
                    <TableCheckboxCell v-if="canEnable" @confirm="enableCapability(item.id)" type="switch"
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

                    <td data-label="Departamento Académico">
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
                            <BaseButton color="info" :icon="mdiEye" :routeName="`${routeName}show`" :parameter="item.id"
                                small title="Ver capacidad" />

                            <BaseButton v-if="canEdit && (item.status.id === 1 || item.status.id === 4)" color="info"
                                :icon="mdiPencil" small :routeName="`${routeName}edit`" :parameter="item.id"
                                title="Editar capacidad" />

                            <BaseButton v-if="canDelete && item.status.id !== 2" @click="deleteCapability(item.id)"
                                color="danger" :icon="mdiTrashCan" small title="Eliminar capacidad" />

                            <BaseButton v-if="canEdit && item.status.id === 6" @click="openForm(item)" color="info"
                                :icon="mdiCalendarRefresh" small title="Ampliar vigencia" />
                        </BaseButtons>
                    </td>
                </tr>
            </tbody>
        </table>
    </CardBox>

    <CardBoxComponentEmpty v-else />

    <Pagination :links="capabilities.meta.links" :total="capabilities.meta.total" :to="capabilities.meta.to"
        :from="capabilities.meta.from" />
</template>

<script setup>
import Badge from '@/Components/Badge.vue';
import BaseButton from '@/Components/BaseButton.vue';
import BaseButtons from '@/Components/BaseButtons.vue';
import CardBox from '@/Components/CardBox.vue';
import CardBoxComponentEmpty from '@/Components/CardBoxComponentEmpty.vue';
import Pagination from '@/Components/Pagination.vue';
import SortableHeader from '@/Components/Table/SortableHeader.vue';
import TableCheckboxCell from '@/Components/TableCheckboxCell.vue';
import { mdiCalendarRefresh, mdiEye, mdiPencil, mdiTrashCan } from '@mdi/js';
import { verifyPermission } from '@/Hooks/usePermissions';
import { deleteCapability, enableCapability } from '../Composables/useCapability';

defineProps({
    capabilities: Object,
    routeName: String,
});

const emit = defineEmits(['openForm']);

const openForm = (item) => emit('openForm', item);

const canEdit = verifyPermission('capabilities.update');
const canDelete = verifyPermission('capabilities.delete');
const canEnable = verifyPermission('capabilities.enable');
</script>